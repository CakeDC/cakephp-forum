<?php
use Migrations\AbstractMigration;

class AddReportsCount extends AbstractMigration
{

    public function up()
    {

        $this->table('forum_posts')
            ->addColumn('reports_count', 'integer', [
                'after' => 'replies_count',
                'default' => null,
                'length' => 11,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('forum_posts')
            ->removeColumn('reports_count')
            ->update();
    }
}

