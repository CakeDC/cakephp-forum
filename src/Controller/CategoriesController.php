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

/**
 * Categories Controller
 *
 *
 * @method \CakeDC\Forum\Model\Entity\Category[] paginate($object = null, array $settings = [])
 * @mixin \Cake\Controller\Controller
 */
class CategoriesController extends AppController
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

//        $this->Auth->deny();
//        $this->Auth->allow(['index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
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
        $this->set('_serialize', ['categories', 'forumUserIsModerator']);
    }
}
