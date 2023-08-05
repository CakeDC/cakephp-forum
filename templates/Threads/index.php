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
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Thread[] $threads
 */
$this->assign('title', h($category->title));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('New Thread'), ['controller' => 'Threads', 'action' => 'add', 'category' => $category->slug]) ?></li>
</ul>
<table class="table table-bordered table-striped forum-table forum-category-table">
    <thead>
        <tr>
            <th>
                <?= $this->Paginator->sort('title') ?>
                <span class="pull-right"><?= $this->Paginator->sort('id', __('Start Date')) ?></span>
            </th>
            <th class="text-right"><?= $this->Paginator->sort('replies_count', __('Replies')) ?></th>
            <th class="text-right"><?= $this->Paginator->sort('last_reply_created', __('Last Message')) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($threads as $thread): ?>
            <?= $this->element('Threads/row', compact('thread', 'category')) ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->element('Forum/pagination') ?>
