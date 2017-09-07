<?php
use Migrations\AbstractMigration;

class AddPostsLastReplyCreatedColumn extends AbstractMigration
{
    public function up()
    {
        $this->table('forum_posts')
            ->addColumn('last_reply_created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'after' => 'is_locked'
            ])
            ->addIndex(['last_reply_created'])
            ->update();
    }

    public function down()
    {
        $this->table('forum_posts')
            ->dropColumn(
                'last_reply_created'
            )
            ->update();
    }
}
