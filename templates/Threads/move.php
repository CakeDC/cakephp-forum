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
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 */
$this->assign('title', __('Move Thread: {0}', h($thread->title)));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<?= $this->Form->create($thread) ?>
    <?= $this->Form->control('category_id', ['label' => __('New Category')]) ?>
    <?= $this->Form->button(__('Move'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
