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
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Category[] $categories
 */
if (!isset($level)) {
    $level = 0;
}
?>
<?php foreach ($categories as $k => $category): ?>
    <tr>
        <td<?php if ($category->children): ?> colspan="3"<?php endif; ?>>
            <?= str_repeat('&nbsp;&nbsp;&nbsp;', $level) ?><?= $this->Html->link($category->title, ['controller' => 'Threads', 'action' => 'index', '?' => ['category_id' => $category->id]]) ?>
            <?php if (!$category->is_visible): ?><span class="label label-default"><?= __('Hidden') ?></span><?php endif; ?>
            <?php if ($category->moderators): ?>
                <br /><?= str_repeat('&nbsp;&nbsp;&nbsp;', $level) ?><small><?= __('Moderators:') ?> <?= implode(', ', collection($category->moderators)->map(function($item) { return $this->element('Forum/username', ['user' => $item->user]); })->toArray()) ?></small>
            <?php endif; ?>
        </td>
        <?php if (!$category->children): ?>
            <td><?= $this->Number->format($category->threads_count) ?></td>
            <td><?= $this->Number->format($category->replies_count) ?></td>
        <?php endif; ?>
        <td class="actions text-right" style="width:70px">
            <?= $this->Form->postLink('', ['action' => 'moveUp', $category->id], ['title' => __('Move up'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-arrow-up', 'disabled' => ($k == 0)]) ?>
            <?= $this->Form->postLink('', ['action' => 'moveDown', $category->id], ['title' => __('Move down'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-arrow-down', 'disabled' => ($k + 1 == count($categories))]) ?>
        </td>
        <td class="actions text-right" style="width:130px">
            <?php if (!$category->parent_id): ?>
                <?= $this->Html->link('', ['action' => 'add', '?' => ['parent_id' => $category->id]], ['title' => __('Add sub category'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-plus']) ?>
            <?php endif; ?>
            <?= $this->Html->link('', ['action' => 'view', $category->id], ['title' => __('View'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-eye-open']) ?>
            <?= $this->Html->link('', ['action' => 'edit', $category->id], ['title' => __('Edit'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-pencil']) ?>
            <?= $this->Form->postLink('', ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $category->title), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-trash']) ?>
        </td>
    </tr>
    <?php if ($category->children): ?>
        <?= $this->element('Admin/Categories/rows', ['categories' => $category->children, 'level' => $level + 1]) ?>
    <?php endif; ?>
<?php endforeach;?>
