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
use ArrayAccess;
use Cake\Event\EventInterface;
use Cake\ORM\Table;
use CakeDC\Forum\Controller\Traits\ForumTrait;
use CakeDC\Forum\Model\Table\CategoriesTable;
use CakeDC\Forum\Model\Table\ModeratorsTable;
use CakeDC\Forum\Model\Table\PostsTable;
use CakeDC\Forum\Model\Table\RepliesTable;
use CakeDC\Forum\Model\Table\ThreadsTable;

/**
 * Forum Controller
 *
 * @mixin \Cake\Controller\Controller
 */
class AppController extends BaseController
{
    use ForumTrait;

    /**
     * @var \ArrayAccess|array|null
     */
    protected array|ArrayAccess|null $authenticatedUser = null;
    /**
     * @var bool
     */
    protected bool $loadedAuthenticatedUser = false;
    protected CategoriesTable|Table $Categories;
    protected ThreadsTable|Table $Threads;
    protected RepliesTable|Table $Replies;
    protected PostsTable|Table $Posts;
    protected ModeratorsTable|Table $Moderators;

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
