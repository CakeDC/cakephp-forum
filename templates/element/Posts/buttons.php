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
 *
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Post $post
 * @var array $userInfo
 * @var bool $forumUserIsModerator
 */

$own = ($post->user_id == $userInfo['id']);
$isThread = !$post->parent_id;
$updateUrl = $isThread
    ? ['controller' => 'Threads', 'category' => $category->slug, 'thread' => $thread->slug]
    : ['controller' => 'Replies', 'category' => $category->slug, 'thread' => $thread->slug, 'reply' => (string)$post->id]
?>

<?php if (!isset($noButtons) || !$noButtons): ?>
    <div class="pull-right">
        <?php if (!$post->user_like): ?>
            <?= $this->Form->postLink('', ['controller' => 'Likes', 'action' => 'add', 'category' => $category->slug, 'thread' => $thread->slug, 'post' => (string)$post->id], ['title' => __('Like'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-thumbs-up']) ?>
        <?php endif; ?>
        <?php if (!$thread->is_locked): ?>
            <?= $this->Html->link('', '#reply', ['title' => __('Reply'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-share-alt']) ?>
        <?php endif; ?>
        <?php if (!$post->user_report): ?>
            <?= $this->Html->link('', ['controller' => 'Reports', 'action' => 'add', 'category' => $category->slug, 'thread' => $thread->slug, 'post' => (string)$post->id], ['title' => __('Report'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-exclamation-sign']) ?>
        <?php endif; ?>
        <?php if ($own): ?>
            <?= $this->Html->link('', $updateUrl + ['action' => 'edit'], ['title' => __('Edit'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-pencil']) ?>
        <?php endif; ?>
        <?php if ($isThread && $forumUserIsModerator): ?>
            <?= $this->Html->link('', $updateUrl + ['action' => 'move'], ['title' => __('Move'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-arrow-right']) ?>
        <?php endif; ?>
        <?php if ($own || $forumUserIsModerator): ?>
            <?= $this->Form->postLink('', $updateUrl + ['action' => 'delete'], ['title' => __('Delete'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-trash', 'confirm' => __('Do you really want to delete this post?')]) ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
