<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 */
?>
<h1 class="forum-admin-title"><?= h($category->title) ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $category->title)]) ?> </li>
    <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
</ul>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:200px"><?= __('Id') ?></td>
        <td><?= $this->Number->format($category->id) ?></td>
    </tr>
    <?php if ($category->parent_category): ?>
    <tr>
        <td><?= __('Parent') ?></td>
        <td><?= $this->Html->link($category->parent_category->title, ['action' => 'view', $category->parent_category->id]) ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td><?= __('Title') ?></td>
        <td><?= h($category->title) ?></td>
    </tr>
    <tr>
        <td><?= __('Slug') ?></td>
        <td><?= h($category->slug) ?></td>
    </tr>
    <tr>
        <td><?= __('Description') ?></td>
        <td><?= $this->Text->autoParagraph(h($category->description)); ?></td>
    </tr>
    <tr>
        <td><?= __('Threads Count') ?></td>
        <td><?= $this->Number->format($category->threads_count) ?></td>
    </tr>
    <tr>
        <td><?= __('Replies Count') ?></td>
        <td><?= $this->Number->format($category->replies_count) ?></td>
    </tr>
    <tr>
        <td><?= __('Is Visible') ?></td>
        <td><?= $category->is_visible ? __('Yes') : __('No'); ?></td>
    </tr>
    <tr>
        <td><?= __('Created') ?></td>
        <td><?= h($category->created) ?></td>
    </tr>
    <tr>
        <td><?= __('Modified') ?></td>
        <td><?= h($category->modified) ?></td>
    </tr>
</table>

<?php if (!$category->sub_categories): ?>
    <h3><?= __('Moderators') ?></h3>
    <ul class="nav nav-pills forum-nav-pills">
        <li><?= $this->Html->link(__('Add Moderator'), ['controller' => 'Moderators', 'action' => 'add', '?' => ['category_id' => $category->id]]) ?> </li>
    </ul>
    <?php if ($category->moderators): ?>
        <table class="table table-hover table-striped table-bordered forum-admin-replies" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th><?= __('Moderator') ?></th>
                <th class="actions text-right" style="width:100px"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($category->moderators as $moderator): ?>
                <?= $this->element('Admin/Moderators/row', compact('moderator')) ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><?= __('No moderators.') ?></p>
    <?php endif; ?>
<?php endif;?>
