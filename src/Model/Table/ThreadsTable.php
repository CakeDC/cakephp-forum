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
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use CakeDC\Forum\Model\Entity\Reply;
use CakeDC\Forum\Model\Entity\Thread;

/**
 * Threads Model
 *
 * @property \CakeDC\Forum\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $Users
 * @property \CakeDC\Forum\Model\Table\RepliesTable&\Cake\ORM\Association\HasOne $UserReplies
 * @property \CakeDC\Forum\Model\Table\RepliesTable&\Cake\ORM\Association\BelongsTo $LastReplies
 * @property \CakeDC\Forum\Model\Table\RepliesTable&\Cake\ORM\Association\HasOne $ReportedReplies
 * @property \CakeDC\Forum\Model\Table\RepliesTable&\Cake\ORM\Association\HasMany $Replies
 * @property \CakeDC\Forum\Model\Table\ReportsTable&\Cake\ORM\Association\HasMany $Reports
 * @property \CakeDC\Forum\Model\Table\LikesTable&\Cake\ORM\Association\HasMany $Likes
 *
 * @method \CakeDC\Forum\Model\Entity\Thread newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Thread newEmptyEntity()
 * @method \CakeDC\Forum\Model\Entity\Thread[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Thread|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Thread patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Thread[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Thread findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Slug\Model\Behavior\SlugBehavior
 * @mixin \Muffin\Orderly\Model\Behavior\OrderlyBehavior
 */
class ThreadsTable extends Table
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
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Categories')->setClassName('CakeDC/Forum.Categories')->setJoinType('INNER');
        $this->hasMany('Replies')->setClassName('CakeDC/Forum.Replies')->setForeignKey('parent_id')->setDependent(true)->setCascadeCallbacks(true);
        $this->hasOne('UserReplies')->setClassName('CakeDC/Forum.Replies')->setForeignKey('parent_id');
        $this->belongsTo('LastReplies')->setClassName('CakeDC/Forum.Posts')->setForeignKey('last_reply_id');
        $this->hasOne('ReportedReplies')->setClassName('CakeDC/Forum.Replies')->setForeignKey('parent_id')->setConditions([
            'ReportedReplies.reports_count >' => 0,
        ]);
        $this->hasMany('Reports')->setClassName('CakeDC/Forum.Reports')->setForeignKey('post_id');
        $this->hasMany('Likes')->setClassName('CakeDC/Forum.Likes')->setForeignKey('post_id');
        $this->belongsTo('Users')->setClassName(Configure::read('Forum.userModel'))->setJoinType('INNER');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'last_reply_created' => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);
        $this->addBehavior('Muffin/Slug.Slug');
        $this->addBehavior('Muffin/Orderly.Orderly', [
            'order' => [
                $this->aliasField('is_sticky') => 'DESC',
                $this->aliasField('last_reply_created') => 'DESC',
            ],
        ]);

        $options = [
            'Categories' => [
                'threads_count',
                'last_post_id' => function ($event, Thread $entity, ThreadsTable $table) {
                    $Posts = TableRegistry::getTableLocator()->get('CakeDC/Forum.Posts');
                    $lastPost = $Posts->find()->where(['category_id' => $entity->category_id])->orderByDesc('id')->first();
                    if (!$lastPost) {
                        return null;
                    }

                    return $lastPost['id'];
                },
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
            ->notEmptyString('category_id');

        $validator
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->allowEmptyString('slug');

        $validator
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        $validator
            ->boolean('is_sticky')
            ->allowEmptyString('is_sticky');

        $validator
            ->boolean('is_locked')
            ->allowEmptyString('is_locked');

        $validator
            ->boolean('is_visible')
            ->allowEmptyString('is_visible');

        return $validator;
    }

    /**
     * Admin move Thread validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationMoveThread(Validator $validator): Validator
    {
        $validator
            ->requirePresence('category_id')
            ->notEmptyString('category_id');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, bool $primary): void
    {
        if (!Hash::get($options, 'all')) {
            $query->where([$query->expr()->isNull($this->aliasField('parent_id'))]);
        }
    }

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {
        if ($entity->isDirty('category_id')) {
            $this->Replies->find()->where(['parent_id' => $entity['id']])->all()->each(function (Reply $reply) use ($entity) {
                $reply->category_id = $entity->get('category_id');
                $this->Replies->saveOrFail($reply);
            });
        }

        if ($entity->isNew()) {
            $entity->set('last_reply_id', $entity['id']);
            $this->save($entity);
        }
    }

    /**
     * Find threads by category
     */
    public function findByCategory(SelectQuery $query, int $category_id): SelectQuery
    {
        return $query
            ->where([
                $this->aliasField('category_id') => $category_id,
            ])
            ->contain(['Users', 'LastReplies' => ['Users'], 'ReportedReplies'])
            ->groupBy($this->aliasField('id'));
    }

    /**
     * Find threads user has started or participated in
     */
    public function findByUser(SelectQuery $query, int|string $user_id): SelectQuery
    {
        return $query
            ->contain([
                'Users',
                'LastReplies' => ['Users'],
                'ReportedReplies',
                'Categories',
                'UserReplies' => fn(SelectQuery $q): SelectQuery => $q->where(['UserReplies.user_id' => $user_id]),
            ])
            ->where([
                'OR' => [
                    $this->aliasField('user_id') => $user_id,
                    'UserReplies.user_id' => $user_id,
                ],
            ])
            ->groupBy($this->aliasField('id'));
    }

    /**
     * Find threads for edit
     *
     * @uses \Muffin\Slug\Model\Behavior\SlugBehavior::findSlugged()
     */
    public function findForEdit(SelectQuery $query, int $category_id, string $slug): SelectQuery
    {
        return $query
            ->where([$this->aliasField('category_id') => $category_id])
            ->find('slugged', slug: $slug);
    }
}
