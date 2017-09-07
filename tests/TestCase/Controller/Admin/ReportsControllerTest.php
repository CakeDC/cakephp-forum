<?php
namespace CakeDC\Forum\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\Admin\ReportsController Test Case
 */
class ReportsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.CakeDC/Forum.categories',
        'plugin.CakeDC/Forum.posts',
        'plugin.CakeDC/Forum.users',
        'plugin.CakeDC/Forum.reports',
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
        $this->get('/forum/admin/reports');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('Must run with the IBT thread count set equal to the physical core count of the CPU.');
        $this->assertResponseContains('Like others have said, sticky please!');
        $this->assertResponseContains('This post is very rude');
        $this->assertResponseContains('Please remove this post');
        $reports = $this->viewVariable('reports')->toArray();
        $this->assertCount(2, $reports);

        $this->get('/forum/admin/reports?post_id=1');
        $this->assertResponseOk();
        $this->assertResponseContains('This post is very rude');
        $this->assertResponseNotContains('Please remove this post');
        $reports = $this->viewVariable('reports')->toArray();
        $this->assertCount(1, $reports);
        $this->assertEquals(1, $reports[0]->id);

        $this->get('/forum/admin/reports?post_id=2');
        $this->assertResponseOk();
        $this->assertResponseNotContains('This post is very rude');
        $this->assertResponseContains('Please remove this post');
        $reports = $this->viewVariable('reports')->toArray();
        $this->assertCount(1, $reports);
        $this->assertEquals(2, $reports[0]->id);

        $this->get('/forum/admin/reports?post_id=99');
        $this->assertResponseOk();
        $reports = $this->viewVariable('reports')->toArray();
        $this->assertCount(0, $reports);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $Reports = TableRegistry::get('CakeDC/Forum.Reports');
        $report = $Reports->newEntity(['message' => 'test report message']);
        $report->post_id = 1;
        $report->user_id = 1;
        $this->assertNotFalse($Reports->save($report));

        $this->delete('/forum/admin/reports/delete/' . $report->id);

        $this->assertRedirect('/');
        $this->assertSession('The report has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Reports->find()->where(['Reports.id' => $report->id])->first());
    }
}
