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

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * ForumReports Model
 *
 * @property \CakeDC\Forum\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \CakeDC\Forum\Model\Entity\Report get($primaryKey, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReportsTable extends Table
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

        $this->setTable('forum_reports');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Posts' => [
                'reports_count'
            ],
        ]);

        $this->belongsTo('Posts', [
            'className' => 'CakeDC/Forum.Posts',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * Find filtered
     *
     * @param \Cake\ORM\Query $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query
     */
    public function findFiltered(Query $query, $options = [])
    {
        $where = [];
        $contain = [
            'Users',
            'Posts' => ['Categories', 'Users', 'Threads.Users']
        ];

        if ($postId = Hash::get($options, 'post_id')) {
            $where['Reports.post_id'] = $postId;
        } elseif ($threadId = Hash::get($options, 'thread_id')) {
            $where['OR'] = [
                'Posts.id' => $threadId,
                'Posts.parent_id' => $threadId,
            ];
        }

        if (!is_null($categoryId = Hash::get($options, 'category_id'))) {
            $where['Posts.category_id IN'] = (array)$categoryId;
        }

        return $query
            ->contain($contain)
            ->where($where);
    }
}
