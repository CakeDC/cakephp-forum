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
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var bool $forumUserIsModerator
 */
?>
<?= $this->Form->create($thread) ?>
    <?= $this->Form->control('title') ?>
    <?= $this->Form->control('message', ['class' => 'form-control forum-message-input']) ?>
    <?php if ($forumUserIsModerator): ?>
        <?= $this->Form->control('is_sticky') ?>
        <?= $this->Form->control('is_locked') ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
