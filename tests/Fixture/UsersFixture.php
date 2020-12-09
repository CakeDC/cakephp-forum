<?php
namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'full_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'posts_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_superuser' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => 0, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'username' => ['type' => 'index', 'columns' => ['username'], 'length' => []],
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
            //'id' => 1,
            'username' => 'admin',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'John Doe',
            'posts_count' => 15,
            'is_superuser' => 1,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
        [
            //'id' => 2,
            'username' => 'moderator1',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'Moderator Nick',
            'posts_count' => 0,
            'is_superuser' => 0,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
        [
            //'id' => 3,
            'username' => 'moderator2',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'Moderator Peter',
            'posts_count' => 0,
            'is_superuser' => 0,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
        [
            //'id' => 4,
            'username' => 'user',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'Simple User',
            'posts_count' => 0,
            'is_superuser' => 0,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
    ];
}
