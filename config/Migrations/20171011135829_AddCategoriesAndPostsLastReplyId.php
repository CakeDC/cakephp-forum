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
use Cake\ORM\TableRegistry;
use Migrations\AbstractMigration;

class AddCategoriesAndPostsLastReplyId extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $this->table('forum_categories')
            ->addColumn('last_post_id', 'integer', [
                'after' => 'parent_id',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex('last_post_id')
            ->update();

        $this->table('forum_posts')
            ->addColumn('last_reply_id', 'integer', [
                'after' => 'category_id',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex('last_reply_id')
            ->update();

        $this->table('forum_categories')
            ->addForeignKey(
                'last_post_id',
                'forum_posts',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'SET_NULL',
                ]
            )
            ->update();

        $this->table('forum_posts')
            ->addForeignKey(
                'last_reply_id',
                'forum_posts',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'SET_NULL',
                ]
            )
            ->update();

        $Categories = TableRegistry::getTableLocator()->get('CakeDC/Forum.Categories');
        $Threads = TableRegistry::getTableLocator()->get('CakeDC/Forum.Threads');
        $Posts = TableRegistry::getTableLocator()->get('CakeDC/Forum.Posts');
        $Replies = TableRegistry::getTableLocator()->get('CakeDC/Forum.Replies');

        $categories = $Categories->find()->orderBy('Categories.id');
        foreach ($categories as $category) {
            if (!$post = $Posts->find()->where(['Posts.category_id' => $category->id])->orderByDesc('Posts.id')->first()) {
                continue;
            }

            $category->last_post_id = $post->id;
            $Categories->saveOrFail($category);
        }

        $threads = $Threads->find()->orderBy('Threads.id');
        foreach ($threads as $thread) {
            if (!$reply = $Replies->find()->where(['Replies.parent_id' => $thread->id])->orderByDesc('Replies.id')->first()) {
                continue;
            }

            $thread->last_reply_id = $reply->id;
            $Threads->saveOrFail($thread);
        }
    }
}
