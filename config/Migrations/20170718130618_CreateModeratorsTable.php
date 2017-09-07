<?php
use Migrations\AbstractMigration;

class CreateModeratorsTable extends AbstractMigration
{

    public function up()
    {
        $this->table('forum_moderators')
            ->addColumn('category_id', 'integer', [
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
                    'category_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('forum_moderators')
            ->addForeignKey(
                'category_id',
                'forum_categories',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('forum_moderators')
            ->dropForeignKey(
                'category_id'
            );

        $this->dropTable('forum_moderators');
    }
}

