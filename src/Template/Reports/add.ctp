<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Post $post
 * @var \CakeDC\Forum\Model\Entity\Report $report
 */

$this->assign('title', __('Report post in "{0}"', h($category->title)));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<?= $this->element('Forum/discussion') ?>
<div class="forum-posts">
    <?= $this->element('Posts/item', compact('post') + ['noButtons' => true]) ?>
</div>
<?= $this->element('Reports/form') ?>
