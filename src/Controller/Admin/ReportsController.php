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

use Cake\Http\Response;
use Cake\Utility\Hash;

/**
 * Reports Controller
 *
 * @method \Cake\Datasource\Paging\PaginatedInterface<\CakeDC\Forum\Model\Entity\Report> paginate($object = null, array $settings = [])
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
        /** @uses \CakeDC\Forum\Model\Table\ReportsTable::findFiltered() */

        $reports = $this->paginate($this->Reports->find(
            type: 'filtered',
            post_id: Hash::get($filter, 'post_id'),
            thread_id: Hash::get($filter, 'post_id'),
            category_id: Hash::get($filter, 'category_id')
        ));

        $this->set(compact('reports'));
        $this->viewBuilder()->setOption('serialize', ['reports']);
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $report = $this->Reports->get($id);

        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->request->referer() ?? '/');
    }
}
