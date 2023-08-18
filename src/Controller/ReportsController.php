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

/**
 * Reports Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Report[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\ReportsTable $Reports
 * @mixin \Cake\Controller\Controller
 */
class ReportsController extends AppController
{
    /**
     * Index method
     */
    public function index(): void
    {
        $filter = array_intersect_key($this->request->getQueryParams(), array_flip(['post_id', 'thread_id']));

        $this->Moderators = $this->fetchTable('CakeDC/Forum.Moderators');
        $categoryIds = $this->Moderators->getUserCategories($this->_getAuthenticatedUserId());
        if (!$categoryIds) {
            throw new UnauthorizedException();
        }
        $filter['category_id'] = $categoryIds;

        $reports = $this->paginate($this->Reports, ['finder' => 'filtered'] + $filter);

        $this->set(compact('reports'));
        $this->viewBuilder()->setOption('serialize', ['reports']);
    }

    /**
     * Add method
     *
     * @param string $postId Post id
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(string $categorySlug, string $threadSlug, string $postId)
    {
        $post = $this->_getPost($categorySlug, $threadSlug, $postId);
        $userId = $this->_getAuthenticatedUserId();
        if ($this->Reports->find()->where(['user_id' => $userId, 'post_id' => $post->id])->first()) {
            throw new BadRequestException();
        }

        $report = $this->Reports->newEmptyEntity();
        $report->user_id = $userId;
        $report->post_id = $post->id;

        if ($this->request->is(['post'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData(), ['fields' => ['message']]);
            if ($this->Reports->save($report)) {
                $this->Flash->success(__('The report has been saved.'));

                return $this->redirect(['controller' => 'Threads', 'action' => 'view', 'category' => $categorySlug, 'thread' => $threadSlug]);
            }
            $this->Flash->error(__('The report could not be saved. Please, try again.'));
        }

        $this->set(compact('report'));
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);

        /** @var \CakeDC\Forum\Model\Entity\Report $report */
        $report = $this->Reports->get($id, contain: ['Posts']);

        if (!$this->_forumUserIsModerator($report->post->category_id)) {
            throw new UnauthorizedException();
        }

        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->request->referer() ?? '/');
    }
}
