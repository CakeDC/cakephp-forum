<?php
namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostsFixture
 *
 */
class PostsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'forum_posts';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'category_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'last_reply_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'message' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'replies_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'reports_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'likes_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_sticky' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_locked' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_visible' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'last_reply_created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'parent_id' => ['type' => 'index', 'columns' => ['parent_id'], 'length' => []],
            'forum_category_id' => ['type' => 'index', 'columns' => ['category_id'], 'length' => []],
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'slug' => ['type' => 'index', 'columns' => ['slug'], 'length' => []],
            'is_sticky' => ['type' => 'index', 'columns' => ['is_sticky'], 'length' => []],
            'last_reply_created' => ['type' => 'index', 'columns' => ['last_reply_created'], 'length' => []],
            'title' => ['type' => 'fulltext', 'columns' => ['title'], 'length' => []],
            'message' => ['type' => 'fulltext', 'columns' => ['message'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'forum_posts_ibfk_1' => ['type' => 'foreign', 'columns' => ['category_id'], 'references' => ['forum_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'forum_posts_ibfk_2' => ['type' => 'foreign', 'columns' => ['parent_id'], 'references' => ['forum_posts', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            //'forum_posts_ibfk_3' => ['type' => 'foreign', 'columns' => ['last_reply_id'], 'references' => ['forum_posts', 'id'], 'update' => 'cascade', 'delete' => 'set_null', 'length' => []],
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
            //'id' => 1,
            'parent_id' => null,
            'category_id' => 2,
            'last_reply_id' => 2,
            'user_id' => 1,
            'title' => 'Overclocking CPU/GPU/Memory Stability Testing Guidelines',
            'slug' => 'overclocking-cpu-gpu-memory-stability-testing-guidelines',
            'message' => 'Must run with the IBT thread count set equal to the physical core count of the CPU.
HT slows it down and reduces the ability to determine stability. Set to 4 threads on a 2600K.
Set memory to "All".
Stability Criterion: Must pass 5 cycles minimum, passing 20 cycles is preferred (considered gold standard)
aaa',
            'replies_count' => 3,
            'reports_count' => 1,
            'likes_count' => 1,
            'is_sticky' => true,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => '2017-07-18 11:41:58',
            'created' => '2017-07-14 11:00:55',
            'modified' => '2017-07-18 12:10:00',
        ],
        [
            //'id' => 2,
            'parent_id' => 1,
            'category_id' => 2,
            'user_id' => 1,
            'title' => '',
            'slug' => '',
            'message' => 'Like others have said, sticky please!

About the Prime95 Large FFT, I\'ve gotten crashes on my Phenom II on Blend that I haven\'t gotten on Large FFT. This required me to run it 24 hours with crashes happening on the 20th hour a lot of times. These crashes were fixed by increasing increasing CPU or CPU-NB volts or downing the CPU or CPU-NB clock speeds.',
            'replies_count' => 0,
            'reports_count' => 1,
            'likes_count' => 1,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => null,
            'created' => '2017-07-14 11:01:45',
            'modified' => '2017-07-14 11:01:45',
        ],
        [
            //'id' => 3,
            'parent_id' => null,
            'category_id' => 2,
            'last_reply_id' => 3,
            'user_id' => 1,
            'title' => '7700K vs 7800X Techspot review',
            'slug' => '7700k-vs-7800x-techspot-review',
            'message' => 'Obviously it is 1080p and will not matter much in 4K, but that is some really bad numbers for the 7800X.',
            'replies_count' => 1,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => true,
            'is_visible' => true,
            'last_reply_created' => '2017-07-14 11:28:31',
            'created' => '2017-07-14 11:27:10',
            'modified' => '2017-07-14 11:28:42',
        ],
        [
            //'id' => 4,
            'parent_id' => null,
            'category_id' => 2,
            'last_reply_id' => 8,
            'user_id' => 1,
            'title' => 'Anandtech：Intel\'s Skylake-SP Xeon VS AMD\'s EPYC 7000',
            'slug' => 'anandtech-intels-skylake-sp-xeon-vs-amds-epyc-7000',
            'message' => 'With the exception of database software and vectorizable HPC code, AMD\'s EPYC 7601 ($4200) offers slightly less or slightly better performance than Intel\'s Xeon 8176 ($8000+).',
            'replies_count' => 2,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => '2017-07-14 11:29:28',
            'created' => '2017-07-14 11:27:39',
            'modified' => '2017-07-14 11:27:39',
        ],
        [
            //'id' => 5,
            'parent_id' => null,
            'category_id' => 7,
            'last_reply_id' => 12,
            'user_id' => 1,
            'title' => '16C/16T Intel Atom C3955 (Goldmont core) – Denverton platform benchmark leaked',
            'slug' => '16c-16t-intel-atom-c3955-goldmont-core-denverton-platform-benchmark-leaked',
            'message' => 'SiSoftware Sandra 22.20 - Processor Multi-Media - Windows x64 10.0.6

• Intel Atom(TM) CPU C3955 @ 2.10GHz (16C 2.1GHz, 8x 2MB L2 cache, Goldmont - Denverton 31W TDP): 229.47Mpix/s
source: ranker.sisoftware.net

for comparation:

• AMD FX(tm)-8350 Eight-Core Processor (4M 8T 4.84GHz, 2.63GHz IMC, 4x 2MB L2 cache, 8MB L3 cache, Steamroller 125W TDP): 223.16Mpix/s
source: ranker.sisoftware.net',
            'replies_count' => 0,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => '2017-07-14 11:28:11',
            'created' => '2017-07-14 11:28:11',
            'modified' => '2017-07-14 11:28:11',
        ],
        [
            //'id' => 6,
            'parent_id' => 3,
            'category_id' => 2,
            'user_id' => 1,
            'title' => '',
            'slug' => '',
            'message' => 'Is this targeted at data center use because it doesn\'t make much sense for anything else. Maybe a hedge against ARM?',
            'replies_count' => 0,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => null,
            'created' => '2017-07-14 11:28:31',
            'modified' => '2017-07-14 11:28:31',
        ],
        [
            //'id' => 7,
            'parent_id' => 4,
            'category_id' => 2,
            'user_id' => 1,
            'title' => '',
            'slug' => '',
            'message' => 'Those prices though! :(

Planned on buying a Gold 6000 series, until today. Now I may have to settle for a Silver 4110.',
            'replies_count' => 0,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => null,
            'created' => '2017-07-14 11:29:15',
            'modified' => '2017-07-14 11:29:15',
        ],
        [
            //'id' => 8,
            'parent_id' => 4,
            'category_id' => 2,
            'user_id' => 1,
            'title' => '',
            'slug' => '',
            'message' => 'Good article good read, glad AMD is finally back in the game.',
            'replies_count' => 0,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => null,
            'created' => '2017-07-14 11:29:28',
            'modified' => '2017-07-14 11:29:28',
        ],
        [
            //'id' => 9,
            'parent_id' => null,
            'category_id' => 2,
            'user_id' => 1,
            'title' => 'new thread',
            'slug' => 'new-thread2',
            'message' => 'asdfasdfasdf',
            'replies_count' => 3,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => '2017-07-17 15:17:44',
            'created' => '2017-07-17 14:15:15',
            'modified' => '2017-07-17 14:15:15',
        ],
        [
            //'id' => 10,
            'parent_id' => null,
            'category_id' => 2,
            'user_id' => 1,
            'title' => 'another thread',
            'slug' => 'another-thread',
            'message' => 'asdgdsfg',
            'replies_count' => 0,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => '2017-07-17 14:16:31',
            'created' => '2017-07-17 14:16:31',
            'modified' => '2017-07-17 14:16:31',
        ],
        [
            //'id' => 11,
            'parent_id' => null,
            'category_id' => 2,
            'user_id' => 2,
            'title' => 'one more thread',
            'slug' => 'one-more-thread',
            'message' => 'fgsdfgdf',
            'replies_count' => 1,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => '2017-07-17 14:48:54',
            'created' => '2017-07-17 14:17:16',
            'modified' => '2017-07-17 14:17:16',
        ],
        [
            //'id' => 12,
            'parent_id' => 5,
            'category_id' => 7,
            'user_id' => 2,
            'title' => '',
            'slug' => '',
            'message' => 'another reply',
            'replies_count' => 0,
            'reports_count' => 0,
            'likes_count' => 0,
            'is_sticky' => false,
            'is_locked' => false,
            'is_visible' => true,
            'last_reply_created' => null,
            'created' => '2017-07-14 11:28:11',
            'modified' => '2017-07-14 11:28:11',
        ],
    ];
}
