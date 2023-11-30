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

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;

/**
 * Replies Controller
 *
 * @method \Cake\Datasource\Paging\PaginatedInterface<\CakeDC\Forum\Model\Entity\Reply> paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\RepliesTable $Replies
 * @mixin \Cake\Controller\Controller
 */
class RepliesController extends AppController
{
    /**
     * View method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $reply = $this->Replies->get($id, contain: ['Threads', 'Categories', 'Users']);

        $this->set(compact('reply'));
        $this->viewBuilder()->setOption('serialize', ['reply']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parentId = $this->request->getQuery('parent_id');
        if (!$parentId) {
            throw new BadRequestException();
        }

        /**
         * @var \CakeDC\Forum\Model\Entity\Thread $thread
         */
        $thread = $this->Replies->Threads->get($parentId);
        $reply = $this->Replies->newEmptyEntity();
        $reply->user_id = $this->_getAuthenticatedUserId();
        $reply->parent_id = $thread->id;
        $reply->category_id = $thread->category_id;
        if ($this->request->is('post')) {
            $reply = $this->Replies->patchEntity($reply, $this->request->getData());
            if ($this->Replies->save($reply)) {
                $this->Flash->success(__('The reply has been saved.'));

                return $this->redirect(['controller' => 'Threads', 'action' => 'view', $reply->parent_id]);
            }
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
        }

        $this->set(compact('reply', 'thread'));
        $this->viewBuilder()->setOption('serialize', ['reply', 'thread']);
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        /** @var \CakeDC\Forum\Model\Entity\Reply $reply */
        $reply = $this->Replies->get($id, contain: ['Threads']);

        $thread = $reply->thread;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $reply = $this->Replies->patchEntity($reply, $this->request->getData());
            if ($this->Replies->save($reply)) {
                $this->Flash->success(__('The reply has been saved.'));

                return $this->redirect(['controller' => 'Threads', 'action' => 'view', $reply->parent_id]);
            }
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
        }

        $this->set(compact('reply', 'thread'));
        $this->viewBuilder()->setOption('serialize', ['reply', 'thread']);
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        /**
         * @var \CakeDC\Forum\Model\Entity\Reply $reply
         */
        $reply = $this->Replies->get($id);
        if ($this->Replies->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Threads', 'action' => 'view', $reply->parent_id]);
    }
}
