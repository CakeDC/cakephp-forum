<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Post $post
 * @var \CakeDC\Forum\Model\Entity\Report $report
 */
?>
<p>
    <?= $this->Form->postLink('', ['action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete # {0}?', $report->id), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default pull-right glyphicon glyphicon-trash']) ?>
    <strong><?= $this->element('Forum/username', ['user' => $post->user]) ?>, <?= $post->created->timeAgoInWords() ?></strong><br />
    <?= nl2br(h($report->message)) ?>
</p>
