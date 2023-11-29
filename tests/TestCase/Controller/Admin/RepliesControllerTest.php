<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\TestCase\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * CakeDC\Forum\Controller\Admin\RepliesController Test Case
 */
class RepliesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'plugin.CakeDC/Forum.Categories',
        'plugin.CakeDC/Forum.Posts',
        'plugin.CakeDC/Forum.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();

        Configure::write('Forum.authenticatedUserCallable', fn (Controller $controller): array => [
            'id' => 1,
            'username' => 'testing',
            'is_superuser' => true,
        ]);

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/forum/admin/replies/view/2');
        $this->assertResponseOk();
        $this->assertResponseContains('Like others have said, sticky please!');
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $this->assertResponseContains('>John Doe<');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/forum/admin/replies/add?parent_id=1');
        $this->assertResponseOk();
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');

        $data = [
            'message' => 'test reply',
        ];

        $this->post('/forum/admin/replies/add?parent_id=1', $data);
        $this->assertRedirect('/forum/admin/threads/view/1');
        $this->assertSession('The reply has been saved.', 'Flash.flash.0.message');

        $reply = $this->fetchTable('CakeDC/Forum.Replies')->find()->orderByDesc('Replies.id')->first();
        $this->assertEquals(1, $reply->get('parent_id'));
        $this->assertEquals(2, $reply->get('category_id'));
        $this->assertEquals(1, $reply->get('user_id'));
        $this->assertEquals($data['message'], $reply->get('message'));
    }

    /**
     * Test failed add method
     *
     * @return void
     */
    public function testAddFailed()
    {
        $this->post('/forum/admin/replies/add?parent_id=1', ['message' => '']);
        $this->assertResponseOk();
        $this->assertSession('The reply could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/forum/admin/replies/edit/2');
        $this->assertResponseOk();
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');

        $update = [
            'message' => 'Edited message',
        ];
        $this->post('/forum/admin/replies/edit/2', $update);
        $this->assertRedirect('/forum/admin/threads/view/1');
        $this->assertSession('The reply has been saved.', 'Flash.flash.0.message');

        $reply = $this->fetchTable('CakeDC/Forum.Replies')->get(2);
        $this->assertEquals($update['message'], $reply->get('message'));
    }

    /**
     * Test failed edit method
     *
     * @return void
     */
    public function testEditFailed()
    {
        $this->post('/forum/admin/replies/edit/2', ['message' => '']);
        $this->assertResponseOk();
        $this->assertSession('The reply could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $Replies = $this->fetchTable('CakeDC/Forum.Replies');
        $reply = $Replies->newEntity(['message' => 'test message']);
        $reply->parent_id = 1;
        $reply->category_id = 2;
        $reply->user_id = 1;
        $this->assertNotFalse($Replies->save($reply));

        $this->delete('/forum/admin/replies/delete/' . $reply->id);

        $this->assertRedirect('/forum/admin/threads/view/1');
        $this->assertSession('The reply has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Replies->find()->where(['Replies.id' => $reply->id])->first());
    }
}
