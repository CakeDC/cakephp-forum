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

use Cake\Core\Configure;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ForumReports Model
 *
 * @property \CakeDC\Forum\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $Users
 * @method \CakeDC\Forum\Model\Entity\Report newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report newEmptyEntity()
 * @method \CakeDC\Forum\Model\Entity\Report[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Report findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
 */
class ReportsTable extends Table
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

        $this->setTable('forum_reports');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Posts' => [
                'reports_count',
            ],
        ]);

        $this->belongsTo('Posts')
            ->setClassName('CakeDC/Forum.Posts')
            ->setJoinType('INNER');

        $this->belongsTo('Users')
            ->setClassName(Configure::read('Forum.userModel'))
            ->setJoinType('INNER');
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
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * Find filtered
     */
    public function findFiltered(
        SelectQuery $query,
        int|string|null $post_id = null,
        int|string|null $thread_id = null,
        int|string|null $category_id = null
    ): SelectQuery {
        $where = [];
        if ($post_id) {
            $where['Reports.post_id'] = $post_id;
        } elseif ($thread_id) {
            $where['OR'] = [
                'Posts.id' => $thread_id,
                'Posts.parent_id' => $thread_id,
            ];
        }
        if (!is_null($category_id)) {
            $where['Posts.category_id IN'] = (array)$category_id;
        }

        return $query
            ->contain([
                'Users',
                'Posts' => ['Categories', 'Users', 'Threads.Users'],
            ])
            ->where($where);
    }
}
