<?php
namespace CakeDC\Forum\Controller\Admin;

use Cake\Network\Exception\BadRequestException;

/**
 * Replies Controller
 *
 *
 * @method \CakeDC\Forum\Model\Entity\Reply[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\RepliesTable $Replies
 * @mixin \Cake\Controller\Controller
 */
class RepliesController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reply = $this->Replies->get($id, [
            'contain' => ['Threads', 'Categories', 'Users']
        ]);

        $this->set(compact('reply'));
        $this->set('_serialize', ['reply']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thread = null;
        if (!$parentId = $this->request->getQuery('parent_id')) {
            throw new BadRequestException();
        }

        $thread = $this->Replies->Threads->get($parentId);
        $reply = $this->Replies->newEntity();
        $reply->user_id = $this->Auth->user('id');
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
        $this->set('_serialize', ['reply', 'thread']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reply = $this->Replies->get($id, [
            'contain' => ['Threads']
        ]);

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
        $this->set('_serialize', ['reply', 'thread']);
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
        $reply = $this->Replies->get($id);
        if ($this->Replies->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Threads', 'action' => 'view', $reply->parent_id]);
    }
}
