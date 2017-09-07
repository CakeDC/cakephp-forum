<?php
/**
 * Test suite bootstrap for Forum.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */

// @codingStandardsIgnoreFile

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\DispatcherFactory;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('APP_DIR', 'TestApp');
define('WEBROOT_DIR', 'webroot');

define('TMP', sys_get_temp_dir() . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('SESSIONS', TMP . 'sessions' . DS);

define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('CORE_TESTS', CORE_PATH . 'tests' . DS);
define('CORE_TEST_CASES', CORE_TESTS . 'TestCase');
define('TEST_APP', ROOT . DS . 'tests' . DS);

// Point app constants to the test app.
define('APP', TEST_APP . 'App' . DS);
define('WWW_ROOT', TEST_APP . 'webroot' . DS);
define('CONFIG', TEST_APP . 'config' . DS);

require ROOT . '/vendor/autoload.php';
require_once CORE_PATH . 'config/bootstrap.php';

Configure::write('App', ['namespace' => 'CakeDC\Forum\Test\App']);

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'App',
    'encoding' => 'UTF-8',
    'dir' => 'src',
    'paths' => [
        'plugins' => [dirname(APP) . DS . 'plugins' . DS],
        'templates' => [APP . 'Template' . DS]
    ]
]);

Cache::setConfig([
    'default' => [
        'engine' => 'File'
    ],
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

Configure::write('Session', [
    'defaults' => 'php'
]);

Configure::write('plugins', [
    'Muffin/Slug' => ROOT . DS . 'vendor' . DS . 'muffin' . DS . 'slug',
    'Muffin/Orderly' => ROOT . DS . 'vendor' . DS . 'muffin' . DS . 'orderly',
]);

Plugin::load('CakeDC/Forum', ['path' => ROOT . DS, 'autoload' => true, 'bootstrap' => true]);

DispatcherFactory::add('Routing');
DispatcherFactory::add('ControllerFactory');

class_alias('CakeDC\Forum\Test\App\Controller\AppController', 'App\Controller\AppController');
class_alias('CakeDC\Forum\Test\App\Controller\UsersController', 'App\Controller\UsersController');

// Ensure default test connection is defined
if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', [
    'url' => getenv('db_dsn'),
    'timezone' => 'UTC'
]);
