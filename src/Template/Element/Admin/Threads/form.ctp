<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var array $categories
 */
?>
<?= $this->Form->create($thread) ?>
    <?= $this->Form->control('category_id', ['options' => $categories, 'escape' => false, 'empty' => false, 'default' => $this->request->getQuery('category_id')]) ?>
    <?= $this->Form->control('title') ?>
    <?php if (!$thread->isNew()): ?>
        <?= $this->Form->control('slug') ?>
    <?php endif; ?>
    <?= $this->Form->control('message', ['class' => 'form-control forum-message-input']) ?>
    <?= $this->Form->control('is_sticky') ?>
    <?= $this->Form->control('is_locked') ?>
    <?= $this->Form->control('is_visible', ['default' => true]) ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
