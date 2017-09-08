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
 * @var \Cake\ORM\Entity $user
 */
use Cake\Core\Configure;
use Cake\Utility\Hash;

if (!isset($link)) {
    $link = Configure::read('Forum.userProfileUrl');
    if (is_array($link)) {
        $link += [$user->id];
    }
}

$username = Hash::get($user, Configure::read('Forum.userNameField'));

if ($link === false) {
    echo h($username);
} else {
    echo $this->Html->link($username, $link);
}
