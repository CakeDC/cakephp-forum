<?php
use Migrations\AbstractSeed;

/**
 * Likes seed.
 */
class LikesSeed extends AbstractSeed
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
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'post_id' => '1',
                'user_id' => '1',
                'created' => '2017-07-20 12:13:01',
                'modified' => '2017-07-20 12:13:01',
            ],
            [
                'id' => '2',
                'post_id' => '2',
                'user_id' => '1',
                'created' => '2017-07-20 12:26:22',
                'modified' => '2017-07-20 12:26:22',
            ],
        ];

        $table = $this->table('forum_likes');
        $table->insert($data)->save();
    }
}
