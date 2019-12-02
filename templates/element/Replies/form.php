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
 * @var \CakeDC\Forum\Model\Entity\Reply $reply
 */
?>
<?= $this->Form->create($reply) ?>
    <?= $this->Form->control('message', ['class' => 'form-control forum-message-input']) ?>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
