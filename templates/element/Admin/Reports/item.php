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
 * @var \CakeDC\Forum\Model\Entity\Report $report
 * @var \CakeDC\Forum\Model\Entity\Post $post
 */
?>
<p>
    <?= $this->Form->postLink('', ['action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete # {0}?', $report->id), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default pull-right glyphicon glyphicon-trash']) ?>
    <strong><?= $this->element('Forum/username', ['user' => $post->user]) ?>, <?= $post->created->timeAgoInWords() ?></strong><br />
    <?= nl2br(h($report->message)) ?>
</p>
