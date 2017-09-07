<?php
namespace CakeDC\Forum\Controller\Admin;

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
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $filter = array_intersect_key($this->request->getQueryParams(), array_flip(['post_id', 'thread_id']));

        $reports = $this->paginate($this->Reports, ['finder' => 'filtered'] + $filter);

        $this->set(compact('reports'));
        $this->set('_serialize', ['reports']);
    }

    /**
     * Delete method
     *
     * @param int $id
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $report = $this->Reports->get($id);

        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->request->referer());
    }
}
