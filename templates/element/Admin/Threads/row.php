<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)

 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 */
?>
<tr>
    <td>
        <?= $this->Html->link($thread->title, ['action' => 'view', $thread->id]) ?>
        <?php if ($thread->is_reported): ?><?= $this->Html->link(__('Reported'), ['controller' => 'Reports', 'action' => 'index', '?' => ['thread_id' => $thread->id]], ['class' => 'label label-danger']) ?><?php endif; ?>
        <?php if ($thread->is_sticky): ?><span class="label label-primary"><?= __('Sticky') ?></span><?php endif; ?>
        <?php if ($thread->is_locked): ?><span class="label label-warning"><?= __('Locked') ?></span><?php endif; ?>
        <?php if (!$thread->is_visible): ?><span class="label label-default"><?= __('Hidden') ?></span><?php endif; ?>
        <br />
        <small><?= $this->element('Forum/username', ['user' => $thread->user]) ?>, <?= $thread->created->timeAgoInWords() ?></small>
    </td>
    <td><?= $this->Number->format($thread->replies_count) ?></td>
    <td>
        <?php if ($thread->last_reply): ?>
            <?= $this->element('Forum/username', ['user' => $thread->last_reply->user]) ?>, <?= $this->Html->link($thread->last_reply->created->timeAgoInWords(), ['controller' => 'Replies', 'action' => 'view', $thread->last_reply->id]) ?>
        <?php endif; ?>
    </td>
    <td class="actions text-right">
        <?= $this->Html->link('', ['action' => 'view', $thread->id], ['title' => __('View'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-eye-open']) ?>
        <?= $this->Html->link('', ['action' => 'move', $thread->id], ['title' => __('Move'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-arrow-right']) ?>
        <?= $this->Html->link('', ['action' => 'edit', $thread->id], ['title' => __('Edit'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-pencil']) ?>
        <?= $this->Form->postLink('', ['action' => 'delete', $thread->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $thread->title), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-trash']) ?>
    </td>
</tr>
