<?php
namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModeratorsFixture
 *
 */
class ModeratorsFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'forum_moderators';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'category_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'category_id' => ['type' => 'index', 'columns' => ['category_id'], 'length' => []],
            //'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'forum_moderators_ibfk_1' => ['type' => 'foreign', 'columns' => ['category_id'], 'references' => ['forum_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'category_id' => 2,
            'user_id' => 1,
            'created' => '2017-07-24 12:53:04',
            'modified' => '2017-07-24 12:53:04'
        ],
        [
            //'id' => 2,
            'category_id' => 3,
            'user_id' => 2,
            'created' => '2017-07-24 12:53:04',
            'modified' => '2017-07-24 12:53:04'
        ],
        [
            //'id' => 3,
            'category_id' => 7,
            'user_id' => 3,
            'created' => '2017-07-24 12:53:04',
            'modified' => '2017-07-24 12:53:04'
        ],
    ];
}
