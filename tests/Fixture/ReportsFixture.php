<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReportsFixture
 */
class ReportsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'forum_reports';

    /**
     * Records
     *
     * @var array
     */
    public array $records = [
        [
            'id' => 1,
            'post_id' => 1,
            'user_id' => 1,
            'message' => 'This post is very rude',
            'created' => '2017-07-18 14:42:56',
            'modified' => '2017-07-18 14:42:56',
        ],
        [
            'id' => 2,
            'post_id' => 2,
            'user_id' => 1,
            'message' => 'Please remove this post',
            'created' => '2017-07-18 15:03:57',
            'modified' => '2017-07-18 15:03:57',
        ],
    ];
}
