<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread[]|\Cake\Collection\CollectionInterface $threads
 * @var array $categories
 */
?>
<h1 class="forum-admin-title"><?= __('Threads') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('New Thread'), ['action' => 'add', '?' => ['category_id' => $this->request->getQuery('category_id')]]); ?></li>
</ul>
<?= $this->element('Admin/Threads/filter') ?>
<table class="table table-hover table-striped table-bordered forum-admin-threads" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th style="width:80px"><?= $this->Paginator->sort('replies_count', __('Replies')) ?></th>
            <th style="width:200px"><?= $this->Paginator->sort('last_reply_created', __('Last Message')) ?></th>
            <th class="actions text-right" style="width:125px"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($threads as $thread): ?>
        <?= $this->element('Admin/Threads/row', compact('thread')) ?>
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
