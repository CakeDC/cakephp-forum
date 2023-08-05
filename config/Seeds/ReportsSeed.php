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
use Migrations\AbstractSeed;

/**
 * Reports seed.
 */
class ReportsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '2',
                'post_id' => '1',
                'user_id' => '1',
                'message' => 'This thread is very offensive',
                'created' => '2017-07-18 14:42:56',
                'modified' => '2017-07-18 14:42:56',
            ],
            [
                'id' => '3',
                'post_id' => '2',
                'user_id' => '1',
                'message' => 'Please remove this post',
                'created' => '2017-07-18 15:03:57',
                'modified' => '2017-07-18 15:03:57',
            ],
        ];

        $table = $this->table('forum_reports');
        $table->insert($data)->save();
    }
}
