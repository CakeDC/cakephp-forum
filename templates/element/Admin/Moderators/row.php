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
 * @var \CakeDC\Forum\Model\Entity\Moderator $moderator
 */
?>
<tr>
    <td><?= $this->element('Forum/username', ['user' => $moderator->user]) ?></td>
    <td class="actions text-right"><?= $this->Form->postLink('', ['controller' => 'Moderators', 'action' => 'delete', $moderator->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $this->element('Forum/username', ['user' => $moderator->user, 'link' => false])), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-trash']) ?></td>
</tr>
