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

/**
 * Threads Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Thread[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\ThreadsTable $Threads
 * @mixin \Cake\Controller\Controller
 */
class ThreadsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
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
        $this->set('_serialize', ['threads', 'categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Thread id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $thread = $this->Threads->get($id, [
            'contain' => ['Categories', 'Users', 'Likes.Users'],
        ]);

        $replies = [];
        if (!$thread->parent_id) {
            $replies = $this->paginate(
                $this->loadModel('CakeDC/Forum.Replies'),
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
        $this->set('_serialize', ['thread', 'replies']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
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
        $this->set('_serialize', ['thread', 'categories']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
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
        $this->set('_serialize', ['thread', 'categories']);
    }

    /**
     * Move method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function move($id = null)
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
        $this->set('_serialize', ['thread', 'categories']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $thread = $this->Threads->get($id);
        if ($this->Threads->delete($thread)) {
            $this->Flash->success(__('The thread has been deleted.'));
        } else {
            $this->Flash->error(__('The thread could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', '?' => ['category_id' => $thread->category_id]]);
    }
}
