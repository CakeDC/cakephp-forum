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
<h1 class="forum-admin-title"><?= __('View Reply') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('Edit Reply'), ['action' => 'edit', $reply->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Delete Reply'), ['action' => 'delete', $reply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]) ?> </li>
    <li><?= $this->Html->link(__('List Replies'), ['controller' => 'Threads', 'action' => 'view', $reply->parent_id]) ?> </li>
    <li><?= $this->Html->link(__('New Reply'), ['action' => 'add', '?' => ['parent_id' => $reply->parent_id]]) ?> </li>
</ul>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:200px"><?= __('Id') ?></td>
        <td><?= $this->Number->format($reply->id) ?></td>
    </tr>
    <tr>
        <td><?= __('User') ?></td>
        <td><?= $this->element('Forum/username', ['user' => $reply->user]) ?></td>
    </tr>
    <tr>
        <td><?= __('Thread') ?></td>
        <td><?= $this->Html->link($reply->thread->title, ['action' => 'view', $reply->thread->id]) ?></td>
    </tr>
    <tr>
        <td><?= __('Message') ?></td>
        <td><?= $this->element('Forum/message', ['message' => $reply->message]) ?></td>
    </tr>
    <tr>
        <td><?= __('Created') ?></td>
        <td><?= h($reply->created) ?></td>
    </tr>
    <tr>
        <td><?= __('Modified') ?></td>
        <td><?= h($reply->modified) ?></td>
    </tr>
</table>
