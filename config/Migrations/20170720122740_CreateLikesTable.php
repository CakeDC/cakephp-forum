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
use Migrations\AbstractMigration;

class CreateLikesTable extends AbstractMigration
{
    public function up(): void
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
                    'delete' => 'CASCADE',
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

    public function down(): void
    {
        $this->table('forum_likes')
            ->dropForeignKey(
                'post_id'
            );

        $this->table('forum_posts')
            ->removeColumn('likes_count')
            ->update();

        $this->table('forum_likes')->drop()->save();
    }
}
