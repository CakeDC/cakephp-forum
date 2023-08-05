<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
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
    public function run(): void
    {
        $this->call('CakeDC/Forum.CategoriesSeed');
        $this->call('CakeDC/Forum.PostsSeed');
        $this->call('CakeDC/Forum.ModeratorsSeed');
        $this->call('CakeDC/Forum.ReportsSeed');
        $this->call('CakeDC/Forum.LikesSeed');
    }
}
