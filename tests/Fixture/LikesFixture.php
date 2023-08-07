<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LikesFixture
 */
class LikesFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'forum_likes';

    /**
     * Records
     *
     * @var array
     */
    public array $records = [
        [
            //'id' => 1,
            'post_id' => 1,
            'user_id' => 1,
            'created' => '2017-07-20 12:13:01',
            'modified' => '2017-07-20 12:13:01',
        ],
        [
            //'id' => 2,
            'post_id' => 2,
            'user_id' => 1,
            'created' => '2017-07-20 12:26:22',
            'modified' => '2017-07-20 12:26:22',
        ],
    ];
}
