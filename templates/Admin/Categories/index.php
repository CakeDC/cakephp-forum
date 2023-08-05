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
 * @var \CakeDC\Forum\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<h1 class="forum-admin-title"><?= __('Categories') ?></h1>
<ul class="nav nav-pills forum-nav-pills">
    <li><?= $this->Html->link(__('New Category'), ['action' => 'add']); ?></li>
    <li><?= $this->Html->link(__('Reports List'), ['controller' => 'Reports', 'action' => 'index']); ?></li>
</ul>
<?php if (count($categories->toArray())): ?>
    <table class="table table-hover table-bordered forum-admin-categories" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= __('Title') ?></th>
                <th style="width:90px"><?= __('Threads') ?></th>
                <th style="width:90px"><?= __('Replies') ?></th>
                <th colspan="2" class="actions text-right"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?= $this->element('Admin/Categories/rows', ['categories' => $categories->toArray()]) ?>
        </tbody>
    </table>
<?php else: ?>
    <p><?= __('No categories found') ?></p>
<?php endif; ?>
