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

/**
 * Categories Controller
 * @method \Cake\Datasource\Paging\PaginatedInterface<\CakeDC\Forum\Model\Entity\Category> paginate($object = null, array $settings = [])
 * @mixin \Cake\Controller\Controller
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     */
    public function index(): void
    {
        $categories = $this->Categories
            ->find('threaded')
            ->where(['OR' => [
                'Categories.parent_id IS' => null,
                'ParentCategories.is_visible' => true,
            ]])
            ->contain(['LastPosts.Users', 'LastPosts.Threads', 'ParentCategories']);

        $forumUserIsModerator = $this->_forumUserIsModerator();

        $this->set(compact('categories', 'forumUserIsModerator'));
        $this->viewBuilder()->setOption('serialize', ['categories', 'forumUserIsModerator']);
    }
}
