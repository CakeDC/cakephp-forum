<?php
namespace CakeDC\Forum\Controller;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\UnauthorizedException;

/**
 * Reports Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Report[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\ReportsTable $Reports
 * @mixin \Cake\Controller\Controller
 */
class ReportsController extends AppController
{

    use \CakeDC\Forum\Controller\Traits\ForumTrait;

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

        $this->Auth->deny('*');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $filter = array_intersect_key($this->request->getQueryParams(), array_flip(['post_id', 'thread_id']));

        $this->loadModel('CakeDC/Forum.Moderators');
        if (!$categoryIds = $this->Moderators->getUserCategories($this->Auth->user('id'))) {
            throw new UnauthorizedException();
        }
        $filter['category_id'] = $categoryIds;

        $reports = $this->paginate($this->Reports, ['finder' => 'filtered'] + $filter);

        $this->set(compact('reports'));
        $this->set('_serialize', ['reports']);
    }

    /**
     * Add method
     *
     * @param string $categorySlug
     * @param string $threadSlug
     * @param int $postId
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($categorySlug, $threadSlug, $postId)
    {
        $post = $this->_getPost($categorySlug, $threadSlug, $postId);

        if ($this->Reports->find()->where(['user_id' => $this->Auth->user('id'), 'post_id' => $post->id])->first()) {
            throw new BadRequestException();
        }

        $report = $this->Reports->newEntity();
        $report->user_id = $this->Auth->user('id');
        $report->post_id = $post->id;

        if ($this->request->is(['post'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData(), ['fieldList' => ['message']]);
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
     * @param int $id
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $report = $this->Reports->get($id, ['contain' => ['Posts']]);

        if (!$this->_forumUserIsModerator($report->post->category_id)) {
            throw new UnauthorizedException();
        }

        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->request->referer());
    }
}
