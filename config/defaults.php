<?php
return [
    'userModel' => 'Users',
    'userNameField' => 'full_name',
    'userProfileUrl' => false,
    'userPostsCountField' => false,
    'messageRenderer' => function($message) {
        return nl2br(h($message));
    },
    'adminCheck' => function($user) {
        return (isset($user['is_superuser']) && $user['is_superuser']);
    },
    'threadsPerPage' => 20,
    'postsPerPage' => 20,
];
