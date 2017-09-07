<?php
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

        $this->Auth->allow(['index']);
        $this->Auth->deny('*');
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
