<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Moderator $moderator
 * @var array $categories
 */
?>
<h1 class="forum-admin-title"><?= __('Add Moderator') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Moderators'), ['controller' => 'Categories', 'action' => 'view', $this->request->getQuery('category_id')]) ?></li>
</ul>
<?= $this->Form->create($moderator) ?>
    <?= $this->Form->control('category_id', ['default' => $this->request->getQuery('category_id')]) ?>
    <?= $this->Form->control('user_id') ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
