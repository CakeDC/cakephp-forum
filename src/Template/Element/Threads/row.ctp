<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var bool $forumUserIsModerator
 */

if (!isset($forumUserIsModerator)) {
    $forumUserIsModerator = false;
}

$url = ['controller' => 'Threads', 'action' => 'view', 'category' => $category->slug, 'thread' => $thread->slug];
?>
<tr>
    <td>
        <?php if ($thread->is_reported && $forumUserIsModerator): ?><?= $this->Html->link('', ['controller' => 'Reports', 'action' => 'index', '?' => ['thread_id' => $thread->id]], ['title' => __('Reported'), 'class' => 'glyphicon glyphicon-exclamation-sign']) ?><?php endif; ?>
        <?php if ($thread->is_sticky): ?><span class="glyphicon glyphicon-pushpin" title="<?= __('Sticky') ?>"></span><?php endif; ?>
        <?php if ($thread->is_locked): ?><span class="glyphicon glyphicon-lock" title="<?= __('Locked') ?>"></span><?php endif; ?>
        <?= $this->Html->link($thread->title, $url) ?><br />
        <?= $this->element('Forum/username', ['user' => $thread->user]) ?>, <?= $thread->created->timeAgoInWords() ?>
    </td>
    <td class="text-right">
        <?= $this->Number->format($thread->replies_count) ?>
    </td>
    <td class="text-right">
        <?php if ($thread->last_reply): ?>
            <?= $this->element('Forum/username', ['user' => $thread->last_reply->user, 'link' => $url + ['#' => 'post' . $thread->last_reply->id, '?' => ['page' => 'last']]]) ?><br />
            <?= $thread->last_reply->created->timeAgoInWords() ?>
        <?php endif; ?>
    </td>
</tr>
