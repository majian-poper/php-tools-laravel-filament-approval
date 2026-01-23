<?php

return [
    'approvable_models' => [
        // \App\Models\Post::class => 'Post',
    ],

    'approver_models' => [
        \App\Models\AccountManagement\Role::class => 'Role',
        \App\Models\AccountManagement\Account::class => 'Account',
    ],

    'expiration_days' => [1, 2, 3, 4, 5, 6, 7],

    'navigation_icon' => [
        'approval_flow' => 'heroicon-o-rectangle-stack',
        'approval_task' => 'heroicon-o-rectangle-stack',
    ],
];
