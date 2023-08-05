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
 * @var \CakeDC\Forum\Model\Entity\Category $category
 * @var \CakeDC\Forum\Model\Entity\Category[] $categories
 */
?>
<?= $this->Form->create($category) ?>
    <?= $this->Form->control('parent_id', ['options' => $categories, 'escape' => false, 'empty' => true, 'default' => $this->request->getQuery('parent_id')]) ?>
    <?= $this->Form->control('title') ?>
    <?php if (!$category->isNew()): ?>
        <?= $this->Form->control('slug') ?>
    <?php endif; ?>
    <?= $this->Form->control('description') ?>
    <?= $this->Form->control('is_visible', ['default' => true]) ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
