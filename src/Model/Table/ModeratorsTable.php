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
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Moderators Model
 *
 * @property \CakeDC\Forum\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \CakeDC\Forum\Model\Entity\Moderator get($primaryKey, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Moderator newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Moderator[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Moderator|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Moderator patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Moderator[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Moderator findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModeratorsTable extends Table
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

        $this->setTable('forum_moderators');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'className' => 'CakeDC/Forum.Categories',
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
            ->integer('user_id')
            ->notEmpty('user_id');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * Get user categories
     *
     * @param int $userId User id
     * @return array
     */
    public function getUserCategories($userId)
    {
        return $this->find()
            ->where(['user_id' => $userId])
            ->extract('category_id')
            ->toArray();
    }
}
