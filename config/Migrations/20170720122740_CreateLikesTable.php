<?php
use Migrations\AbstractMigration;

class CreateLikesTable extends AbstractMigration
{

    public function up()
    {

        $this->table('forum_likes')
            ->addColumn('post_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'post_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('forum_likes')
            ->addForeignKey(
                'post_id',
                'forum_posts',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('forum_posts')
            ->addColumn('likes_count', 'integer', [
                'after' => 'reports_count',
                'default' => null,
                'length' => 11,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {
        $this->table('forum_likes')
            ->dropForeignKey(
                'post_id'
            );

        $this->table('forum_posts')
            ->removeColumn('likes_count')
            ->update();

        $this->dropTable('forum_likes');
    }
}

