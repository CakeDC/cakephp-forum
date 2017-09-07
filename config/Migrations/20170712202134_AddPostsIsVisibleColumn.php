<?php
use Migrations\AbstractMigration;

class AddPostsIsVisibleColumn extends AbstractMigration
{

    public function up()
    {

        $this->table('forum_posts')
            ->addColumn('is_visible', 'boolean', [
                'after' => 'is_locked',
                'default' => '1',
                'length' => null,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('forum_posts')
            ->removeColumn('is_visible')
            ->update();
    }
}

