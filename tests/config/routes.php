<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
return static function (RouteBuilder $builder) {
    $builder->scope('/', function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);

        $routes->connect('/{controller}', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);
        $routes->connect('/{controller}/{action}/*', [], ['routeClass' => 'InflectedRoute']);
        }
    );
};
require ROOT . DS . 'config' . DS . 'routes.php';
