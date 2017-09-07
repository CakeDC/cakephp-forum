<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Moderator $moderator
 */
?>
<tr>
    <td><?= $this->element('Forum/username', ['user' => $moderator->user]) ?></td>
    <td class="actions text-right"><?= $this->Form->postLink('', ['controller' => 'Moderators', 'action' => 'delete', $moderator->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $this->element('Forum/username', ['user' => $moderator->user, 'link' => false])), 'title' => __('Delete'), 'class' => 'btn btn-xs btn-default glyphicon glyphicon-trash']) ?></td>
</tr>
