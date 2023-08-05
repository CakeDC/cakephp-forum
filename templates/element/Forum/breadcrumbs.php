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
