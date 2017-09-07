<?php
/**
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Like[] $likes
 */
?>
<?php if ($likes): ?>
    <br /><em class="small"><?= __('{0} liked this post.', implode(', ', collection($likes)->map(function($like) { return $this->element('Forum/username', ['user' => $like->user]); })->toArray())) ?></em>
<?php endif; ?>
