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

class AddPostsIsVisibleColumn extends AbstractMigration
{
    /**
     * @return void
     */
    public function up(): void
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

    /**
     * @return void
     */
    public function down(): void
    {
        $this->table('forum_posts')
            ->removeColumn('is_visible')
            ->update();
    }
}
