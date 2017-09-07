<?php
namespace CakeDC\Forum\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeDC\Forum\Controller\ReportsController Test Case
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
        'plugin.CakeDC/Forum.moderators',
        'plugin.CakeDC/Forum.likes',
    ];

    public function setUp()
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
        $this->get('/forum/reports');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('Must run with the IBT thread count set equal to the physical core count of the CPU.');
        $this->assertResponseContains('Like others have said, sticky please!');
        $this->assertResponseContains('This post is very rude');
        $this->assertResponseContains('Please remove this post');
        $reports = $this->viewVariable('reports')->toArray();
        $this->assertCount(2, $reports);

        // Another category moderator
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 3,
                    'username' => 'testing',
                ]
            ]
        ]);
        $this->get('/forum/reports');
        $this->assertResponseOk();
        $reports = $this->viewVariable('reports')->toArray();
        $this->assertCount(0, $reports);

        // Non-moderator
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 4,
                    'username' => 'testing',
                ]
            ]
        ]);
        $this->get('/forum/reports');
        $this->assertResponseError();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/forum/cpus-andoverclocking/anandtech-intels-skylake-sp-xeon-vs-amds-epyc-7000/4/report');
        $this->assertResponseOk();
        $this->assertResponseContains('>CPUs and Overclocking<');
        $this->assertResponseContains('With the exception of database software and vectorizable');

        $data = [
            'message' => 'test report message'
        ];

        $this->post('/forum/cpus-andoverclocking/anandtech-intels-skylake-sp-xeon-vs-amds-epyc-7000/4/report', $data);
        $this->assertRedirect('/forum/cpus-andoverclocking/anandtech-intels-skylake-sp-xeon-vs-amds-epyc-7000');
        $this->assertSession('The report has been saved.', 'Flash.flash.0.message');

        $report = TableRegistry::get('CakeDC/Forum.Reports')->find()->orderDesc('Reports.id')->first();
        $this->assertEquals(4, $report->get('post_id'));
        $this->assertEquals(1, $report->get('user_id'));
        $this->assertEquals($data['message'], $report->get('message'));
    }

    /**
     * Test failed add method
     *
     * @return void
     */
    public function testAddFailed()
    {
        $this->post('/forum/cpus-andoverclocking/anandtech-intels-skylake-sp-xeon-vs-amds-epyc-7000/4/report', ['message' => '']);
        $this->assertResponseOk();
        $this->assertSession('The report could not be saved. Please, try again.', 'Flash.flash.0.message');
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
        $report->post_id = 2;
        $report->user_id = 1;
        $this->assertNotFalse($Reports->save($report));

        $this->delete('/forum/reports/delete/' . $report->id);
        $this->assertRedirect('/');
        $this->assertSession('The report has been deleted.', 'Flash.flash.0.message');
        $this->assertNull($Reports->find()->where(['Reports.id' => $report->id])->first());

        // Delete report from category user is not moderator of
        $report = $Reports->newEntity(['message' => 'test report message']);
        $report->post_id = 5;
        $report->user_id = 1;
        $this->assertNotFalse($Reports->save($report));
        $this->delete('/forum/reports/delete/' . $report->id);
        $this->assertResponseError();
    }
}
