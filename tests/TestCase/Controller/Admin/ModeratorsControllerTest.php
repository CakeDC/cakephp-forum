<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\TestCase\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * CakeDC\Forum\Controller\Admin\ModeratorsController Test Case
 */
class ModeratorsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'plugin.CakeDC/Forum.Categories',
        'plugin.CakeDC/Forum.Moderators',
        'plugin.CakeDC/Forum.Users',
        'plugin.CakeDC/Forum.Posts',
    ];

    public function setUp(): void
    {
        parent::setUp();

        Configure::write('Forum.authenticatedUserCallable', fn(Controller $controller): array => [
            'id' => 1,
            'username' => 'testing',
            'is_superuser' => true,
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
        $this->get('/forum/admin/moderators/add?category_id=6');
        $this->assertResponseOk();
        $this->assertResponseContains('<option value="6" selected="selected">');

        $data = [
            'category_id' => 6,
            'user_id' => 1,
        ];

        $this->post('/forum/admin/moderators/add', $data);
        $this->assertRedirect('/forum/admin/categories/view/6');
        $this->assertSession('The moderator has been added.', 'Flash.flash.0.message');

        $moderator = $this->fetchTable('CakeDC/Forum.Moderators')->find()->orderByDesc('Moderators.id')->first();
        $this->assertEquals($data['category_id'], $moderator->get('category_id'));
        $this->assertEquals($data['user_id'], $moderator->get('user_id'));
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $Moderators = $this->fetchTable('CakeDC/Forum.Moderators');
        $moderator = $Moderators->newEntity(['category_id' => 1, 'user_id' => 1]);
        $this->assertNotFalse($Moderators->save($moderator));

        $this->delete('/forum/admin/moderators/delete/' . $moderator->id);

        $this->assertRedirect('/forum/admin/categories/view/1');
        $this->assertSession('The moderator has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Moderators->find()->where(['Moderators.id' => $moderator->id])->first());
    }
}
