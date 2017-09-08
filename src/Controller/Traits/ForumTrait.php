<?php

namespace CakeDC\Forum\Controller\Traits;

use Cake\ORM\Query;

/**
 * ForumTrait
 *
 * @property \CakeDC\Forum\Model\Table\CategoriesTable $Categories
 * @property \CakeDC\Forum\Model\Table\ThreadsTable $Threads
 * @property \CakeDC\Forum\Model\Table\RepliesTable $Replies
 * @property \CakeDC\Forum\Model\Table\PostsTable $Posts
 * @property \CakeDC\Forum\Model\Table\ModeratorsTable $Moderators
 * @mixin \Cake\Controller\Controller
 */
trait ForumTrait
{
    /**
     * Check if current user is moderator
     *
     * @param null $categoryId Category id
     * @return bool
     */
    protected function _forumUserIsModerator($categoryId = null)
    {
        $this->loadModel('CakeDC/Forum.Moderators');

        $userCategories = $this->Moderators->getUserCategories($this->Auth->user('id'));

        if (!$categoryId) {
            return !empty($userCategories);
        }

        return in_array($categoryId, $userCategories);
    }

    /**
     * Get category by slug
     *
     * @param string $slug Category slug
     * @return \CakeDC\Forum\Model\Entity\Category
     */
    protected function _getCategory($slug)
    {
        /** @var \CakeDC\Forum\Model\Entity\Category $category */
        $category = $this->Categories->find('slugged', compact('slug'))->firstOrFail();
        $category->set('children', $this->Categories->find('children', compact('category'))->toArray());

        $this->set(compact('category'));

        $this->_getBreadcrumbs($category->id);

        return $category;
    }

    /**
     * Get breadcrumbs
     *
     * @param int $categoryId Category id
     * @return \CakeDC\Forum\Model\Entity\Category[]
     */
    protected function _getBreadcrumbs($categoryId)
    {
        $breadcrumbs = $this->Categories->find('path', ['for' => $categoryId])->toArray();
        $forumUserIsModerator = $this->_forumUserIsModerator($categoryId);

        $this->set(compact('breadcrumbs', 'forumUserIsModerator'));

        return $breadcrumbs;
    }

    /**
     * Get thread by category slug and thread slug
     *
     * @param string $categorySlug Category slug
     * @param string $slug Slug
     * @return \CakeDC\Forum\Model\Entity\Thread
     */
    protected function _getThread($categorySlug, $slug)
    {
        /** @var \CakeDC\Forum\Model\Entity\Thread $thread */
        $thread = $this->Threads
            ->find()
            ->contain([
                'Users',
                'Categories' => function (Query $query) use ($categorySlug) {
                    return $query->find('slugged', ['slug' => $categorySlug]);
                },
                'Categories.SubCategories'
            ])
            ->find('slugged', compact('slug'))
            ->firstOrFail();

        $category = $thread->category;

        $this->_getBreadcrumbs($thread->category_id);

        $this->set(compact('thread', 'category'));

        return $thread;
    }

    /**
     * Get reply by category slug, thread slug and reply id
     *
     * @param string $categorySlug Category slug
     * @param string $threadSlug Thread slug
     * @param int $id Reply id
     * @return \CakeDC\Forum\Model\Entity\Reply
     */
    protected function _getReply($categorySlug, $threadSlug, $id)
    {
        /** @var \CakeDC\Forum\Model\Entity\Reply $reply */
        $reply = $this->Replies->get($id, ['finder' => 'byThreadAndCategory'] + compact('categorySlug', 'threadSlug'));

        $category = $reply->category;
        $thread = $reply->thread;

        $this->_getBreadcrumbs($reply->category_id);

        $this->set(compact('thread', 'category', 'reply'));

        return $reply;
    }

    /**
     * Get post by category slug, thread slug and post id
     *
     * @param string $categorySlug Category slug
     * @param string $threadSlug Thread slug
     * @param int $id Post id
     * @return \CakeDC\Forum\Model\Entity\Reply
     */
    protected function _getPost($categorySlug, $threadSlug, $id)
    {
        $thread = $this->_getThread($categorySlug, $threadSlug);
        $post = $this->Posts->get($id, ['finder' => 'byThread', 'thread_id' => $thread->id]);

        $this->set(compact('post'));

        return $post;
    }
}
