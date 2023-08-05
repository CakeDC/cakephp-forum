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
namespace CakeDC\Forum\Controller\Traits;

use Cake\Core\Configure;
use Cake\ORM\Query\SelectQuery;
use Cake\Utility\Hash;
use CakeDC\Forum\Model\Entity\Category;
use CakeDC\Forum\Model\Entity\Post;
use CakeDC\Forum\Model\Entity\Reply;
use CakeDC\Forum\Model\Entity\Thread;
use UnexpectedValueException;

/**
 * ForumTrait
 *
 * @property \CakeDC\Forum\Model\Table\CategoriesTable $Categories
 * @property \CakeDC\Forum\Model\Table\ThreadsTable $Threads
 * @property \CakeDC\Forum\Model\Table\RepliesTable $Replies
 * @property \CakeDC\Forum\Model\Table\PostsTable $Posts
 * @property \CakeDC\Forum\Model\Table\ModeratorsTable $Moderators
 * @mixin \CakeDC\Forum\Controller\AppController
 * @mixin \Cake\Controller\Controller
 */
trait ForumTrait
{
    /**
     * Get the authenticated user id. See _getAuthenticatedUser
     *
     * @return mixed
     */
    protected function _getAuthenticatedUserId(): mixed
    {
        return $this->_getAuthenticatedUser()['id'] ?? null;
    }

    /**
     * Get the authenticated user. Try to use config Forum.authenticatedUserCallable to
     * when $this->loadedAuthenticatedUser is false.
     *
     * @return array|\ArrayAccess|null
     */
    protected function _getAuthenticatedUser(): \ArrayAccess|array|null
    {
        if ($this->loadedAuthenticatedUser) {
            return $this->authenticatedUser;
        }
        $callable = Configure::read('Forum.authenticatedUserCallable');
        if (!is_callable($callable)) {
            throw new UnexpectedValueException(
                __('Config key "Forum.authenticatedUserCallable" must be a valid callable')
            );
        }
        $this->authenticatedUser = $callable($this);
        $this->loadedAuthenticatedUser = true;

        return $this->authenticatedUser;
    }

    /**
     * Check if current user is admin
     *
     * @return bool
     */
    protected function _forumUserIsAdmin(): bool
    {
        $user = $this->_getAuthenticatedUser();
        if (!$user) {
            return false;
        }
        $adminCheck = Configure::read('Forum.adminCheck');
        if (!$adminCheck) {
            return false;
        }

        if (is_string($adminCheck) && !Hash::get($user, $adminCheck)) {
            return false;
        } elseif (is_callable($adminCheck) && !$adminCheck($user)) {
            return false;
        }

        return true;
    }

    /**
     * Check if current user is moderator
     *
     * @param int|null $categoryId Category id
     * @return bool
     */
    protected function _forumUserIsModerator($categoryId = null): bool
    {
        if ($this->_forumUserIsAdmin()) {
            return true;
        }

        $this->Moderators = $this->fetchTable('CakeDC/Forum.Moderators');

        $userCategories = $this->Moderators->getUserCategories(
            $this->_getAuthenticatedUser()['id']
        );

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
    protected function _getCategory(string $slug): Category
    {
        /** @var \CakeDC\Forum\Model\Entity\Category $category */
        $category = $this->Categories->find('slugged', ['slug' => $slug])->firstOrFail();
        $category->set('children', $this->Categories->find('children', ['category' => $category])->toArray());

        $this->set(['category' => $category]);

        $this->_getBreadcrumbs($category->id);

        return $category;
    }

    /**
     * Get breadcrumbs
     *
     * @param int $categoryId Category id
     * @return \CakeDC\Forum\Model\Entity\Category[]
     */
    protected function _getBreadcrumbs($categoryId): array
    {
        $breadcrumbs = $this->Categories->find('path', ['for' => $categoryId])->toArray();
        $forumUserIsModerator = $this->_forumUserIsModerator($categoryId);

        $this->set(['breadcrumbs' => $breadcrumbs, 'forumUserIsModerator' => $forumUserIsModerator]);

        return $breadcrumbs;
    }

    /**
     * Get thread by category slug and thread slug
     *
     * @param string $categorySlug Category slug
     * @param string $slug Slug
     * @return \CakeDC\Forum\Model\Entity\Thread
     */
    protected function _getThread($categorySlug, $slug): Thread
    {
        /** @var \CakeDC\Forum\Model\Entity\Thread $thread */
        $thread = $this->Threads
            ->find()
            ->contain([
                'Users',
                'Categories' => fn(SelectQuery $query): SelectQuery => $query
                    ->find('slugged', ['slug' => $categorySlug]),
                'Categories.SubCategories',
            ])
            ->find('slugged', ['slug' => $slug])
            ->firstOrFail();

        $category = $thread->category;

        $this->_getBreadcrumbs($thread->category_id);

        $this->set(['thread' => $thread, 'category' => $category]);

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
    protected function _getReply($categorySlug, $threadSlug, $id): Reply
    {
        $reply = $this->Replies->get($id, ['finder' => 'byThreadAndCategory'] + ['categorySlug' => $categorySlug, 'threadSlug' => $threadSlug]);

        $category = $reply->category;
        $thread = $reply->thread;

        $this->_getBreadcrumbs($reply->category_id);

        $this->set(['thread' => $thread, 'category' => $category, 'reply' => $reply]);

        return $reply;
    }

    /**
     * Get post by category slug, thread slug and post id
     *
     * @param string $categorySlug Category slug
     * @param string $threadSlug Thread slug
     * @param int $id Post id
     * @return \CakeDC\Forum\Model\Entity\Post
     */
    protected function _getPost($categorySlug, $threadSlug, $id): Post
    {
        $thread = $this->_getThread($categorySlug, $threadSlug);
        $post = $this->Posts->get($id, ['finder' => 'byThread', 'thread_id' => $thread->id]);

        $this->set(['post' => $post]);

        return $post;
    }
}
