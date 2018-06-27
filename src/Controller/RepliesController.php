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

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\UnauthorizedException;

/**
 * Replies Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Reply[] paginate($object = null, array $settings = [])
 * @mixin \Cake\Controller\Controller
 */
class RepliesController extends AppController
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
    }

    /**
     * Add method
     *
     * @param string $categorySlug Category slug
     * @param string $threadSlug Thread slug
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($categorySlug, $threadSlug)
    {
        $thread = $this->_getThread($categorySlug, $threadSlug);
        if ($thread->is_locked) {
            throw new BadRequestException();
        }

        $reply = $this->Replies->newEntity();
        $reply->user_id = $this->Auth->user('id');
        $reply->set('category', $thread->category);
        $reply->set('thread', $thread);

        $this->set(compact('reply'));

        if ($this->request->is(['post'])) {
            return $this->_save($reply);
        }
    }

    /**
     * Edit method
     *
     * @param string $categorySlug Category slug.
     * @param string $threadSlug Thread slug.
     * @param int $id Reply id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($categorySlug, $threadSlug, $id)
    {
        $reply = $this->_getReply($categorySlug, $threadSlug, $id);

        if ($reply->user_id != $this->Auth->user('id')) {
            throw new UnauthorizedException();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->_save($reply);
        }
    }

    /**
     * Delete method
     *
     * @param string $categorySlug Category slug.
     * @param string $threadSlug Thread slug.
     * @param int $id Reply id
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($categorySlug, $threadSlug, $id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $reply = $this->_getReply($categorySlug, $threadSlug, $id);

        if ($reply->user_id !== $this->Auth->user('id') && !$this->_forumUserIsModerator($reply->category_id)) {
            throw new UnauthorizedException();
        }

        if ($this->Replies->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Threads', 'action' => 'view', 'category' => $categorySlug, 'thread' => $threadSlug]);
    }

    /**
     * Save thread
     *
     * @param \CakeDC\Forum\Model\Entity\Reply $reply Reply
     * @return \Cake\Http\Response|null
     */
    protected function _save($reply)
    {
        $reply = $this->Replies->patchEntity($reply, $this->request->getData(), ['fields' => ['message']]);
        if (!$this->Replies->save($reply)) {
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));

            return null;
        }

        $this->Flash->success(__('The reply has been saved.'));

        if (!$reply->category || !$reply->thread) {
            $this->Replies->loadInto($reply, ['Categories', 'Threads']);
        }

        return $this->redirect(['controller' => 'Threads', 'action' => 'view', 'category' => $reply->category->slug, 'thread' => $reply->thread->slug]);
    }
}
