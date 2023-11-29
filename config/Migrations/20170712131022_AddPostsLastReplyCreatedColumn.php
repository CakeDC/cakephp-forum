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

class AddPostsLastReplyCreatedColumn extends AbstractMigration
{
    public function up(): void
    {
        $this->table('forum_posts')
            ->addColumn('last_reply_created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'after' => 'is_locked',
            ])
            ->addIndex(['last_reply_created'])
            ->update();
    }

    public function down(): void
    {
        $this->table('forum_posts')
            ->removeColumn(
                'last_reply_created'
            )
            ->update();
    }
}
