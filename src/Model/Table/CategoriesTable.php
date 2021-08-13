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

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * ForumCategories Model
 *
 * @property \CakeDC\Forum\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \CakeDC\Forum\Model\Table\CategoriesTable|\Cake\ORM\Association\HasMany $ChildCategories
 * @property \CakeDC\Forum\Model\Table\ModeratorsTable|\Cake\ORM\Association\HasMany $Moderators
 * @property \CakeDC\Forum\Model\Table\PostsTable|\Cake\ORM\Association\HasMany $Posts
 * @method \CakeDC\Forum\Model\Entity\Category get($primaryKey, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Category newEmptyEntity()
 * @method \CakeDC\Forum\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class CategoriesTable extends Table
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

        $this->setTable('forum_categories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('Muffin/Slug.Slug');
        $this->addBehavior('Muffin/Orderly.Orderly', ['order' => $this->aliasField('lft')]);

        $this->hasMany('Threads')->setClassName('CakeDC/Forum.Threads')->setConditions([
            'Threads.parent_id IS' => null,
        ]);
        $this->belongsTo('LastPosts')->setClassName('CakeDC/Forum.Posts')->setForeignKey('last_post_id');
        $this->belongsTo('ParentCategories')->setClassName('CakeDC/Forum.Categories')->setForeignKey('parent_id');
        $this->hasMany('SubCategories')->setClassName('CakeDC/Forum.Categories')->setForeignKey('parent_id');
        $this->hasMany('Moderators')->setClassName('CakeDC/Forum.Moderators')->setForeignKey('category_id');
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
            ->requirePresence('title', 'create')
            ->notBlank('title');

        $validator
            ->allowEmptyString('slug');

        $validator
            ->allowEmptyString('description');

        $validator
            ->integer('threads_count');

        $validator
            ->integer('replies_count');

        $validator
            ->boolean('is_visible')
            ->requirePresence('is_visible', 'create')
            ->notEmptyString('is_visible');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentCategories', ['allowNullableNulls' => true]));

        return $rules;
    }

    /**
     * Get options list for dropdown
     *
     * @param bool $grouped Grouped
     * @return array
     */
    public function getOptionsList($grouped = false)
    {
        $categories = $this->find()->all()->nest('id', 'parent_id');

        if ($grouped) {
            $result = [];
            foreach ($categories->toArray() as $category) {
                if ($category->children) {
                    $result[$category->title] = collection($category->children)->indexBy('id')->extract('title')->toArray();
                } else {
                    $result[$category->id] = $category->title;
                }
            }

            return $result;
        } else {
            return $categories
                ->listNested()
                ->printer('title', 'id', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
                ->toArray();
        }
    }

    /**
     * Find category children
     *
     * @param \Cake\ORM\Query $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query
     */
    public function findChildren(Query $query, $options = [])
    {
        $category = Hash::get($options, 'category');
        if (!$category) {
            throw new InvalidArgumentException('Category is required');
        }

        return $query
            ->where([
                $query->newExpr()->gt('lft', $category->get('lft')),
                $query->newExpr()->lt('rght', $category->get('rght')),
            ])
            ->contain(['LastPosts.Users', 'LastPosts.Threads']);
    }
}
