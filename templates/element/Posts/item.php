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
 * @var array $userInfo
 * @var bool $forumUserIsModerator
 */

?>
<div class="panel <?php if (!$post->parent_id): ?>panel-info<?php else: ?>panel-default<?php endif; ?>">
    <div class="panel-heading">
        <?php if ($forumUserIsModerator && $post->reports_count): ?>
            <?= $this->Html->link('', ['controller' => 'Reports', 'action' => 'index', '?' => ['post_id' => $post->id]], ['title' => __('Reported'), 'class' => 'glyphicon glyphicon-exclamation-sign']) ?>
        <?php endif; ?>
        <?= $this->element('Forum/username', ['user' => $post->user]) ?>, <?= $post->created->timeAgoInWords() ?><a name="post<?= $post->id ?>"></a>
        <?= $this->element('Posts/buttons', compact('post')) ?>
    </div>
    <div class="panel-body" data-content="<?= h($post->message) ?>" data-author="<?= $this->element('Forum/username', ['user' => $post->user, 'link' => false]) ?>">
        <?= $this->element('Forum/message', ['message' => $post->message]) ?>
        <?= $this->element('Forum/likes', ['likes' => $post->likes]) ?>
    </div>
</div>
