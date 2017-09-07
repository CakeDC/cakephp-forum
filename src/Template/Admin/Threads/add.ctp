<?php
/**
 * @var \Cake\View\View $this
 */
?>
<h1 class="forum-admin-title"><?= __('Add Thread') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Threads'), ['action' => 'index', '?' => ['category_id' => $this->request->getQuery('category_id')]]) ?></li>
</ul>
<?= $this->element('Admin/Threads/form') ?>
