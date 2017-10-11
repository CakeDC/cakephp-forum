<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\Forum\Controller\Admin;

use CakeDC\Forum\Controller\AppController as Controller;
use Cake\Core\Configure;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Hash;

/**
 * Admin App Controller
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

        $this->Auth->deny();

        if (!$user = $this->Auth->user()) {
            return;
        }

        if ($adminCheck = Configure::read('Forum.adminCheck')) {
            if (is_string($adminCheck) && !Hash::get($user, $adminCheck)) {
                throw new UnauthorizedException();
            } elseif (is_callable($adminCheck) && !$adminCheck($user)) {
                throw new UnauthorizedException();
            }
        }
    }
}
