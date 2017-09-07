<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 */
?>
<h1 class="forum-admin-title"><?= __('Edit Category') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?></li>
    <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $category->id],
            ['confirm' => __('Are you sure you want to delete "{0}"?', $category->title)]
        )
        ?></li>
</ul>
<?= $this->element('Admin/Categories/form') ?>

