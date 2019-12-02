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
