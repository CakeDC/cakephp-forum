<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Category[] $categories
 */
?>
<?= $this->Form->create($category) ?>
    <?= $this->Form->control('parent_id', ['options' => $categories, 'escape' => false, 'empty' => true, 'default' => $this->request->getQuery('parent_id')]) ?>
    <?= $this->Form->control('title') ?>
    <?php if (!$category->isNew()): ?>
        <?= $this->Form->control('slug') ?>
    <?php endif; ?>
    <?= $this->Form->control('description') ?>
    <?= $this->Form->control('is_visible', ['default' => true]) ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
