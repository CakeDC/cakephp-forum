<?php
namespace CakeDC\Forum\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\ThreadsController Test Case
 */
class ThreadsControllerTest extends IntegrationTestCase
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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/forum/cpus-andoverclocking');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('>New Thread<');
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $this->assertResponseContains('>7700K vs 7800X Techspot review<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertNotEmpty($threads);
        $this->assertCount(6, $threads);
        $this->assertEquals('Overclocking CPU/GPU/Memory Stability Testing Guidelines', $threads[0]->title);

        $this->get('/forum/hardware-and-technology');
        $this->assertResponseOk();
        $this->assertResponseContains('>Hardware and Technology<');
        $this->assertResponseNotContains('>New Thread<');
        $this->assertResponseContains('>CPUs and Overclocking<');
        $categories = $this->viewVariable('categories');
        $this->assertCount(3, $categories);
        $this->assertEquals('CPUs and Overclocking', $categories[0]->title);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertResponseOk();
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $this->assertResponseContains('>Reply<');
        $this->assertResponseContains('Must run with the IBT thread count set equal to the physical core count of the CPU');
        $this->assertResponseContains('Like others have said, sticky please!');
        $this->assertResponseContains('John Doe liked this post.');
        $this->assertResponseContains('title="Reported"');

        $thread = $this->viewVariable('thread');
        $this->assertEquals('Overclocking CPU/GPU/Memory Stability Testing Guidelines', $thread->title);

        $posts = $this->viewVariable('posts')->toArray();
        $this->assertCount(2, $posts);
        $this->assertEquals('Overclocking CPU/GPU/Memory Stability Testing Guidelines', $posts[0]->title);

        $this->get('/forum/cpus-andoverclocking/non-existing-thread');
        $this->assertResponseError();

        $this->get('/forum/non-existing-category/non-existing-thread');
        $this->assertResponseError();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('value="Overclocking CPU/GPU/Memory Stability Testing Guidelines"');

        $data = [
            'title' => 'test updated title',
            'message' => 'test updated message',
            'is_sticky' => 0,
            'is_locked' => 1,
        ];

        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/edit', $data);
        $this->assertRedirect('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertSession('The thread has been saved.', 'Flash.flash.0.message');

        $thread = TableRegistry::get('CakeDC/Forum.Threads')->find('slugged', ['slug' => 'overclocking-cpu-gpu-memory-stability-testing-guidelines'])->first();
        $this->assertEquals($data['title'], $thread->get('title'));
        $this->assertEquals($data['message'], $thread->get('message'));
        $this->assertEquals($data['is_sticky'], $thread->get('is_sticky'));
        $this->assertEquals($data['is_locked'], $thread->get('is_locked'));

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'testing',
                ]
            ]
        ]);
        $thread = TableRegistry::get('CakeDC/Forum.Threads')->find('slugged', ['slug' => 'one-more-thread'])->first();
        $this->assertFalse($thread->get('is_sticky'));
        $this->assertFalse($thread->get('is_locked'));
        $this->post('/forum/cpus-andoverclocking/one-more-thread/edit', ['title' => 'bbb', 'message' => 'ccc', 'is_sticky' => 1, 'is_locked' => 1]);
        $this->assertRedirect('/forum/cpus-andoverclocking/one-more-thread');
        $this->assertSession('The thread has been saved.', 'Flash.flash.0.message');
        $updatedThread = TableRegistry::get('CakeDC/Forum.Threads')->find('slugged', ['slug' => 'one-more-thread'])->first();
        // Make sure non-moderator can't update is_sticky and is_locked
        $this->assertEquals('bbb', $updatedThread->get('title'));
        $this->assertEquals('ccc', $updatedThread->get('message'));
        $this->assertFalse($updatedThread->get('is_sticky'));
        $this->assertFalse($updatedThread->get('is_locked'));
    }

    /**
     * Test failed edit method
     *
     * @return void
     */
    public function testEditFailed()
    {
        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/edit', ['title' => '']);
        $this->assertResponseOk();
        $this->assertSession('The thread could not be saved. Please, try again.', 'Flash.flash.0.message');

        // Editing a thread of another user
        $this->get('/forum/cpus-andoverclocking/one-more-thread/edit');
        $this->assertResponseError();
        $this->post('/forum/cpus-andoverclocking/one-more-thread/edit', ['title' => 'aaa', 'message' => 'aaa']);
        $this->assertResponseError();
    }

    /**
     * Test move method
     *
     * @return void
     */
    public function testMove()
    {
        $this->get('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/move');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('>New Category<');
        $categories = $this->viewVariable('categories');
        $this->assertNotEmpty($categories);

        $this->post('/forum/cpus-andoverclocking/overclocking-cpu-gpu-memory-stability-testing-guidelines/move', ['category_id' => 7]);
        $this->assertRedirect('/forum/digital-and-video-cameras/overclocking-cpu-gpu-memory-stability-testing-guidelines');
        $this->assertSession('The thread has been saved.', 'Flash.flash.0.message');

        $thread = TableRegistry::get('CakeDC/Forum.Threads')->find('slugged', ['slug' => 'overclocking-cpu-gpu-memory-stability-testing-guidelines'])->contain(['Replies'])->first();
        $this->assertEquals(7, $thread->get('category_id'));
        $this->assertEmpty(array_diff(collection($thread->get('replies'))->extract('category_id')->toArray(), [7]));

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'testing',
                ]
            ]
        ]);
        $this->get('/forum/digital-and-video-cameras/overclocking-cpu-gpu-memory-stability-testing-guidelines/move');
        $this->assertResponseError();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/forum/cpus-andoverclocking/new-thread');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');

        $data = [
            'title' => 'new test thread',
            'message' => 'test thread message',
            'user_id' => 2, // should not be overwritten
        ];

        $this->post('/forum/cpus-andoverclocking/new-thread', $data);
        $this->assertRedirect('/forum/cpus-andoverclocking/new-test-thread');
        $this->assertSession('The thread has been saved.', 'Flash.flash.0.message');

        $thread = TableRegistry::get('CakeDC/Forum.Threads')->find()->orderDesc('Threads.id')->first();
        $this->assertEquals(2, $thread->get('category_id'));
        $this->assertNull($thread->get('parent_id'));
        $this->assertEquals(1, $thread->get('user_id'));
        $this->assertEquals($data['title'], $thread->get('title'));
        $this->assertEquals('new-test-thread', $thread->get('slug'));
        $this->assertEquals($data['message'], $thread->get('message'));
    }

    /**
     * Test failed add method
     *
     * @return void
     */
    public function testAddFailed()
    {
        $this->post('/forum/cpus-andoverclocking/new-thread', ['title' => '', 'message' => '']);
        $this->assertResponseOk();
        $this->assertSession('The thread could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        // Delete own thread
        $Threads = TableRegistry::getTableLocator()->get('CakeDC/Forum.Threads');
        $thread = $Threads->newEntity(['title' => 'thread to delete', 'message' => 'test thread message']);
        $thread->category_id = 2;
        $thread->user_id = 1;
        $this->assertNotFalse($Threads->save($thread));
        $this->delete("/forum/cpus-andoverclocking/{$thread->slug}/delete");
        $this->assertRedirect('/forum/cpus-andoverclocking');
        $this->assertSession('The thread has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Threads->find()->where(['Threads.id' => $thread->id])->first());
    }
    /**
     * Test delete method
     *
     * @return void
     */
    public function testDeleteNotModerator()
    {
        // Deleting a thread when user is not moderator
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'testing',
                ]
            ]
        ]);
        $Threads = TableRegistry::getTableLocator()->get('CakeDC/Forum.Threads');
        $thread = $Threads->newEntity(['title' => 'thread to delete', 'message' => 'test thread message']);
        $thread->category_id = 2;
        $thread->user_id = 1;
        $this->assertNotFalse($Threads->save($thread));
        $this->delete("/forum/cpus-andoverclocking/{$thread->slug}/delete");
        $this->assertResponseError();
    }

    /**
     * Test my method
     *
     * @return void
     */
    public function testMy()
    {
        $this->get('/forum/my-conversations');
        $this->assertResponseOk();
        $this->assertResponseContains('>My Conversations<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertNotEmpty($threads);
        $this->assertCount(6, $threads);
        $this->assertEquals('Overclocking CPU/GPU/Memory Stability Testing Guidelines', $threads[0]->title);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'testing',
                ]
            ]
        ]);
        $this->get('/forum/my-conversations');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertNotEmpty($threads);
        $this->assertCount(2, $threads);
    }
}
