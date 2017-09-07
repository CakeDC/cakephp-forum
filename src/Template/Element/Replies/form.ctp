<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Reply $reply
 */
?>
<?= $this->Form->create($reply) ?>
    <?= $this->Form->control('message', ['class' => 'form-control forum-message-input']) ?>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
