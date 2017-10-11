<?php

use Cake\ORM\TableRegistry;
use Migrations\AbstractMigration;

class AddCategoriesAndPostsLastReplyId extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
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
                    'delete' => 'SET_NULL'
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
                    'delete' => 'SET_NULL'
                ]
            )
            ->update();

        $Categories = TableRegistry::get('CakeDC/Forum.Categories');
        $Threads = TableRegistry::get('CakeDC/Forum.Threads');
        $Posts = TableRegistry::get('CakeDC/Forum.Posts');
        $Replies = TableRegistry::get('CakeDC/Forum.Replies');

        $categories = $Categories->find()->order('Categories.id');
        foreach ($categories as $category) {
            if (!$post = $Posts->find()->where(['Posts.category_id' => $category->id])->orderDesc('Posts.id')->first()) {
                continue;
            }

            $category->last_post_id = $post->id;
            $Categories->saveOrFail($category);
        }

        $threads = $Threads->find()->order('Threads.id');
        foreach ($threads as $thread) {
            if (!$reply = $Replies->find()->where(['Replies.parent_id' => $thread->id])->orderDesc('Replies.id')->first()) {
                continue;
            }

            $thread->last_reply_id = $reply->id;
            $Threads->saveOrFail($thread);
        }
    }
}
