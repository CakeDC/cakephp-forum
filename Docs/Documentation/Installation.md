Installation
============

Composer
--------

```bash
composer require cakedc/cakephp-forum
```

Creating Required Tables
------------------------

```bash
bin/cake migrations migrate --plugin=CakeDC/Forum
```

You can also seed the database with some sample data:

```bash
bin/cake migrations seed --seed=EverythingSeed --plugin=CakeDC/Forum
```

Loading the Plugin
------------------

In your Application::bootstrap method ensure the Forum Plugin is loaded and can get user data

```php
//A sample code to work with authentication plugin
Configure::write('Forum.authenticatedUserCallable', function($controller) {
    return $controller->getRequest()->getAttribute('identity');
});
$this->addPlugin('CakeDC/Forum', ['bootstrap' => true, 'routes' => true]);
```

Now your Forum index pages should be available under `/forum` URL. Admin interface under `/forum/admin`.

Authorization
-------------
Authorization checks are optional but can be done easily with the plugins
cakedc/users plugin and cakedc/auth plugin. You can find a sample file with rbac
permissions at [config/permissions.php](../../config/permissions.php).

Configuration
-------------

Check the [Configuration](Configuration.md) page for more details.
