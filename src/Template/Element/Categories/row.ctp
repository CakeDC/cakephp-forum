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
 */
?>
<?php if ($category->children): ?>
    <thead>
        <tr>
            <th colspan="2"><?= h($category->title) ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($category->children as $subCategory): ?>
        <?= $this->element('Categories/row', ['category' => $subCategory]) ?>
    <?php endforeach; ?>
    </tbody>
<?php else: ?>
    <tr>
        <td>
            <?= $this->Html->link($category->title, ['controller' => 'Threads', 'action' => 'index', 'category' => $category->slug]) ?><br />
            <span class="glyphicon glyphicon-comment" title="<?= __('Threads') ?>"></span> <?= $this->Number->format($category->threads_count) ?>
            <span class="glyphicon glyphicon-share-alt" title="<?= __('Replies') ?>"></span> <?= $this->Number->format($category->replies_count) ?>
        </td>
        <td style="width:350px">
            <?php if ($category->last_post): ?>
                <?= __('Latest: {0}', $this->Html->link($this->Text->truncate($category->last_post->title, 40), ['controller' => 'Threads', 'action' => 'view', 'category' => $category->slug, 'thread' => $category->last_post->slug, '#' => 'post' . $category->last_post->id])) ?><br />
                <?= $this->element('Forum/username', ['user' => $category->last_post->user]) ?>, <?= $category->last_post->created->timeAgoInWords() ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endif; ?>
