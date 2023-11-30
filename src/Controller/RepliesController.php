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

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Response;
use CakeDC\Forum\Model\Entity\Reply;

/**
 * Replies Controller
 *
 * @method \Cake\Datasource\Paging\PaginatedInterface<\CakeDC\Forum\Model\Entity\Reply> paginate($object = null, array $settings = [])
 * @mixin \Cake\Controller\Controller
 */
class RepliesController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(string $categorySlug, string $threadSlug)
    {
        $thread = $this->_getThread($categorySlug, $threadSlug);
        if ($thread->is_locked) {
            throw new BadRequestException();
        }

        /** @var \CakeDC\Forum\Model\Entity\Reply $reply */
        $reply = $this->Replies->newEmptyEntity();
        $reply->user_id = $this->_getAuthenticatedUserId();
        $reply->set('category', $thread->category);
        $reply->set('thread', $thread);

        $this->set(compact('reply'));

        if ($this->request->is(['post'])) {
            return $this->save($reply);
        }
    }

    /**
     * Edit method
     *
     * @param string $id Reply id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(string $categorySlug, string $threadSlug, string $id)
    {
        $reply = $this->_getReply($categorySlug, $threadSlug, $id);

        if ($reply->user_id != $this->_getAuthenticatedUserId()) {
            throw new UnauthorizedException();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->save($reply);
        }
    }

    /**
     * Delete method
     *
     * @param string $id Reply id
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $categorySlug, string $threadSlug, string $id): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $reply = $this->_getReply($categorySlug, $threadSlug, $id);

        if (
            $reply->user_id !== $this->_getAuthenticatedUserId() &&
            !$this->_forumUserIsModerator($reply->category_id)
        ) {
            throw new UnauthorizedException();
        }

        if ($this->Replies->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'controller' => 'Threads',
            'action' => 'view',
            'category' => $categorySlug,
            'thread' => $threadSlug,
        ]);
    }

    /**
     * Save thread
     */
    protected function save(Reply $reply): ?Response
    {
        /** @var \CakeDC\Forum\Model\Entity\Reply $reply */
        $reply = $this->Replies->patchEntity($reply, $this->request->getData(), ['fields' => ['message']]);
        if (!$this->Replies->save($reply)) {
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));

            return null;
        }

        $this->Flash->success(__('The reply has been saved.'));

        if (!$reply->category || !$reply->thread) {
            $this->Replies->loadInto($reply, ['Categories', 'Threads']);
        }

        return $this->redirect([
            'controller' => 'Threads',
            'action' => 'view',
            'category' => $reply['category']['slug'],
            'thread' => $reply['thread']['slug'],
        ]);
    }
}
