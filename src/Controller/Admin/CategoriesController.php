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

namespace CakeDC\Forum\Controller\Admin;

/**
 * Categories Controller
 *
 *
 * @method \CakeDC\Forum\Model\Entity\Category[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\CategoriesTable $Categories
 * @mixin \Cake\Controller\Controller
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $categories = $this->Categories->find('threaded')->contain(['Moderators.Users']);

        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['ParentCategories', 'SubCategories', 'Moderators.Users'],
        ]);

        $this->set('category', $category);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

        $categories = $this->Categories->find('list')->where(['parent_id IS' => null])->toArray();

        $this->set(compact('category', 'categories'));
        $this->set('_serialize', ['category', 'categories']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

        $categories = $this->Categories->find('list')->where(['parent_id IS' => null])->toArray();

        $this->set(compact('category', 'categories'));
        $this->set('_serialize', ['category', 'categories']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Move category up
     *
     * @param int $id Category id
     * @return \Cake\Http\Response|null
     */
    public function moveUp($id)
    {
        $this->request->allowMethod('post');

        $category = $this->Categories->get($id);

        if ($this->Categories->moveUp($category)) {
            $this->Flash->success(__('The category has been moved.'));
        } else {
            $this->Flash->error(__('The category could not be moved. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Move category down
     *
     * @param int $id Category id
     * @return \Cake\Http\Response|null
     */
    public function moveDown($id)
    {
        $this->request->allowMethod('post');

        $category = $this->Categories->get($id);

        if ($this->Categories->moveDown($category)) {
            $this->Flash->success(__('The category has been moved.'));
        } else {
            $this->Flash->error(__('The category could not be moved. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
