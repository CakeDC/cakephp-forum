<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Category[] $breadcrumbs
 */
if (!isset($breadcrumbs)) {
    $breadcrumbs = [];
}
?>
<ol class="breadcrumb">
    <li><?= $this->Html->link('', '/', ['class' => 'glyphicon glyphicon-home']) ?></li>
    <li><?= $this->Html->link(__('Forum'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
    <?php foreach ($breadcrumbs as $breadcrumb): ?>
        <li><?= $this->Html->link($breadcrumb->title, ['controller' => 'Threads', 'action' => 'index', 'category' => $breadcrumb->slug]) ?></li>
    <?php endforeach; ?>
</ol>
