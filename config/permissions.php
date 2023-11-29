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
 */
return [
    [
        'prefix' => false,
        'plugin' => 'CakeDC/Forum',
        'controller' => 'Categories',
        'action' => ['index'],
        'bypassAuth' => true,
    ],
    [
        'role' => '*',
        'prefix' => false,
        'plugin' => 'CakeDC/Forum',
        'controller' => 'Likes',
        'action' => ['add'],
    ],
    [
        'role' => '*',
        'prefix' => false,
        'plugin' => 'CakeDC/Forum',
        'controller' => 'Replies',
        'action' => ['add', 'edit', 'delete'],
    ],
    [
        'role' => '*',
        'prefix' => false,
        'plugin' => 'CakeDC/Forum',
        'controller' => 'Replies',
        'action' => ['add', 'edit', 'delete'],
    ],
    [
        'role' => '*',
        'prefix' => false,
        'plugin' => 'CakeDC/Forum',
        'controller' => 'Reports',
        'action' => ['add', 'index', 'delete'],
    ],
    [
        'role' => 'admin',
        'prefix' => 'Admin',
        'plugin' => 'CakeDC/Forum',
        'controller' => '*',
        'action' => '*',
    ],
];
