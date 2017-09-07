<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Reply[] $replies
 */
?>
<h1 class="forum-admin-title"><?= __('View Thread') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('Edit Thread'), ['action' => 'edit', $thread->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Delete Thread'), ['action' => 'delete', $thread->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $thread->title)]) ?> </li>
    <li><?= $this->Html->link(__('List Threads'), ['action' => 'index', '?' => ['category_id' => $thread->category_id]]) ?> </li>
    <li><?= $this->Html->link(__('New Thread'), ['action' => 'add', '?' => ['category_id' => $thread->category_id]]) ?> </li>
</ul>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:200px"><?= __('Id') ?></td>
        <td><?= $this->Number->format($thread->id) ?></td>
    </tr>
    <tr>
        <td><?= __('User') ?></td>
        <td><?= $this->element('Forum/username', ['user' => $thread->user]) ?></td>
    </tr>
    <tr>
        <td><?= __('Category') ?></td>
        <td><?= $this->Html->link($thread->category->title, ['controller' => 'Categories', 'action' => 'view', $thread->category->id]) ?></td>
    </tr>
    <tr>
        <td><?= __('Title') ?></td>
        <td>
            <?php if ($thread->reports_count): ?><?= $this->Html->link(__('Reported'), ['controller' => 'Reports', 'action' => 'index', '?' => ['post_id' => $thread->id]], ['class' => 'label label-danger']) ?><?php endif; ?>
            <?= h($thread->title) ?>
        </td>
    </tr>
    <tr>
        <td><?= __('Slug') ?></td>
        <td><?= h($thread->slug) ?></td>
    </tr>
    <tr>
        <td><?= __('Message') ?></td>
        <td>
            <?= $this->element('Forum/message', ['message' => $thread->message]) ?>
            <?= $this->element('Forum/likes', ['likes' => $thread->likes]) ?>
        </td>
    </tr>
    <tr>
        <td><?= __('Replies Count') ?></td>
        <td><?= $this->Number->format($thread->replies_count) ?></td>
    </tr>
    <tr>
        <td><?= __('Is Sticky') ?></td>
        <td><?= $thread->is_sticky ? __('Yes') : __('No'); ?></td>
    </tr>
    <tr>
        <td><?= __('Is Locked') ?></td>
        <td><?= $thread->is_locked ? __('Yes') : __('No'); ?></td>
    </tr>
    <tr>
        <td><?= __('Created') ?></td>
        <td><?= h($thread->created) ?></td>
    </tr>
    <tr>
        <td><?= __('Modified') ?></td>
        <td><?= h($thread->modified) ?></td>
    </tr>
</table>

<h3><?= __('Replies') ?></h3>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('New Reply'), ['controller' => 'Replies', 'action' => 'add', '?' => ['parent_id' => $thread->id]]) ?> </li>
</ul>
<?php if ($replies->count()): ?>
    <table class="table table-hover table-striped table-bordered forum-admin-replies" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= __('Reply') ?></th>
                <th class="actions text-right" style="width:100px"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($replies as $reply): ?>
            <?= $this->element('Admin/Replies/row', compact('reply')) ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
<?php else: ?>
    <p><?= __('No replies.') ?></p>
<?php endif; ?>
