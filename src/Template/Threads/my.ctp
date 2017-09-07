<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Thread[] $threads
 */
$this->assign('title', __('My Conversations'));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
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
        <?= $this->element('Threads/row', ['thread' => $thread, 'category' => $thread->category]) ?>
    <?php endforeach; ?>
    </tbody>
</table>
<?= $this->element('Forum/pagination') ?>
