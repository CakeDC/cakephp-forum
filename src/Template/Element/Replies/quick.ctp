<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Reply $reply
 */
?>
<div class="well forum-quick-reply">
    <a name="reply"></a>
    <?= $this->Form->create($reply, ['url' => ['controller' => 'Replies', 'action' => 'add', 'category' => $category->slug, 'thread' => $thread->slug]]) ?>
        <?= $this->Form->control('message', ['class' => 'form-control forum-message-input']) ?>
        <?= $this->Form->button(__('Reply'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
