<?php
namespace CakeDC\Forum\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\UnauthorizedException;
use CakeDC\Forum\Controller\AppController as Controller;

/**
 * Categories Controller
 *
 *
 * @method \CakeDC\Forum\Model\Entity\Category[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\CategoriesTable $Categories
 * @mixin \Cake\Controller\Controller
 */
abstract class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Implement this method to avoid having to overwrite
     * the constructor and call parent.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->deny('*');

        if ($adminCheck = Configure::read('Forum.adminCheck')) {
            if (!$adminCheck($this->Auth->user())) {
                throw new UnauthorizedException();
            }
        }
    }
}
