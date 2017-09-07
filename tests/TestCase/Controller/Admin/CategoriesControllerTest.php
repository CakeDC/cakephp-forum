<?php
namespace CakeDC\Forum\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\Admin\CategoriesController Test Case
 */
class CategoriesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.CakeDC/Forum.categories',
        'plugin.CakeDC/Forum.posts',
        'plugin.CakeDC/Forum.moderators',
        'plugin.CakeDC/Forum.users',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'testing',
                    'is_superuser' => true,
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
        $this->get('/forum/admin');

        $this->assertResponseOk();
        $this->assertResponseContains('Hardware and Technology');
        $this->assertResponseContains('>Hidden<');
        $this->assertResponseContains('>Moderators: John Doe');

        $categories = $this->viewVariable('categories')->toArray();
        $this->assertNotEmpty($categories);
        $this->assertCount(3, $categories);
        $this->assertCount(3, $categories[0]->children);
        $this->assertEquals('Hardware and Technology', $categories[0]->title);
        $this->assertCount(3, $categories[1]->children);
        $this->assertEquals('Software', $categories[1]->title);
        $this->assertCount(4, $categories[2]->children);
        $this->assertEquals('Consumer Electronics', $categories[2]->title);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/forum/admin/categories/view/4');
        $this->assertResponseOk();
        $this->assertResponseContains('>Motherboards<');
        $this->assertResponseContains('>No moderators.<');

        $this->get('/forum/admin/categories/view/2');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('>Moderator<');
        $this->assertResponseContains('>John Doe<');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/forum/admin/categories/add?parent_id=1');
        $this->assertResponseOk();
        $this->assertResponseContains('<option value="1" selected="selected">');

        $data = [
            'parent_id' => 1,
            'title' => 'New Category',
            'description' => 'New Category Description',
            'is_visible' => 1
        ];

        $this->post('/forum/admin/categories/add', $data);
        $this->assertRedirect('forum/admin');
        $this->assertSession('The category has been saved.', 'Flash.flash.0.message');

        $category = TableRegistry::get('CakeDC/Forum.Categories')->find()->orderDesc('Categories.id')->first();
        $this->assertEquals($data['parent_id'], $category->get('parent_id'));
        $this->assertEquals($data['title'], $category->get('title'));
        $this->assertEquals('new-category', $category->get('slug'));
        $this->assertEquals($data['description'], $category->get('description'));
        $this->assertEquals($data['is_visible'], $category->get('is_visible'));
    }

    /**
     * Test failed add method
     *
     * @return void
     */
    public function testAddFailed()
    {
        $this->post('/forum/admin/categories/add', ['title' => '']);
        $this->assertResponseOk();
        $this->assertSession('The category could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/forum/admin/categories/edit/4');
        $this->assertResponseOk();
        $this->assertResponseContains('value="Motherboards"');
        $this->assertResponseContains('value="motherboards"');

        $update = [
            'parent_id' => 3,
            'title' => 'Motherboards Updated',
            'slug' => 'motherboards-updated',
            'description' => 'Motherboards description',
            'is_visible' => 0,
        ];
        $this->post('/forum/admin/categories/edit/4', $update);
        $this->assertRedirect('/forum/admin');
        $this->assertSession('The category has been saved.', 'Flash.flash.0.message');

        $category = TableRegistry::get('CakeDC/Forum.Categories')->get(4);
        $this->assertEquals($update['parent_id'], $category->get('parent_id'));
        $this->assertEquals($update['title'], $category->get('title'));
        $this->assertEquals($update['slug'], $category->get('slug'));
        $this->assertEquals($update['description'], $category->get('description'));
        $this->assertEquals($update['is_visible'], $category->get('is_visible'));
    }

    /**
     * Test failed edit method
     *
     * @return void
     */
    public function testEditFailed()
    {
        $this->post('/forum/admin/categories/edit/4', ['title' => '']);
        $this->assertResponseOk();
        $this->assertSession('The category could not be saved. Please, try again.', 'Flash.flash.0.message');

        $this->get('/forum/admin/categories/edit/99');
        $this->assertResponseError();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $Categories = TableRegistry::get('CakeDC/Forum.Categories');
        $category = $Categories->newEntity(['parent_id' => 1, 'title' => 'test cat', 'is_visible' => 1]);
        $this->assertNotFalse($Categories->save($category));

        $this->delete('/forum/admin/categories/delete/' . $category->id);

        $this->assertRedirect('/forum/admin');
        $this->assertSession('The category has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Categories->find()->where(['Categories.id' => $category->id])->first());
    }

    /**
     * Test moveUp method
     *
     * @return void
     */
    public function testMoveUp()
    {
        $Categories = TableRegistry::get('CakeDC/Forum.Categories');

        $categories = $Categories->find('threaded')->toArray();
        $this->assertEquals(2, $categories[0]->children[0]->id);
        $this->assertEquals(6, $categories[0]->children[1]->id);

        $this->post('/forum/admin/categories/moveUp/6');
        $this->assertRedirect('/forum/admin');
        $this->assertSession('The category has been moved.', 'Flash.flash.0.message');

        $categories = $Categories->find('threaded')->toArray();
        $this->assertEquals(6, $categories[0]->children[0]->id);
        $this->assertEquals(2, $categories[0]->children[1]->id);
    }

    /**
     * Test moveDown method
     *
     * @return void
     */
    public function testMoveDown()
    {
        $Categories = TableRegistry::get('CakeDC/Forum.Categories');

        $categories = $Categories->find('threaded')->toArray();
        $this->assertEquals(2, $categories[0]->children[0]->id);
        $this->assertEquals(6, $categories[0]->children[1]->id);

        $this->post('/forum/admin/categories/moveDown/2');
        $this->assertRedirect('/forum/admin');
        $this->assertSession('The category has been moved.', 'Flash.flash.0.message');

        $categories = $Categories->find('threaded')->toArray();
        $this->assertEquals(6, $categories[0]->children[0]->id);
        $this->assertEquals(2, $categories[0]->children[1]->id);
    }
}
