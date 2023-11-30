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
namespace CakeDC\Forum\Controller\Admin;

use Cake\Core\Configure;
use Cake\Http\Response;

/**
 * Threads Controller
 *
 * @method \Cake\Datasource\Paging\PaginatedInterface<\CakeDC\Forum\Model\Entity\Thread> paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\ThreadsTable $Threads
 * @mixin \Cake\Controller\Controller
 */
class ThreadsController extends AppController
{
    /**
     * Index method
     */
    public function index(): void
    {
        $limit = Configure::read('Forum.threadsPerPage');
        $contain = ['Users', 'LastReplies.Users', 'ReportedReplies'];
        $group = 'Threads.id';
        $conditions = [];
        $categoryId = $this->request->getQuery('category_id');
        if ($categoryId) {
            $conditions[$this->Threads->aliasField('category_id')] = $categoryId;
        }
        foreach (['is_sticky', 'is_locked', 'is_visible'] as $field) {
            $fieldValue = $this->request->getQuery($field, '');
            if ($fieldValue !== '') {
                $fieldValue = is_scalar($fieldValue) ? (int)$fieldValue : 0;
                $conditions[$this->Threads->aliasField($field)] = $fieldValue == 1;
            }
        }
        $threads = $this->paginate($this->Threads, compact('contain', 'conditions', 'limit', 'group'));

        $categories = $this->Threads->Categories->getOptionsList(true);

        $this->set(compact('threads', 'categories'));
        $this->viewBuilder()->setOption('serialize', ['threads', 'categories']);
    }

    /**
     * View method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        /** @var \CakeDC\Forum\Model\Entity\Post $thread */
        $thread = $this->Threads->get($id, contain: ['Categories', 'Users', 'Likes.Users']);

        $replies = [];
        if (!$thread->parent_id) {
            $replies = $this->paginate(
                $this->fetchTable('CakeDC/Forum.Replies'),
                [
                    'conditions' => [
                        $this->Threads->Replies->aliasField('parent_id') => $thread->id,
                    ],
                    'contain' => ['Users', 'Likes.Users'],
                    'limit' => Configure::read('Forum.postsPerPage'),
                ]
            );
        }

        $this->set(compact('thread', 'replies'));
        $this->viewBuilder()->setOption('serialize', ['thread', 'replies']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thread = $this->Threads->newEmptyEntity();
        $thread->user_id = $this->_getAuthenticatedUserId();
        if ($this->request->is('post')) {
            $thread = $this->Threads->patchEntity($thread, $this->request->getData());
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));

                return $this->redirect(['action' => 'index', '?' => ['category_id' => $thread->category_id]]);
            }
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));
        }

        $categories = $this->Threads->Categories->getOptionsList(true);

        $this->set(compact('thread', 'categories'));
        $this->viewBuilder()->setOption('serialize', ['thread', 'categories']);
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $thread = $this->Threads->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $thread = $this->Threads->patchEntity($thread, $this->request->getData());
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));

                return $this->redirect(['action' => 'index', '?' => ['category_id' => $thread->category_id]]);
            }
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));
        }

        $categories = $this->Threads->Categories->getOptionsList(true);

        $this->set(compact('thread', 'categories'));
        $this->viewBuilder()->setOption('serialize', ['thread', 'categories']);
    }

    /**
     * Move method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function move(?string $id = null)
    {
        $thread = $this->Threads->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $thread = $this->Threads->patchEntity($thread, $this->request->getData(), ['validate' => 'moveThread']);
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been moved.'));

                return $this->redirect(['action' => 'index', '?' => ['category_id' => $thread->category_id]]);
            }
            $this->Flash->error(__('The thread could not be moved. Please, try again.'));
        }

        $categories = $this->Threads->Categories->getOptionsList(true);

        $this->set(compact('thread', 'categories'));
        $this->viewBuilder()->setOption('serialize', ['thread', 'categories']);
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        /** @var \CakeDC\Forum\Model\Entity\Thread $thread */
        $thread = $this->Threads->get($id);
        if ($this->Threads->delete($thread)) {
            $this->Flash->success(__('The thread has been deleted.'));
        } else {
            $this->Flash->error(__('The thread could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', '?' => ['category_id' => $thread->category_id]]);
    }
}
