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
 * Categories Controller
 *
 * @method \CakeDC\Forum\Model\Entity\Category[] paginate($object = null, array $settings = [])
 * @property \CakeDC\Forum\Model\Table\CategoriesTable $Categories
 * @mixin \Cake\Controller\Controller
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     */
    public function index(): void
    {
        $categories = $this->Categories->find('threaded')->contain(['Moderators.Users']);

        $this->set(compact('categories'));
        $this->viewBuilder()->setOption('serialize', ['categories']);
    }

    /**
     * View method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null): void
    {
        $category = $this->Categories->get($id, contain: ['ParentCategories', 'SubCategories', 'Moderators.Users']);

        $this->set('category', $category);
        $this->viewBuilder()->setOption('serialize', 'category');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
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
        $this->viewBuilder()->setOption('serialize', ['category', 'categories']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $category = $this->Categories->get($id);
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
        $this->viewBuilder()->setOption('serialize', ['category', 'categories']);
    }

    /**
     * Delete method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null): ?Response
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
     */
    public function moveUp(string $id = null): ?Response
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
     */
    public function moveDown(string $id = null): ?Response
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
