<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Moderator $moderator
 * @var array $categories
 */
?>
<h1 class="forum-admin-title"><?= __('Add Moderator') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('List Moderators'), ['controller' => 'Categories', 'action' => 'view', $this->request->getQuery('category_id')]) ?></li>
</ul>
<?= $this->Form->create($moderator) ?>
    <?= $this->Form->control('category_id', ['default' => $this->request->getQuery('category_id')]) ?>
    <?= $this->Form->control('user_id') ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
