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
];
