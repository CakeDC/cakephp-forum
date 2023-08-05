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
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
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
                'id' => '1',
                'parent_id' => NULL,
                'lft' => '11',
                'rght' => '18',
                'title' => 'Hardware and Technology',
                'slug' => 'hardware-and-technology',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-10 20:08:21',
                'modified' => '2017-07-13 15:50:06',
            ],
            [
                'id' => '2',
                'parent_id' => '1',
                'lft' => '14',
                'rght' => '15',
                'title' => 'CPUs and Overclocking',
                'slug' => 'cpus-andoverclocking',
                'description' => '',
                'threads_count' => '8',
                'replies_count' => '10',
                'is_visible' => '1',
                'created' => '2017-07-10 20:08:41',
                'modified' => '2017-07-18 14:43:21',
            ],
            [
                'id' => '3',
                'parent_id' => NULL,
                'lft' => '1',
                'rght' => '10',
                'title' => 'Consumer Electronics',
                'slug' => 'consumer-electronics',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-10 20:08:58',
                'modified' => '2017-07-13 15:50:28',
            ],
            [
                'id' => '4',
                'parent_id' => '1',
                'lft' => '12',
                'rght' => '13',
                'title' => 'Motherboards',
                'slug' => 'motherboards',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-10 20:09:15',
                'modified' => '2017-07-13 15:52:41',
            ],
            [
                'id' => '5',
                'parent_id' => NULL,
                'lft' => '19',
                'rght' => '26',
                'title' => 'Software',
                'slug' => 'software',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:50:37',
                'modified' => '2017-07-13 15:50:37',
            ],
            [
                'id' => '6',
                'parent_id' => '1',
                'lft' => '16',
                'rght' => '17',
                'title' => 'Memory and Storage',
                'slug' => 'memory-and-storage',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:51:28',
                'modified' => '2017-07-13 15:51:49',
            ],
            [
                'id' => '7',
                'parent_id' => '3',
                'lft' => '2',
                'rght' => '3',
                'title' => 'Digital and Video Cameras',
                'slug' => 'digital-and-video-cameras',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:52:10',
                'modified' => '2017-07-13 15:52:33',
            ],
            [
                'id' => '8',
                'parent_id' => '3',
                'lft' => '4',
                'rght' => '5',
                'title' => 'Mobile Devices and Gadgets',
                'slug' => 'mobile-devices-and-gadgets',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:53:49',
                'modified' => '2017-07-13 15:53:49',
            ],
            [
                'id' => '9',
                'parent_id' => '3',
                'lft' => '6',
                'rght' => '7',
                'title' => 'Home Theater',
                'slug' => 'home-theater',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:54:27',
                'modified' => '2017-07-13 15:54:27',
            ],
            [
                'id' => '10',
                'parent_id' => '5',
                'lft' => '20',
                'rght' => '21',
                'title' => 'Software for Windows',
                'slug' => 'software-for-windows',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:54:40',
                'modified' => '2017-07-13 15:54:40',
            ],
            [
                'id' => '11',
                'parent_id' => '5',
                'lft' => '22',
                'rght' => '23',
                'title' => 'All Things Apple',
                'slug' => 'all-things-apple',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:54:50',
                'modified' => '2017-07-13 15:54:50',
            ],
            [
                'id' => '12',
                'parent_id' => '5',
                'lft' => '24',
                'rght' => '25',
                'title' => 'Operating Systems',
                'slug' => 'operating-systems',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '1',
                'created' => '2017-07-13 15:55:02',
                'modified' => '2017-07-13 15:55:02',
            ],
            [
                'id' => '13',
                'parent_id' => '3',
                'lft' => '8',
                'rght' => '9',
                'title' => 'Invisible category',
                'slug' => 'invisible-category',
                'description' => '',
                'threads_count' => '0',
                'replies_count' => '0',
                'is_visible' => '0',
                'created' => '2017-07-14 11:57:02',
                'modified' => '2017-07-14 11:57:02',
            ],
        ];

        $table = $this->table('forum_categories');
        $table->insert($data)->save();
    }
}
