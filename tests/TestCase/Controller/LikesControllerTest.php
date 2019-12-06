<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\LikesController Test Case
 */
class LikesControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.CakeDC/Forum.Categories',
        'plugin.CakeDC/Forum.Posts',
        'plugin.CakeDC/Forum.Moderators',
        'plugin.CakeDC/Forum.Users',
        'plugin.CakeDC/Forum.Likes',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'testing',
                ],
            ],
        ]);

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $Posts = TableRegistry::get('CakeDC/Forum.Posts');
        $Likes = TableRegistry::get('CakeDC/Forum.Likes');

        $post = $Posts->find()->where(['slug' => 'new-thread2'])->first();
        $likesCount = $post->get('likes_count');

        $this->post('/forum/cpus-andoverclocking/new-thread2/9/like');
        $likesCount += 1;
        $this->assertRedirect('/forum/cpus-andoverclocking/new-thread2');
        $this->assertSession('The like has been saved.', 'Flash.flash.0.message');

        $post = $Posts->find()->where(['slug' => 'new-thread2'])->first();
        $this->assertEquals($likesCount, $post->get('likes_count'));

        $this->post('/forum/cpus-andoverclocking/new-thread2/9/like');
        $this->assertResponseError();

        $post = $Posts->find()->where(['slug' => 'new-thread2'])->first();
        $this->assertEquals($likesCount, $post->get('likes_count'));
        /*
        $this->get('/forum');

        $this->assertResponseOk();
        $this->assertResponseContains('Hardware and Technology');
        $this->assertResponseContains('Latest: <');
        $this->assertResponseNotContains('Invisible Category');

        $categories = $this->viewVariable('categories')->toArray();
        $this->assertNotEmpty($categories);
        $this->assertCount(3, $categories);
        $this->assertCount(3, $categories[0]->children);
        $this->assertEquals('Hardware and Technology', $categories[0]->title);
        $this->assertCount(3, $categories[1]->children);
        $this->assertEquals('Software', $categories[1]->title);
        $this->assertCount(3, $categories[2]->children);
        $this->assertEquals('Consumer Electronics', $categories[2]->title);
        */
    }
}
