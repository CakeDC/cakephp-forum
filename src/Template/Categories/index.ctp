<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category[] $categories
 * @var bool $forumUserIsModerator
 */
$this->assign('title', isset($category) ? h($category->title) : __('Forum'));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('My Conversations'), ['controller' => 'Threads', 'action' => 'my']) ?></li>
    <?php if ($forumUserIsModerator): ?>
        <li><?= $this->Html->link(__('Reports'), ['controller' => 'Reports', 'action' => 'index']) ?></li>
    <?php endif; ?>
</ul>
<table class="table table-bordered table-striped forum-table forum-index-table">
    <?php foreach ($categories as $category): ?>
        <?= $this->element('Categories/row', compact('category')) ?>
    <?php endforeach; ?>
</table>
