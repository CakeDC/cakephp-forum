<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Post[] $posts
 */
$this->assign('title', h($thread->title));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<?= $this->element('Forum/discussion') ?>
<?php if (!$thread->is_locked): ?>
    <ul class="nav nav-pills forum-nav-pills">
        <li><?= $this->Html->link(__('Reply'), '#reply') ?></li>
    </ul>
<?php endif; ?>
<?= $this->element('Forum/pagination') ?>
<div class="forum-posts">
    <?php foreach ($posts as $post): ?>
        <?= $this->element('Posts/item', compact('post')) ?>
    <?php endforeach; ?>
</div>
<?= $this->element('Forum/pagination') ?>
<?php if (!$thread->is_locked): ?>
    <?= $this->element('Replies/quick') ?>
<?php endif; ?>
