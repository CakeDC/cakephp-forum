<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Post $post
 * @var \CakeDC\Forum\Model\Entity\Report[] $reports
 */
?>
<div class="panel <?php if (!$post->parent_id): ?>panel-info<?php else: ?>panel-default<?php endif; ?>">
    <div class="panel-heading">
        <?= $this->element('Forum/username', ['user' => $post->user]) ?>, <?= $post->created->timeAgoInWords() ?>
    </div>
    <div class="panel-body">
        <?= $this->element('Forum/message', ['message' => $post->message]) ?>
    </div>
    <div class="panel-footer">
        <?php foreach ($reports as $report): ?>
            <?= $this->element('Reports/row', compact('report', 'post')) ?>
        <?php endforeach; ?>
    </div>
</div>
