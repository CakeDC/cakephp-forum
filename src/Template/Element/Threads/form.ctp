<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var bool $forumUserIsModerator
 */
?>
<?= $this->Form->create($thread) ?>
    <?= $this->Form->control('title') ?>
    <?= $this->Form->control('message', ['class' => 'form-control forum-message-input']) ?>
    <?php if ($forumUserIsModerator): ?>
        <?= $this->Form->control('is_sticky') ?>
        <?= $this->Form->control('is_locked') ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
