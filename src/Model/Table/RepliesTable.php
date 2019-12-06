<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\Forum\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use CakeDC\Forum\Model\Entity\Reply;
use InvalidArgumentException;

/**
 * Replies Model
 *
 * @property \CakeDC\Forum\Model\Table\ThreadsTable|\Cake\ORM\Association\BelongsTo $Threads
 * @property \CakeDC\Forum\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \CakeDC\Forum\Model\Table\ReportsTable|\Cake\ORM\Association\HasMany $Reports
 *
 * @method \CakeDC\Forum\Model\Entity\Reply get($primaryKey, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RepliesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('forum_posts');
        $this->setDisplayField('message');
        $this->setPrimaryKey('id');

        $this->belongsTo('Threads', [
            'className' => 'CakeDC/Forum.Threads',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('Categories', [
            'className' => 'CakeDC/Forum.Categories',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Reports', [
            'className' => 'CakeDC/Forum.Reports',
            'foreignKey' => 'post_id',
        ]);
        $this->hasMany('Likes', [
            'className' => 'CakeDC/Forum.Likes',
            'foreignKey' => 'post_id',
        ]);
        $this->belongsTo('Users', [
            'className' => Configure::read('Forum.userModel'),
            'joinType' => 'INNER',
        ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Orderly.Orderly', ['order' => $this->aliasField('id')]);

        $options = [
            'Categories' => [
                'replies_count',
                'last_post_id' => function ($event, Reply $entity, RepliesTable $table) {
                    $Posts = TableRegistry::getTableLocator()->get('CakeDC/Forum.Posts');
                    $lastPost = $Posts->find()->where(['category_id' => $entity->category_id])->orderDesc('id')->first();
                    if (!$lastPost) {
                        return null;
                    }

                    return $lastPost->id;
                },
            ],
            'Threads' => [
                'last_reply_created' => function ($event, Reply $entity, RepliesTable $table) {
                    $lastReply = $table->find()->where(['parent_id' => $entity->parent_id])->orderDesc('id')->first();
                    if (!$lastReply) {
                        return $this->Threads->get($entity->parent_id)->created;
                    }

                    return $lastReply->get('created');
                },
                'last_reply_id' => function ($event, Reply $entity, RepliesTable $table) {
                    $lastReply = $table->find()->where(['parent_id' => $entity->parent_id])->orderDesc('id')->first();
                    if (!$lastReply) {
                        return null;
                    }

                    return $lastReply->id;
                },
                'replies_count',
            ],
        ];
        $userPostsCountField = Configure::read('Forum.userPostsCountField');
        if ($userPostsCountField) {
            $options['Users'] = [$userPostsCountField => ['all' => true]];
        }
        $this->addBehavior('CounterCache', $options);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['parent_id'], 'Threads'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * Last reply finder
     *
     * @param \Cake\ORM\Query $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query
     */
    public function findLastReply(Query $query, $options = [])
    {
        return $query->orderDesc($this->aliasField('id'));
    }

    /**
     * Find by ID and parent_id
     *
     * @param \Cake\ORM\Query $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query
     */
    public function findByThreadAndCategory(Query $query, $options = [])
    {
        $categorySlug = Hash::get($options, 'categorySlug');
        $threadSlug = Hash::get($options, 'threadSlug');
        if (!$categorySlug || !$threadSlug) {
            throw new InvalidArgumentException('categorySlug and threadSlug are required');
        }

        return $query->contain([
            'Users',
            'Categories' => function (Query $query) use ($categorySlug) {
                return $query->find('slugged', ['slug' => $categorySlug]);
            },
            'Threads' => function (Query $query) use ($threadSlug) {
                return $query->find('slugged', ['slug' => $threadSlug]);
            },
            'Threads.Users',
        ]);
    }

    /**
     * beforeFind callback
     *
     * @param \Cake\Event\Event $event Event
     * @param \Cake\ORM\Query $query Query
     * @param \ArrayObject $options Options
     * @param bool $primary Primary
     */
    public function beforeFind(EventInterface $event, Query $query, ArrayObject $options, $primary)
    {
        if (!Hash::get($options, 'all')) {
            $query->where([$query->newExpr()->isNotNull($this->aliasField('parent_id'))]);
        }
    }
}
