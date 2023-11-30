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

use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Response;
use CakeDC\Forum\Model\Entity\Thread;

/**
 * Threads Controller
 *
 * @method \Cake\Datasource\Paging\PaginatedInterface<\CakeDC\Forum\Model\Entity\Thread> paginate($object = null, array $settings = [])
 * @mixin \Cake\Controller\Controller
 */
class ThreadsController extends AppController
{
    /**
     * Initialization hook method.
     *
     * Implement this method to avoid having to overwrite
     * the constructor and call parent.
     *
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->paginate['Threads'] = [
            'limit' => Configure::read('Forum.threadsPerPage'),
        ];

        $this->paginate['Posts'] = [
            'limit' => Configure::read('Forum.postsPerPage'),
        ];
    }

    /**
     * List threads in category method
     */
    public function index(): void
    {
        $categorySlug = func_get_arg(0);
        if (!$categorySlug) {
            throw new BadRequestException();
        }

        $category = $this->_getCategory($categorySlug);
        $subCategories = $category->children;
        if ($subCategories) {
            $this->set('categories', $subCategories);
            $this->render('category');

            return;
        }

        /** @uses \CakeDC\Forum\Model\Table\ThreadsTable::findByCategory() */
        $threads = $this->paginate($this->Threads->find(type: 'byCategory', category_id: $category->id));

        $this->set(compact('threads'));
    }

    /**
     * List threads user has created or participated in
     */
    public function my(): void
    {
        $threads = $this->paginate($this->Threads->find('byUser', user_id: $this->_getAuthenticatedUserId()));

        $this->set(compact('threads'));
    }

    /**
     * View method
     *
     * @param string $categorySlug Category slug
     * @param string $slug Thread slug
     * @return void
     */
    public function view(string $categorySlug, string $slug): void
    {
        $thread = $this->_getThread($categorySlug, $slug);

        $query = $this->Posts->find('byThread', thread_id: $thread->id);
        $userId = $this->_getAuthenticatedUserId();
        if ($userId) {
            $query = $query
                ->find('withUserReport', user_id: $userId)
                ->find('withUserLike', user_id: $userId);
        }
        $posts = $this->paginate($query);

        $page = $this->request->getQuery('page');
        $pageCount = $this->request->getParam('paging.Posts.pageCount');
        if ($page === 'last' && $pageCount !== 1) {
            $this->request = $this->request->withQueryParams(['page' => $pageCount]);
            $posts = $this->paginate($query);
        }

        $reply = $this->Replies->newEmptyEntity();

        $this->set(compact('posts', 'reply'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(string $categorySlug)
    {
        $category = $this->_getCategory($categorySlug);
        if ($category->sub_categories) {
            throw new BadRequestException();
        }

        /** @var \CakeDC\Forum\Model\Entity\Thread $thread */
        $thread = $this->Threads->newEmptyEntity();
        $thread->user_id = $this->_getAuthenticatedUserId();
        $thread->set('category', $category);

        $this->set(compact('thread'));

        if ($this->request->is(['post'])) {
            return $this->_save($thread);
        }
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(string $categorySlug, string $threadSlug)
    {
        $thread = $this->_getThread($categorySlug, $threadSlug);
        if ($thread->user_id != $this->_getAuthenticatedUserId()) {
            throw new UnauthorizedException();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->_save($thread);
        }
    }

    /**
     * Move method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function move(string $categorySlug, string $threadSlug)
    {
        $thread = $this->_getThread($categorySlug, $threadSlug);
        if (!$this->_forumUserIsModerator($thread->category_id)) {
            throw new UnauthorizedException();
        }

        $categories = $this->Categories->getOptionsList(true);

        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->_save($thread, ['category_id']);
        }

        $this->set(compact('categories'));
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $categorySlug, string $threadSlug): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $thread = $this->_getThread($categorySlug, $threadSlug);
        if (
            $thread->user_id !== $this->_getAuthenticatedUserId() &&
            !$this->_forumUserIsModerator($thread->category_id)
        ) {
            throw new UnauthorizedException();
        }

        if ($this->Threads->delete($thread)) {
            $this->Flash->success(__('The thread has been deleted.'));
        } else {
            $this->Flash->error(__('The thread could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Threads', 'action' => 'index', 'category' => $categorySlug]);
    }

    /**
     * Save thread
     */
    protected function _save(Thread $thread, array $fields = ['title', 'message']): ?Response
    {
        if ($this->_forumUserIsModerator($thread->category_id)) {
            $fields = array_merge($fields, ['is_sticky', 'is_locked']);
        }

        /** @var \CakeDC\Forum\Model\Entity\Thread $thread */
        $thread = $this->Threads->patchEntity($thread, $this->request->getData(), compact('fields'));
        $reloadCategory = $thread->isDirty('category_id');

        if (!$this->Threads->save($thread)) {
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));

            return null;
        }

        $this->Flash->success(__('The thread has been saved.'));

        if ($reloadCategory) {
            /** @var \CakeDC\Forum\Model\Entity\Thread $thread */
            $thread = $this->Threads->loadInto($thread, ['Categories']);
        }

        return $this->redirect([
            'controller' => 'Threads',
            'action' => 'view',
            'category' => $thread->category->slug,
            'thread' => $thread->slug,
        ]);
    }
}
