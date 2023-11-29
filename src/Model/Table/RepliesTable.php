<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace CakeDC\Forum\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use CakeDC\Forum\Model\Entity\Reply;

/**
 * Replies Model
 *
 * @property \CakeDC\Forum\Model\Table\ThreadsTable&\Cake\ORM\Association\BelongsTo $Threads
 * @property \CakeDC\Forum\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $Users
 * @property \CakeDC\Forum\Model\Table\ReportsTable&\Cake\ORM\Association\HasMany $Reports
 * @property \CakeDC\Forum\Model\Table\LikesTable&\Cake\ORM\Association\HasMany $Likes
 * @method \CakeDC\Forum\Model\Entity\Reply newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply newEmptyEntity()
 * @method \CakeDC\Forum\Model\Entity\Reply[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Reply findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Orderly\Model\Behavior\OrderlyBehavior
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

        $this->belongsTo('Threads')
            ->setClassName('CakeDC/Forum.Threads')
            ->setForeignKey('parent_id');

        $this->belongsTo('Categories')
            ->setClassName('CakeDC/Forum.Categories')
            ->setJoinType('INNER');

        $this->hasMany('Reports')
            ->setClassName('CakeDC/Forum.Reports')
            ->setForeignKey('post_id');

        $this->hasMany('Likes')
            ->setClassName('CakeDC/Forum.Likes')
            ->setForeignKey('post_id');

        $this->belongsTo('Users')
            ->setClassName(Configure::read('Forum.userModel'))
            ->setJoinType('INNER');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Orderly.Orderly', ['order' => $this->aliasField('id')]);

        $options = [
            'Categories' => [
                'replies_count',
                'last_post_id' => function ($event, Reply $entity, RepliesTable $table) {
                    $Posts = TableRegistry::getTableLocator()->get('CakeDC/Forum.Posts');
                    $lastPost = $Posts
                        ->find()
                        ->where(['category_id' => $entity->category_id])
                        ->orderByDesc('id')
                        ->first();
                    if (!$lastPost) {
                        return null;
                    }

                    return $lastPost['id'];
                },
            ],
            'Threads' => [
                'last_reply_created' => function ($event, Reply $entity, RepliesTable $table) {
                    $lastReply = $table->find()->where(['parent_id' => $entity->parent_id])->orderByDesc('id')->first();
                    if (!$lastReply) {
                        return $this->Threads->get($entity->parent_id)->created;
                    }

                    return $lastReply['created'];
                },
                'last_reply_id' => function ($event, Reply $entity, RepliesTable $table) {
                    $lastReply = $table->find()->where(['parent_id' => $entity->parent_id])->orderByDesc('id')->first();
                    if (!$lastReply) {
                        return null;
                    }

                    return $lastReply['id'];
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
     */
    public function findLastReply(SelectQuery $query): SelectQuery
    {
        return $query->orderByDesc($this->aliasField('id'));
    }

    /**
     * Find by ID and parent_id
     *
     * @uses \Muffin\Slug\Model\Behavior\SlugBehavior::findSlugged()
     */
    public function findByThreadAndCategory(
        SelectQuery $query,
        string $categorySlug,
        string $threadSlug
    ): SelectQuery {
        return $query->contain([
            'Users',
            'Categories' => fn (SelectQuery $query): SelectQuery => $query
                ->find('slugged', slug: $categorySlug),
            'Threads' => fn (SelectQuery $query): SelectQuery => $query
                ->find('slugged', slug: $threadSlug),
            'Threads.Users',
        ]);
    }

    /**
     * BeforeFind callback
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, bool $primary): void
    {
        if (!Hash::get($options, 'all')) {
            $query->where([$query->expr()->isNotNull($this->aliasField('parent_id'))]);
        }
    }
}
