<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 */
?>
<h1 class="forum-admin-title"><?= __('Add Category') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?></li>
</ul>
<?= $this->element('Admin/Categories/form') ?>

