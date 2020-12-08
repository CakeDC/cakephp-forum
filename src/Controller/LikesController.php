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

namespace CakeDC\Forum\Controller;

use Cake\Http\Exception\BadRequestException;

/**
 * Likes Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Like[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\LikesTable $Likes
 * @mixin \Cake\Controller\Controller
 */
class LikesController extends AppController
{
    /**
     * Initialization hook method.
     *
     * Implement this method to avoid having to overwrite
     * the constructor and call parent.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Add method
     *
     * @param string $categorySlug Category slug
     * @param string $threadSlug Thread slug
     * @param int $postId Post id
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($categorySlug, $threadSlug, $postId)
    {
        $post = $this->_getPost($categorySlug, $threadSlug, $postId);
        $userId = $this->_getAuthenticatedUserId();
        if ($this->Likes->find()->where(['user_id' => $userId, 'post_id' => $post->id])->first()) {
            throw new BadRequestException();
        }

        $like = $this->Likes->newEmptyEntity();
        $like->user_id = $userId;
        $like->post_id = $post->id;

        if ($this->request->is(['post'])) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(__('The like has been saved.'));
            } else {
                $this->Flash->error(__('The like could not be saved. Please, try again.'));
            }
        }

        return $this->redirect(['controller' => 'Threads', 'action' => 'view', 'category' => $categorySlug, 'thread' => $threadSlug]);
    }
}
