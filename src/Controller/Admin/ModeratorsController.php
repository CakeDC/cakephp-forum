<?php
namespace CakeDC\Forum\Controller\Admin;

/**
 * Moderators Controller
 *
 *
 * @method \CakeDC\Forum\Model\Entity\Moderator[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\ModeratorsTable $Moderators
 * @mixin \Cake\Controller\Controller
 */
class ModeratorsController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $moderator = $this->Moderators->newEntity();
        if ($this->request->is('post')) {
            $moderator = $this->Moderators->patchEntity($moderator, $this->request->getData());
            if ($this->Moderators->save($moderator)) {
                $this->Flash->success(__('The moderator has been added.'));

                return $this->redirect(['controller' => 'Categories', 'action' => 'view', $moderator->category_id]);
            }
            $this->Flash->error(__('The moderator could not be saved. Please, try again.'));
        }

        $categories = $this->Moderators->Categories->getOptionsList(true);
        $users = $this->Moderators->Users->find('list')->toArray();

        $this->set(compact('moderator', 'categories', 'users'));
        $this->set('_serialize', ['moderator', 'categories', 'users']);
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
        $moderator = $this->Moderators->get($id);
        if ($this->Moderators->delete($moderator)) {
            $this->Flash->success(__('The moderator has been deleted.'));
        } else {
            $this->Flash->error(__('The moderator could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Categories', 'action' => 'view', $moderator->category_id]);
    }
}
