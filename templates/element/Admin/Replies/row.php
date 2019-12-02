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
 * @var \CakeDC\Forum\Model\Entity\Reply $reply
 */
?>
<tr>
    <td>
        <?php if ($reply->reports_count): ?><?= $this->Html->link(__('Reported'), ['controller' => 'Reports', 'action' => 'index', '?' => ['post_id' => $reply->id]], ['class' => 'label label-danger']) ?><?php endif; ?>
        <strong><?= $this->element('Forum/username', ['user' => $reply->user]) ?>, <?= $reply->created->timeAgoInWords() ?></strong><br />
        <?= $this->element('Forum/message', ['message' => $reply->message]) ?>
        <?= $this->element('Forum/likes', ['likes' => $reply->likes]) ?>
    </td>
    <td class="actions text-right">
        <?= $this->Html->link('', ['controller' => 'Replies', 'action' => 'view', $reply->id], ['title' => __('View'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-eye-open']) ?>
        <?= $this->Html->link('', ['controller' => 'Replies', 'action' => 'edit', $reply->id], ['title' => __('Edit'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-pencil']) ?>
        <?= $this->Form->postLink('', ['controller' => 'Replies', 'action' => 'delete', $reply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-trash']) ?>
    </td>
</tr>
