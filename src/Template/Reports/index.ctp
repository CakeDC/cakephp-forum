<?php
/**
 * @var \Cake\View\View $this
 * @var \Cake\ORM\ResultSet $reports
 */

$this->assign('title', __('Reports'));

$reports = collection($reports->toArray())->groupBy('post_id')->toArray();
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<div class="forum-posts forum-reports">
<?php foreach ($reports as $postId => $postReports): ?>
    <?php
    /** @var \CakeDC\Forum\Model\Entity\Post $post */
    $post = $postReports[0]->post;
    ?>
    <?= $this->element('Forum/discussion', ['category' => $post->category, 'thread' => $post->thread ? $post->thread : $post]) ?>
    <?= $this->element('Reports/item', ['post' => $post, 'reports' => $postReports]) ?>
<?php endforeach; ?>
</div>
<?php if (!$reports): ?>
    <p><?= __('No reports found.') ?></p>
<?php endif; ?>
<?= $this->element('Forum/pagination') ?>
