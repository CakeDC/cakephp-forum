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
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $builder): void {
    $builder->plugin(
        'CakeDC/Forum',
        ['path' => '/forum'],
        function (RouteBuilder $routes): void {
            $routes->prefix('admin', function (RouteBuilder $routes): void {
                $routes->fallbacks(DashedRoute::class);
            });

            $routes->connect(
                '/',
                ['controller' => 'Categories', 'action' => 'index']
            );
            $routes->connect(
                '/admin',
                ['controller' => 'Categories', 'action' => 'index', 'prefix' => 'Admin']
            );
            $routes->connect(
                '/reports',
                ['controller' => 'Reports', 'action' => 'index'],
                ['routeClass' => 'InflectedRoute']
            );
            $routes->connect(
                '/reports/{action}/*',
                ['controller' => 'Reports'],
                ['routeClass' => 'InflectedRoute']
            );
            $routes->connect(
                '/my-conversations',
                ['controller' => 'Threads', 'action' => 'my']
            );
            $routes->connect(
                '/{category}/new-thread',
                ['controller' => 'Threads', 'action' => 'add'],
                ['pass' => ['category']]
            );
            $routes->connect(
                '/{category}/{thread}/edit',
                ['controller' => 'Threads', 'action' => 'edit'],
                ['pass' => ['category', 'thread']]
            );
            $routes->connect(
                '/{category}/{thread}/delete',
                ['controller' => 'Threads', 'action' => 'delete'],
                ['pass' => ['category', 'thread']]
            );
            $routes->connect(
                '/{category}/{thread}/move',
                ['controller' => 'Threads', 'action' => 'move'],
                ['pass' => ['category', 'thread']]
            );
            $routes->connect(
                '/{category}/{thread}/reply',
                ['controller' => 'Replies', 'action' => 'add'],
                ['pass' => ['category', 'thread']]
            );
            $routes->connect(
                '/{category}/{thread}/{reply}',
                ['controller' => 'Replies', 'action' => 'edit'],
                ['pass' => ['category', 'thread', 'reply'], 'reply' => '\d+']
            );
            $routes->connect(
                '/{category}/{thread}/{reply}/edit',
                ['controller' => 'Replies', 'action' => 'edit'],
                ['pass' => ['category', 'thread', 'reply'], 'reply' => '\d+']
            );
            $routes->connect(
                '/{category}/{thread}/{reply}/delete',
                ['controller' => 'Replies', 'action' => 'delete'],
                ['pass' => ['category', 'thread', 'reply'], 'reply' => '\d+']
            );
            $routes->connect(
                '/{category}/{thread}/{post}/report',
                ['controller' => 'Reports', 'action' => 'add'],
                ['pass' => ['category', 'thread', 'post'], 'post' => '\d+']
            );
            $routes->connect(
                '/{category}/{thread}/{post}/like',
                ['controller' => 'Likes', 'action' => 'add'],
                ['pass' => ['category', 'thread', 'post'], 'post' => '\d+']
            );
            $routes->connect(
                '/{category}/{thread}',
                ['controller' => 'Threads', 'action' => 'view'],
                ['pass' => ['category', 'thread']]
            );
            $routes->connect(
                '/{category}',
                ['controller' => 'Threads', 'action' => 'index'],
                ['pass' => ['category']]
            );

            $routes->fallbacks(DashedRoute::class);
        }
    );
};
