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

/**
 * Moderators Controller
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
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $moderator = $this->Moderators->newEmptyEntity();
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
        $this->viewBuilder()->setOption('serialize', ['moderator', 'categories', 'users']);
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        /** @var \CakeDC\Forum\Model\Entity\Moderator $moderator */
        $moderator = $this->Moderators->get($id);
        if ($this->Moderators->delete($moderator)) {
            $this->Flash->success(__('The moderator has been deleted.'));
        } else {
            $this->Flash->error(__('The moderator could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Categories', 'action' => 'view', $moderator->category_id]);
    }
}
