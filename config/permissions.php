<?php
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
        'action' => '*'
    ],
];
