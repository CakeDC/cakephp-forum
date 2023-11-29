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

class AddReportsCount extends AbstractMigration
{
    /**
     * @return void
     */
    public function up(): void
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

    /**
     * @return void
     */
    public function down(): void
    {
        $this->table('forum_posts')
            ->removeColumn('reports_count')
            ->update();
    }
}
