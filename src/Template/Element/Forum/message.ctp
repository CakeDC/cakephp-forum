<?php
/**
 * @var \Cake\View\View $this
 * @var string $message
 */

$messageRenderer = \Cake\Core\Configure::read('Forum.messageRenderer');

echo $messageRenderer($message);
