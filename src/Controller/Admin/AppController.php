<?php
declare(strict_types=1);

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

use Cake\Core\Configure;
use CakeDC\Forum\Controller\AppController as Controller;

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
    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->deny();

        if ($this->Auth->user() && Configure::read('Forum.adminCheck') && !$this->_forumUserIsAdmin()) {
            throw new \Cake\Http\Exception\UnauthorizedException();
        }
    }
}
