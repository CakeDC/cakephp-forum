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
 * @var \CakeDC\Forum\Model\Entity\Like[] $likes
 */
?>
<?php if ($likes): ?>
    <br /><em class="small"><?= __('{0} liked this post.', implode(', ', collection($likes)->map(function($like) { return $this->element('Forum/username', ['user' => $like->user]); })->toArray())) ?></em>
<?php endif; ?>
