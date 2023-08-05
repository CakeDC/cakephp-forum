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
use Cake\ORM\Table;
use Cake\Utility\Hash;
use InvalidArgumentException;

/**
 * Posts Model
 *
 * @property \CakeDC\Forum\Model\Table\ThreadsTable&\Cake\ORM\Association\BelongsTo $Threads
 * @property \CakeDC\Forum\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $Users
 * @property \CakeDC\Forum\Model\Table\LikesTable&\Cake\ORM\Association\HasOne $UserLikes
 * @property \CakeDC\Forum\Model\Table\ReportsTable&\Cake\ORM\Association\HasMany $UserReports
 * @property \CakeDC\Forum\Model\Table\LikesTable&\Cake\ORM\Association\HasMany $Likes
 *
 * @method \CakeDC\Forum\Model\Entity\Post get($primaryKey, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Post newEmptyEntity()
 * @method \CakeDC\Forum\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakeDC\Forum\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \CakeDC\Forum\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Orderly\Model\Behavior\OrderlyBehavior
 */
class PostsTable extends Table
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

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Orderly.Orderly', ['order' => $this->aliasField('id')]);

        $this->belongsTo('Threads')->setClassName('CakeDC/Forum.Threads')->setForeignKey('parent_id');
        $this->belongsTo('Categories')->setClassName('CakeDC/Forum.Categories')->setJoinType('INNER');
        $this->belongsTo('Users')->setClassName(Configure::read('Forum.userModel'));
        $this->hasOne('UserLikes')->setClassName('CakeDC/Forum.Likes')->setForeignKey('post_id');
        $this->hasOne('UserReports')->setClassName('CakeDC/Forum.Reports')->setForeignKey('post_id');
        $this->hasMany('Likes')->setClassName('CakeDC/Forum.Likes')->setForeignKey('post_id');
    }

    /**
     * Find posts by thread
     *
     * @param \Cake\ORM\Query\SelectQuery $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByThread(SelectQuery $query, array $options = []): SelectQuery
    {
        $parentId = Hash::get($options, 'thread_id');
        if (!$parentId) {
            throw new InvalidArgumentException('thread_id is required');
        }

        return $query
            ->where([
                'OR' => [
                    $this->aliasField('id') => $parentId,
                    $this->aliasField('parent_id') => $parentId,
                ],
            ])
            ->contain(['Users', 'Likes.Users']);
    }

    /**
     * Find posts with user report
     *
     * @param \Cake\ORM\Query\SelectQuery $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithUserReport(SelectQuery $query, array $options = []): SelectQuery
    {
        $userId = Hash::get($options, 'user_id');
        if (!$userId) {
            throw new InvalidArgumentException('user_id is required');
        }

        return $query->contain([
            'UserReports' => fn(SelectQuery $q): SelectQuery => $q
                ->where([
                    'UserReports.user_id' => $userId,
                ]),
        ]);
    }

    /**
     * Find posts with user like
     *
     * @param \Cake\ORM\Query\SelectQuery $query The query builder.
     * @param array $options Options.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithUserLike(SelectQuery $query, array $options = []): SelectQuery
    {
        $userId = Hash::get($options, 'user_id');
        if (!$userId) {
            throw new InvalidArgumentException('user_id is required');
        }

        return $query->contain([
            'UserLikes' => fn(SelectQuery $q): SelectQuery => $q
                ->where([
                    'UserLikes.user_id' => $userId,
                ]),
        ]);
    }
}
