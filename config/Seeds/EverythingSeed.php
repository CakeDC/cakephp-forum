<?php
use Migrations\AbstractSeed;

/**
 * Reports seed.
 */
class EverythingSeed extends AbstractSeed
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
        $this->call('CakeDC/Forum.CategoriesSeed');
        $this->call('CakeDC/Forum.PostsSeed');
        $this->call('CakeDC/Forum.ModeratorsSeed');
        $this->call('CakeDC/Forum.ReportsSeed');
        $this->call('CakeDC/Forum.LikesSeed');
    }
}
