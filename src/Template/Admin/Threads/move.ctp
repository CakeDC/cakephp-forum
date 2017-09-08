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
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var array $categories
 */
?>
<h1 class="forum-admin-title"><?= __('Move Thread: {0}', h($thread->title)) ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Threads'), ['action' => 'index', '?' => ['category_id' => $this->request->getQuery('category_id')]]) ?></li>
    <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $thread->id],
            ['confirm' => __('Are you sure you want to delete "{0}"?', $thread->title)]
        )
        ?></li>
</ul>
<?= $this->Form->create($thread) ?>
    <?= $this->Form->control('category_id', ['options' => $categories, 'escape' => false, 'empty' => false]) ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
