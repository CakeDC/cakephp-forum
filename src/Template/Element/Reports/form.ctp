<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Report $report
 */
?>
<?= $this->Form->create($report) ?>
    <?= $this->Form->control('message', ['label' => __('Report')]) ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
