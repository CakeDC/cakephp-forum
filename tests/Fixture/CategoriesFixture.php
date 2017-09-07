<?php
namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesFixture
 *
 */
class CategoriesFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'forum_categories';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lft' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rght' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'threads_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => 0, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'replies_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => 0, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_visible' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => 0, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            //'parent_id' => ['type' => 'index', 'columns' => ['parent_id'], 'length' => []],
            'lft' => ['type' => 'index', 'columns' => ['lft'], 'length' => []],
            'rght' => ['type' => 'index', 'columns' => ['rght'], 'length' => []],
            //'slug' => ['type' => 'index', 'columns' => ['slug'], 'length' => []],
            'is_visible' => ['type' => 'index', 'columns' => ['is_visible'], 'length' => []],
            //'title' => ['type' => 'fulltext', 'columns' => ['title'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            //'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'parent_id' => null,
            'lft' => 1,
            'rght' => 8,
            'title' => 'Hardware and Technology',
            'slug' => 'hardware-and-technology',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-10 20:08:21',
            'modified' => '2017-07-13 15:50:06'
        ],
        [
            'id' => 2,
            'parent_id' => 1,
            'lft' => 2,
            'rght' => 3,
            'title' => 'CPUs and Overclocking',
            'slug' => 'cpus-andoverclocking',
            'description' => '',
            'threads_count' => 8,
            'replies_count' => 10,
            'is_visible' => true,
            'created' => '2017-07-10 20:08:41',
            'modified' => '2017-07-18 14:43:21'
        ],
        [
            'id' => 3,
            'parent_id' => null,
            'lft' => 17,
            'rght' => 26,
            'title' => 'Consumer Electronics',
            'slug' => 'consumer-electronics',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-10 20:08:58',
            'modified' => '2017-07-13 15:50:28'
        ],
        [
            'id' => 4,
            'parent_id' => 1,
            'lft' => 6,
            'rght' => 7,
            'title' => 'Motherboards',
            'slug' => 'motherboards',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-10 20:09:15',
            'modified' => '2017-07-24 14:42:49'
        ],
        [
            'id' => 5,
            'parent_id' => null,
            'lft' => 9,
            'rght' => 16,
            'title' => 'Software',
            'slug' => 'software',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:50:37',
            'modified' => '2017-07-13 15:50:37'
        ],
        [
            'id' => 6,
            'parent_id' => 1,
            'lft' => 4,
            'rght' => 5,
            'title' => 'Memory and Storage',
            'slug' => 'memory-and-storage',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:51:28',
            'modified' => '2017-07-13 15:51:49'
        ],
        [
            'id' => 7,
            'parent_id' => 3,
            'lft' => 18,
            'rght' => 19,
            'title' => 'Digital and Video Cameras',
            'slug' => 'digital-and-video-cameras',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:52:10',
            'modified' => '2017-07-13 15:52:33'
        ],
        [
            'id' => 8,
            'parent_id' => 3,
            'lft' => 20,
            'rght' => 21,
            'title' => 'Mobile Devices and Gadgets',
            'slug' => 'mobile-devices-and-gadgets',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:53:49',
            'modified' => '2017-07-13 15:53:49'
        ],
        [
            'id' => 9,
            'parent_id' => 3,
            'lft' => 22,
            'rght' => 23,
            'title' => 'Home Theater',
            'slug' => 'home-theater',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:54:27',
            'modified' => '2017-07-13 15:54:27'
        ],
        [
            'id' => 10,
            'parent_id' => 5,
            'lft' => 10,
            'rght' => 11,
            'title' => 'Software for Windows',
            'slug' => 'software-for-windows',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:54:40',
            'modified' => '2017-07-13 15:54:40'
        ],
        [
            'id' => 11,
            'parent_id' => 5,
            'lft' => 12,
            'rght' => 13,
            'title' => 'All Things Apple',
            'slug' => 'all-things-apple',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:54:50',
            'modified' => '2017-07-13 15:54:50'
        ],
        [
            'id' => 12,
            'parent_id' => 5,
            'lft' => 14,
            'rght' => 15,
            'title' => 'Operating Systems',
            'slug' => 'operating-systems',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => true,
            'created' => '2017-07-13 15:55:02',
            'modified' => '2017-07-13 15:55:02'
        ],
        [
            'id' => 13,
            'parent_id' => 3,
            'lft' => 24,
            'rght' => 25,
            'title' => 'Invisible category',
            'slug' => 'invisible-category',
            'description' => '',
            'threads_count' => 0,
            'replies_count' => 0,
            'is_visible' => false,
            'created' => '2017-07-14 11:57:02',
            'modified' => '2017-07-14 11:57:02'
        ],
    ];
}
