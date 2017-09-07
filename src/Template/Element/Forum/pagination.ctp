<?php
/** @var \Cake\View\View $this */
?>
<?php if ($this->Paginator->total() > 1): ?>
<div class="paginator clearfix">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
</div>
<?php endif; ?>
