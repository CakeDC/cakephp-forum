<?php
declare(strict_types=1);

namespace CakeDC\Forum\Test\App\Controller;

use Cake\Controller\Controller;

/**
 * This is a placeholder class.
 * Create the same file in app/Controller/AppController.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 */
class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Users',
                ],
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => false,
                'prefix' => false,
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => false,
                'prefix' => false,
                'home',
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => false,
                'prefix' => false,
                'home',
            ],
        ]);
    }
}
