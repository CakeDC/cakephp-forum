Configuration
=============

Configuration options
---------------------

The plugin is configured via the Configure class. Check the `vendor/cakedc/cakephp-forum/config/defaults.php`
for a complete list of all the configuration keys and default values.

```php
<?php
return [
    // User model name
    'userModel' => 'Users',
    // Name field in user model to display in forum template
    'userNameField' => 'full_name',
    // User profile url (false, array or callable). Username will be displayed with no link if FALSE
    'userProfileUrl' => false,
    // Posts count field in User model for CounterCache behavior. Not used if FALSE
    'userPostsCountField' => false,
    // Function for messages rendering in forum templates
    'messageRenderer' => function($message) {
        return nl2br(h($message));
    },
    // Field name or callable function to check if user is has access to admin interface
    'adminCheck' => 'is_superuser',
    // Threads limit per page
    'threadsPerPage' => 20,
    // Posts limit per page
    'postsPerPage' => 20,
    'authenticatedUserCallable' => function($controller) {
        return $controller->getRequest()->getAttribute('identity');
    },
];
```

Overriding the default configuration
------------------------------------

You can override default configuration value in your `config/bootstrap.php`, for example:

```
Plugin::load('CakeDC/Forum', ['routes' => true, 'bootstrap' => true]);
Configure::write('Forum.userModel', 'Accounts');
```


Plugin Templates
----------------

To overwrite the template follow the [CakePHP conventions](http://book.cakephp.org/3.0/en/plugins.html#overriding-plugin-templates-from-inside-your-application) and place them to `src/Template/Plugin/CakeDC/Forum/` directory.

You can copy existing template this way:

```bash
cp -r vendor/cakedc/cakephp-forum/src/Template/* src/Template/Plugin/CakeDC/Forum/
```
