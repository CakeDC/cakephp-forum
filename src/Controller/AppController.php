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

namespace CakeDC\Forum\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use CakeDC\Forum\Controller\Traits\ForumTrait;

/**
 * Forum Controller
 *
 * @property \CakeDC\Forum\Model\Table\CategoriesTable $Categories
 * @property \CakeDC\Forum\Model\Table\ThreadsTable $Threads
 * @property \CakeDC\Forum\Model\Table\RepliesTable $Replies
 * @property \CakeDC\Forum\Model\Table\PostsTable $Posts
 * @property \CakeDC\Forum\Model\Table\ModeratorsTable $Moderators
 * @mixin \Cake\Controller\Controller
 */
class AppController extends BaseController
{

    use ForumTrait;

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

        $this->loadModel('CakeDC/Forum.Categories');
        $this->loadModel('CakeDC/Forum.Threads');
        $this->loadModel('CakeDC/Forum.Replies');
        $this->loadModel('CakeDC/Forum.Posts');

        if (!$this->request->getParam('prefix')) {
            $this->Categories->addBehavior('CakeDC/Forum.VisibleOnly');
            $this->Threads->addBehavior('CakeDC/Forum.VisibleOnly');
            $this->Replies->addBehavior('CakeDC/Forum.VisibleOnly');
            $this->Posts->addBehavior('CakeDC/Forum.VisibleOnly');
        }
    }

    /**
     * beforeFilter callback
     *
     * @param Event $event Event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if ($this->request->getParam('prefix') != 'admin') {
            $this->set('userInfo', $this->Auth->user());
        }
    }
}
