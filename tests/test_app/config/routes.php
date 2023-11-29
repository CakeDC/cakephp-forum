<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $builder): void {
    $builder->scope('/', function (RouteBuilder $routes): void {
        $routes->setExtensions(['json']);

        $routes->connect('/{controller}', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);
        $routes->connect('/{controller}/{action}/*', [], ['routeClass' => 'InflectedRoute']);
    });
};
