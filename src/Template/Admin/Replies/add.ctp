<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Reply $reply
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 */
?>
<h1 class="forum-admin-title"><?= __('Add Reply') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Replies'), ['controller' => 'Threads', 'action' => 'view', $this->request->getQuery('parent_id')]) ?></li>
</ul>
<h5><?= __('Thread:') ?> <?= $this->Html->link($thread->title, ['controller' => 'Threads', 'action' => 'view', $thread->id]) ?></h5>
<?= $this->element('Admin/Replies/form') ?>

