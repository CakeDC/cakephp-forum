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

Ensure the Users Plugin is loaded in your config/bootstrap.php file

```php
Plugin::load('CakeDC/Forum', ['bootstrap' => true, 'routes' => true]);
```

Now your Forum index pages should be available under `/forum` URL. Admin interface under `/forum/admin`.

Configuration
-------------

Check the [Configuration](Configuration.md) page for more details.
