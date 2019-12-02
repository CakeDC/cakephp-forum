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
 * @var \CakeDC\Forum\Model\Entity\Thread $thread
 * @var \CakeDC\Forum\Model\Entity\Category $category
 */
?>
<p class="forum-discussion"><?= __('Discussion in "{0}" started by {1}, {2}', $this->Html->link($category->title, ['controller' => 'Threads', 'action' => 'index', 'category' => $category->slug]), $this->element('Forum/username', ['user' => $thread->user]), $this->Html->link($thread->created->timeAgoInWords(), ['controller' => 'Threads', 'action' => 'view', 'category' => $category->slug, 'thread' => $thread->slug])) ?></p>
