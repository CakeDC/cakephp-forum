<?php
/**
 * @var \Cake\View\View $this
 * @var array $categories
 */
?>
<?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'style' => 'margin-bottom:15px']) ?>
    <?= $this->Form->control('category_id', ['label' => false, 'empty' => __('[Category]'), 'options' => $categories, 'default' => $this->request->getQuery('category_id')]) ?>
    <?= $this->Form->control('is_sticky', ['label' => false, 'empty' => __('[Is Sticky]'), 'options' => [1 => __('Yes'), 2 => __('No')], 'default' => $this->request->getQuery('is_sticky')]) ?>
    <?= $this->Form->control('is_locked', ['label' => false, 'empty' => __('[Is Locked]'), 'options' => [1 => __('Yes'), 2 => __('No')], 'default' => $this->request->getQuery('is_locked')]) ?>
    <?= $this->Form->control('is_visible', ['label' => false, 'empty' => __('[Is Visible]'), 'options' => [1 => __('Yes'), 2 => __('No')], 'default' => $this->request->getQuery('is_visible')]) ?>
    <?= $this->Form->button(__('Filter')) ?>
<?= $this->Form->end() ?>
