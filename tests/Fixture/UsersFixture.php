<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Records
     *
     * @var array
     */
    public array $records = [
        [
            'id' => 1,
            'username' => 'admin',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'John Doe',
            'posts_count' => 15,
            'is_superuser' => 1,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
        [
            'id' => 2,
            'username' => 'moderator1',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'Moderator Nick',
            'posts_count' => 0,
            'is_superuser' => 0,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
        [
            'id' => 3,
            'username' => 'moderator2',
            'password' => '$2y$10$CmvBkngnW4Xi6Lm.C1shQ.hb3uWNHv9b/5autcmUAsONmXPXb2H5K',
            'full_name' => 'Moderator Peter',
            'posts_count' => 0,
            'is_superuser' => 0,
            'created' => '2017-07-11 00:00:00',
            'modified' => '2017-07-11 00:00:00',
        ],
        [
            'id' => 4,
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
