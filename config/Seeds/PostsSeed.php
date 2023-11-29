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
 * Posts seed.
 */
class PostsSeed extends AbstractSeed
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
        $data = [
            [
                'id' => '1',
                'parent_id' => null,
                'category_id' => '2',
                'user_id' => '1',
                'title' => 'Overclocking CPU/GPU/Memory Stability Testing Guidelines',
                'slug' => 'overclocking-cpu-gpu-memory-stability-testing-guidelines',
                'message' => 'Must run with the IBT thread count set equal to the physical core count of the CPU.
HT slows it down and reduces the ability to determine stability. Set to 4 threads on a 2600K.
Set memory to "All".
Stability Criterion: Must pass 5 cycles minimum, passing 20 cycles is preferred (considered gold standard)
aaa',
                'replies_count' => '3',
                'reports_count' => '1',
                'likes_count' => '1',
                'is_sticky' => '1',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => '2017-07-18 11:41:58',
                'created' => '2017-07-14 11:00:55',
                'modified' => '2017-07-18 12:10:00',
            ],
            [
                'id' => '2',
                'parent_id' => '1',
                'category_id' => '2',
                'user_id' => '1',
                'title' => '',
                'slug' => '',
                'message' => 'Like others have said, sticky please!

About the Prime95 Large FFT, I\'ve gotten crashes on my Phenom II on Blend that I haven\'t gotten on Large FFT. This ' .
                    'required me to run it 24 hours with crashes happening on the 20th hour a lot of times. These ' .
                    'crashes were fixed by increasing increasing CPU or CPU-NB volts or downing the CPU or CPU-NB ' .
                    'clock speeds.',
                'replies_count' => '0',
                'reports_count' => '1',
                'likes_count' => '1',
                'is_sticky' => '0',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => null,
                'created' => '2017-07-14 11:01:45',
                'modified' => '2017-07-14 11:01:45',
            ],
            [
                'id' => '3',
                'parent_id' => null,
                'category_id' => '2',
                'user_id' => '1',
                'title' => '7700K vs 7800X Techspot review',
                'slug' => '7700k-vs-7800x-techspot-review',
                'message' => 'Obviously it is 1080p and will not matter much in 4K, but that is some really bad' .
                    ' numbers for the 7800X.',
                'replies_count' => '1',
                'reports_count' => '0',
                'likes_count' => '0',
                'is_sticky' => '0',
                'is_locked' => '1',
                'is_visible' => '1',
                'last_reply_created' => '2017-07-14 11:28:31',
                'created' => '2017-07-14 11:27:10',
                'modified' => '2017-07-14 11:28:42',
            ],
            [
                'id' => '4',
                'parent_id' => null,
                'category_id' => '2',
                'user_id' => '1',
                'title' => 'Anandtech：Intel\'s Skylake-SP Xeon VS AMD\'s EPYC 7000',
                'slug' => 'anandtech-intels-skylake-sp-xeon-vs-amds-epyc-7000',
                'message' => 'With the exception of database software and vectorizable HPC code, AMD\'s EPYC 7601 ' .
                    '($4200) offers slightly less or slightly better performance than Intel\'s Xeon 8176 ($8000+).',
                'replies_count' => '2',
                'reports_count' => '0',
                'likes_count' => '0',
                'is_sticky' => '0',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => '2017-07-14 11:29:28',
                'created' => '2017-07-14 11:27:39',
                'modified' => '2017-07-14 11:27:39',
            ],
            [
                'id' => '5',
                'parent_id' => null,
                'category_id' => '2',
                'user_id' => '1',
                'title' => '16C/16T Intel Atom C3955 (Goldmont core) – Denverton platform benchmark leaked',
                'slug' => '16c-16t-intel-atom-c3955-goldmont-core-denverton-platform-benchmark-leaked',
                'message' => 'SiSoftware Sandra 22.20 - Processor Multi-Media - Windows x64 10.0.6

• Intel Atom(TM) CPU C3955 @ 2.10GHz (16C 2.1GHz, 8x 2MB L2 cache, Goldmont - Denverton 31W TDP): 229.47Mpix/s
source: ranker.sisoftware.net

for comparation:

• AMD FX(tm)-8350 Eight-Core Processor (4M 8T 4.84GHz, 2.63GHz IMC, 4x 2MB L2 cache, 8MB L3 cache, Steamroller ' .
                    '125W TDP): 223.16Mpix/s
source: ranker.sisoftware.net',
                'replies_count' => '0',
                'reports_count' => '0',
                'likes_count' => '0',
                'is_sticky' => '0',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => '2017-07-14 11:28:11',
                'created' => '2017-07-14 11:28:11',
                'modified' => '2017-07-14 11:28:11',
            ],
            [
                'id' => '6',
                'parent_id' => '3',
                'category_id' => '2',
                'user_id' => '1',
                'title' => '',
                'slug' => '',
                'message' => 'Is this targeted at data center use because it doesn\'t make much sense for ' .
                    'anything else. Maybe a hedge against ARM?',
                'replies_count' => '0',
                'reports_count' => '0',
                'likes_count' => '0',
                'is_sticky' => '0',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => null,
                'created' => '2017-07-14 11:28:31',
                'modified' => '2017-07-14 11:28:31',
            ],
            [
                'id' => '7',
                'parent_id' => '4',
                'category_id' => '2',
                'user_id' => '1',
                'title' => '',
                'slug' => '',
                'message' => 'Those prices though! :(

Planned on buying a Gold 6000 series, until today. Now I may have to settle for a Silver 4110.',
                'replies_count' => '0',
                'reports_count' => '0',
                'likes_count' => '0',
                'is_sticky' => '0',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => null,
                'created' => '2017-07-14 11:29:15',
                'modified' => '2017-07-14 11:29:15',
            ],
            [
                'id' => '8',
                'parent_id' => '4',
                'category_id' => '2',
                'user_id' => '1',
                'title' => '',
                'slug' => '',
                'message' => 'Good article good read, glad AMD is finally back in the game.',
                'replies_count' => '0',
                'reports_count' => '0',
                'likes_count' => '0',
                'is_sticky' => '0',
                'is_locked' => '0',
                'is_visible' => '1',
                'last_reply_created' => null,
                'created' => '2017-07-14 11:29:28',
                'modified' => '2017-07-14 11:29:28',
            ],
        ];

        $table = $this->table('forum_posts');
        $table->insert($data)->save();
    }
}
