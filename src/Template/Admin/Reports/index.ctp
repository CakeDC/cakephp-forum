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
 * @var \Cake\ORM\ResultSet $reports
 */

use Cake\Utility\Hash;

$reports = collection($reports->toArray())->groupBy('post_id')->toArray();
?>
<h1 class="forum-admin-title"><?= __('Reports') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('Categories List'), ['controller' => 'Categories', 'action' => 'index']); ?></li>
</ul>
<div class="forum-posts forum-reports">
<?php foreach ($reports as $postId => $postReports): ?>
    <?php
    /** @var \CakeDC\Forum\Model\Entity\Post $post */
    $post = $postReports[0]->post;
    ?>
    <p><?= __('Discussion in "{0}" started by {1}, {2}', $this->Html->link($post->category->title, ['controller' => 'Threads', 'action' => 'index', '?' => ['category_id' => $post->category_id]]), $this->element('Forum/username', ['user' => Hash::get($post, 'thread.user', $post->user)]), $this->Html->link(Hash::get($post, 'thread.created', $post->created)->timeAgoInWords(), ['controller' => 'Threads', 'action' => 'view', Hash::get($post, 'thread.id', $post->id)])) ?></p>
    <div class="panel <?php if (!$post->parent_id): ?>panel-info<?php else: ?>panel-default<?php endif; ?>">
        <div class="panel-heading">
            <?= $this->element('Forum/username', ['user' => $post->user]) ?>, <?= $post->created->timeAgoInWords() ?>
        </div>
        <div class="panel-body">
            <?= $this->element('Forum/message', ['message' => $post->message]) ?>
        </div>
        <div class="panel-footer">
            <?php foreach ($postReports as $report): ?>
                <?= $this->element('Admin/Reports/item', compact('report', 'post')) ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php if (!$reports): ?>
    <p><?= __('No reports found.') ?></p>
<?php endif; ?>
<?= $this->element('Forum/pagination') ?>
