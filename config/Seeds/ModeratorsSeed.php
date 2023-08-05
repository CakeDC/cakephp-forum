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
 * Moderators seed.
 */
class ModeratorsSeed extends AbstractSeed
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
                'category_id' => '2',
                'user_id' => '1',
                'created' => '2017-07-19 13:53:20',
                'modified' => '2017-07-19 13:53:20',
            ],
        ];

        $table = $this->table('forum_moderators');
        $table->insert($data)->save();
    }
}
