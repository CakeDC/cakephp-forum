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
namespace CakeDC\Forum;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Utility\Hash;
use Muffin\Orderly\OrderlyPlugin;
use Muffin\Slug\SlugPlugin;

/**
 * Plugin for Forum
 */
class ForumPlugin extends BasePlugin
{
    /**
     * @inheritDoc
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $app->addPlugin(SlugPlugin::class);
        $app->addPlugin(OrderlyPlugin::class);

        $this->setupGlobalConfig();
    }

    /**
     * Setup global config for this plugin. Values are set at
     * Forum key using Cake\Core\Configure class
     *
     * @return void
     */
    protected function setupGlobalConfig(): void
    {
        $defaults = [
            // User model name
            'userModel' => 'Users',
            // Name field in user model to display in forum template
            'userNameField' => 'full_name',
            // User profile url (false, array or callable). Username will be displayed with no link if FALSE
            'userProfileUrl' => false,
            // Posts count field in User model for CounterCache behavior. Not used if FALSE
            'userPostsCountField' => false,
            // Function for messages rendering in forum templates
            'messageRenderer' => fn(string $message): string => nl2br(h($message)),
            // Field name or callable function to check if user is has access to admin interface
            'adminCheck' => 'is_superuser',
            // Threads limit per page
            'threadsPerPage' => 20,
            // Posts limit per page
            'postsPerPage' => 20,
        ];
        $config = Hash::merge($defaults, (array)Configure::read('Forum'));
        Configure::write('Forum', $config);
    }
}
