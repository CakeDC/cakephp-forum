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
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Post $post
 * @var \CakeDC\Forum\Model\Entity\Report $report
 */

$this->assign('title', __('Report post in "{0}"', h($category->title)));
?>
<?= $this->element('Forum/breadcrumbs') ?>
<h1><?= $this->fetch('title') ?></h1>
<?= $this->element('Forum/discussion') ?>
<div class="forum-posts">
    <?= $this->element('Posts/item', compact('post') + ['noButtons' => true]) ?>
</div>
<?= $this->element('Reports/form') ?>
