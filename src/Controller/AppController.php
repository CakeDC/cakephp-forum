<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace CakeDC\Forum\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;
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
     * @var array|\ArrayAccess|null
     */
    protected $authenticatedUser;
    /**
     * @var bool
     */
    protected $loadedAuthenticatedUser = false;

    /**
     * Initialization hook method.
     *
     * Implement this method to avoid having to overwrite
     * the constructor and call parent.
     *
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Categories = $this->fetchTable('CakeDC/Forum.Categories');
        $this->Threads = $this->fetchTable('CakeDC/Forum.Threads');
        $this->Replies = $this->fetchTable('CakeDC/Forum.Replies');
        $this->Posts = $this->fetchTable('CakeDC/Forum.Posts');

        if (!$this->request->getParam('prefix')) {
            $this->Categories->addBehavior('CakeDC/Forum.VisibleOnly');
            $this->Threads->addBehavior('CakeDC/Forum.VisibleOnly');
            $this->Replies->addBehavior('CakeDC/Forum.VisibleOnly');
            $this->Posts->addBehavior('CakeDC/Forum.VisibleOnly');
        }

        $this->loadComponent('FormProtection');
    }

    /**
     * beforeFilter callback
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        if ($this->request->getParam('prefix') != 'admin') {
            $this->set('userInfo', $this->_getAuthenticatedUser());
        }
    }
}
