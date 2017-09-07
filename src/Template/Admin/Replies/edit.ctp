<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Reply $reply
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 */
?>
<h1 class="forum-admin-title"><?= __('Edit Reply') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Replies'), ['controller' => 'Threads', 'action' => 'view', $this->request->getQuery('parent_id')]) ?></li>
    <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $reply->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]
        )
        ?></li>
</ul>
<h5><?= __('Thread:') ?> <?= $this->Html->link($thread->title, ['controller' => 'Threads', 'action' => 'view', $thread->id]) ?></h5>
<?= $this->element('Admin/Replies/form') ?>

