<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModeratorsFixture
 */
class ModeratorsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'forum_moderators';

    /**
     * Records
     *
     * @var array
     */
    public array $records = [
        [
            'id' => 1,
            'category_id' => 2,
            'user_id' => 1,
            'created' => '2017-07-24 12:53:04',
            'modified' => '2017-07-24 12:53:04',
        ],
        [
            'id' => 2,
            'category_id' => 3,
            'user_id' => 2,
            'created' => '2017-07-24 12:53:04',
            'modified' => '2017-07-24 12:53:04',
        ],
        [
            'id' => 3,
            'category_id' => 7,
            'user_id' => 3,
            'created' => '2017-07-24 12:53:04',
            'modified' => '2017-07-24 12:53:04',
        ],
    ];
}
