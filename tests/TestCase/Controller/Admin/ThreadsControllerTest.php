<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\TestCase\Controller\Admin;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\Admin\ThreadsController Test Case
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
        'plugin.CakeDC/Forum.Likes',
    ];

    public function setUp(): void
    {
        parent::setUp();

        Configure::write('Forum.authenticatedUserCallable', function (\Cake\Controller\Controller $controller) {
            return [
                'id' => 1,
                'username' => 'testing',
                'is_superuser' => true,
            ];
        });

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
        $this->get('/forum/admin/threads');
        $this->assertResponseOk();
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $this->assertResponseContains('>7700K vs 7800X Techspot review<');
        $this->assertResponseContains('>Reported<');
        $this->assertResponseContains('>Sticky<');
        $this->assertResponseContains('>Locked<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertNotEmpty($threads);
        $this->assertCount(7, $threads);
        $this->assertEquals('Overclocking CPU/GPU/Memory Stability Testing Guidelines', $threads[0]->title);

        $this->get('/forum/admin/threads?category_id=7');
        $this->assertResponseNotContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $this->assertResponseContains('>16C/16T Intel Atom C3955 (Goldmont core) – Denverton platform benchmark leaked<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertCount(1, $threads);
        $this->assertEquals(7, $threads[0]->category_id);

        $this->get('/forum/admin/threads?is_sticky=1');
        $this->assertResponseContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertCount(1, $threads);
        $this->assertEquals(1, $threads[0]->is_sticky);

        $this->get('/forum/admin/threads?is_sticky=2');
        $this->assertResponseNotContains('>Overclocking CPU/GPU/Memory Stability Testing Guidelines<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertCount(6, $threads);
        $this->assertEquals(0, $threads[0]->is_sticky);

        $this->get('/forum/admin/threads?is_locked=1');
        $this->assertResponseContains('>7700K vs 7800X Techspot review<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertCount(1, $threads);
        $this->assertEquals(1, $threads[0]->is_locked);

        $this->get('/forum/admin/threads?is_locked=2');
        $this->assertResponseNotContains('>7700K vs 7800X Techspot review<');
        $threads = $this->viewVariable('threads')->toArray();
        $this->assertCount(6, $threads);
        $this->assertEquals(0, $threads[0]->is_locked);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/forum/admin/threads/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('Overclocking CPU/GPU/Memory Stability Testing Guidelines');
        $this->assertResponseContains('>John Doe<');
        $this->assertResponseContains('>Reported<');
        $this->assertResponseContains('Like others have said, sticky please!');
        $replies = $this->viewVariable('replies')->toArray();
        $this->assertCount(1, $replies);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/forum/admin/threads/add?category_id=7');
        $this->assertResponseOk();
        $this->assertResponseContains('<option value="7" selected="selected">');

        $data = [
            'category_id' => 7,
            'title' => 'test thread title',
            'message' => 'test thread body',
            'is_visible' => 1,
            'is_sticky' => 1,
            'is_locked' => 0,
        ];

        $this->post('/forum/admin/threads/add?category_id=7', $data);
        $this->assertRedirect('/forum/admin/threads?category_id=7');
        $this->assertSession('The thread has been saved.', 'Flash.flash.0.message');

        $thread = TableRegistry::get('CakeDC/Forum.Threads')->find()->orderDesc('Threads.id')->first();
        $this->assertNull($thread->get('parent_id'));
        $this->assertEquals(1, $thread->get('user_id'));
        $this->assertEquals($data['category_id'], $thread->get('category_id'));
        $this->assertEquals($data['title'], $thread->get('title'));
        $this->assertEquals($data['message'], $thread->get('message'));
        $this->assertEquals($data['is_visible'], $thread->get('is_visible'));
        $this->assertEquals($data['is_sticky'], $thread->get('is_sticky'));
        $this->assertEquals($data['is_locked'], $thread->get('is_locked'));
    }

    /**
     * Test failed add method
     *
     * @return void
     */
    public function testAddFailed()
    {
        $this->post('/forum/admin/threads/add?category_id=7', ['title' => '']);
        $this->assertResponseOk();
        $this->assertSession('The thread could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/forum/admin/threads/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('value="Overclocking CPU/GPU/Memory Stability Testing Guidelines"');

        $update = [
            'message' => 'Edited thread',
        ];
        $this->post('/forum/admin/threads/edit/1', $update);
        $this->assertRedirect('/forum/admin/threads?category_id=2');
        $this->assertSession('The thread has been saved.', 'Flash.flash.0.message');

        $thread = TableRegistry::get('CakeDC/Forum.Threads')->get(1);
        $this->assertEquals($update['message'], $thread->get('message'));
    }

    /**
     * Test failed edit method
     *
     * @return void
     */
    public function testEditFailed()
    {
        $this->post('/forum/admin/threads/edit/1', ['title' => '']);
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
        $Threads = TableRegistry::get('CakeDC/Forum.Threads');
        $thread = $Threads->newEntity(['title' => 'test thread', 'message' => 'test thread message']);
        $thread->parent_id = null;
        $thread->category_id = 2;
        $thread->user_id = 1;
        $this->assertNotFalse($Threads->save($thread));

        $this->delete('/forum/admin/threads/delete/' . $thread->id);

        $this->assertRedirect('/forum/admin/threads?category_id=2');
        $this->assertSession('The thread has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Threads->find()->where(['Threads.id' => $thread->id])->first());
    }
}
