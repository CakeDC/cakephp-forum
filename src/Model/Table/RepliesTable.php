<?php
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
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

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
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('forum_posts');
        $this->setDisplayField('message');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Orderly.Orderly', ['order' => $this->aliasField('id')]);

        $options = [
            'Categories' => [
                'replies_count'
            ],
            'Threads' => [
                'last_reply_created' => function ($event, \CakeDC\Forum\Model\Entity\Reply $entity, RepliesTable $table) {
                    if (!$lastReply = $table->find('lastReply')->where(['parent_id' => $entity->parent_id])->first()) {
                        return null;
                    }

                    return $lastReply->get('created');
                },
                'replies_count',
            ],
        ];
        if ($userPostsCountField = Configure::read('Forum.userPostsCountField')) {
            $options['Users'] = [$userPostsCountField => ['all' => true]];
        }
        $this->addBehavior('CounterCache', $options);

        $this->belongsTo('Threads', [
            'className' => 'CakeDC/Forum.Threads',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Categories', [
            'className' => 'CakeDC/Forum.Categories',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Reports', [
            'className' => 'CakeDC/Forum.Reports',
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('Likes', [
            'className' => 'CakeDC/Forum.Likes',
            'foreignKey' => 'post_id'
        ]);
        $this->belongsTo('Users', [
            'className' => Configure::read('Forum.userModel'),
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
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
        if (!($categorySlug = Hash::get($options, 'categorySlug')) || !($threadSlug = Hash::get($options, 'threadSlug'))) {
            throw new \InvalidArgumentException('categorySlug and threadSlug are required');
        }

        return $query->contain([
            'Users',
            'Categories' => function (Query $query) use ($categorySlug) {
                return $query->find('slugged', ['slug' => $categorySlug]);
            },
            'Threads' => function (Query $query) use ($threadSlug) {
                return $query->find('slugged', ['slug' => $threadSlug]);
            },
            'Threads.Users'
        ]);
    }

    /**
     * beforeFind callback
     *
     * @param Event $event Event
     * @param Query $query Query
     * @param ArrayObject $options Options
     * @param bool $primary Primary
     */
    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary)
    {
        if (!Hash::get($options, 'all')) {
            $query->where([$query->newExpr()->isNotNull($this->aliasField('parent_id'))]);
        }
    }
}
