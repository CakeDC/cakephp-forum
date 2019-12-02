<?php
namespace CakeDC\Forum\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\RepliesController Test Case
 */
class RepliesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.CakeDC/Forum.Categories',
        'plugin.CakeDC/Forum.Posts',
        'plugin.CakeDC/Forum.Users',
        'plugin.CakeDC/Forum.Reports',
        'plugin.CakeDC/Forum.Moderators',
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
                ]
            ]
        ]);

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/2/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('Like others have said, sticky please!');

        $data = [
            'message' => 'test updated message'
        ];

        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/2/edit', $data);
        $this->assertRedirect('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertSession('The reply has been saved.', 'Flash.flash.0.message');

        $reply = TableRegistry::get('CakeDC/Forum.Replies')->get(2);
        $this->assertEquals($data['message'], $reply->get('message'));
    }

    /**
     * Test failed edit method
     *
     * @return void
     */
    public function testEditFailed()
    {
        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/2/edit', ['message' => '']);
        $this->assertResponseOk();
        $this->assertSession('The reply could not be saved. Please, try again.', 'Flash.flash.0.message');

        // Editing a reply of another user
        $this->get('/forum/digital-and-video-cameras/16c-16t-intel-atom-c3955-goldmont-core-denverton-platform-benchmark-leaked/12/edit');
        $this->assertResponseError();
        $this->post('/forum/digital-and-video-cameras/16c-16t-intel-atom-c3955-goldmont-core-denverton-platform-benchmark-leaked/12/edit', ['message' => 'aaa']);
        $this->assertResponseError();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/reply');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');

        $data = [
            'message' => 'test reply message',
            'title' => 'should not be saved',
            'user_id' => 2, // should not be overwritten
        ];

        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/reply', $data);
        $this->assertRedirect('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertSession('The reply has been saved.', 'Flash.flash.0.message');

        $reply = TableRegistry::get('CakeDC/Forum.Replies')->find()->orderDesc('Replies.id')->first();
        $this->assertEquals(2, $reply->get('category_id'));
        $this->assertEquals(1, $reply->get('parent_id'));
        $this->assertEquals(1, $reply->get('user_id'));
        $this->assertEquals($data['message'], $reply->get('message'));
        $this->assertEmpty($reply->get('title'));
        $this->assertEmpty($reply->get('slug'));
    }

    /**
     * Test failed add method
     *
     * @return void
     */
    public function testAddFailed()
    {
        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/reply', ['message' => '']);
        $this->assertResponseOk();
        $this->assertSession('The reply could not be saved. Please, try again.', 'Flash.flash.0.message');

        // Locked thread
        $this->post('/forum/cpus-andoverclocking/7700k-vs-7800x-techspot-review/reply', ['message' => 'test message']);
        $this->assertResponseError();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        // Delete own reply
        $Replies = TableRegistry::get('CakeDC/Forum.Replies');
        $reply = $Replies->newEntity(['message' => 'test reply message']);
        $reply->parent_id = 1;
        $reply->category_id = 2;
        $reply->user_id = 1;
        $this->assertNotFalse($Replies->save($reply));
        $this->delete("/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/{$reply->id}/delete");
        $this->assertRedirect('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertSession('The reply has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Replies->find()->where(['Replies.id' => $reply->id])->first());

        // Deleting a reply of another user in category current user is moderator of
        $reply = $Replies->newEntity(['message' => 'test reply message']);
        $reply->parent_id = 1;
        $reply->category_id = 2;
        $reply->user_id = 2;
        $this->assertNotFalse($Replies->save($reply));
        $this->delete("/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/{$reply->id}/delete");
        $this->assertRedirect('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertSession('The reply has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Replies->find()->where(['Replies.id' => $reply->id])->first());

        // Deleting a reply of another user in category current user is NOT moderator of
        $reply = $Replies->newEntity(['message' => 'test reply message']);
        $reply->parent_id = 5;
        $reply->category_id = 7;
        $reply->user_id = 2;
        $this->assertNotFalse($Replies->save($reply));
        $this->delete("/forum/digital-and-video-cameras/16c-16t-intel-atom-c3955-goldmont-core-denverton-platform-benchmark-leaked/{$reply->id}/delete");
        $this->assertResponseError();
    }
}
