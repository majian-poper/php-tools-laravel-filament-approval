<?php

return [
    'models' => [
        'approval_flow' => \PHPTools\Approval\Models\ApprovalFlow::class,
        'approval_flow_step' => \PHPTools\Approval\Models\ApprovalFlowStep::class,
        'approval_task' => \PHPTools\Approval\Models\ApprovalTask::class,
        'approval' => \PHPTools\Approval\Models\Approval::class,
    ],

    'approvable_models' => [
        // \App\Models\User::class => 'User',
    ],

    'approver_models' => [
        \App\Models\AccountManagement\Role::class => 'Role',
        \App\Models\AccountManagement\Account::class => 'Account',
    ],

    'expiration_days' => [1, 2, 3, 4, 5, 6, 7],

    'navigation_sort' => [
        'approval_flow' => 1,
        'approval_task' => 2,
    ],

    'navigation_icon' => [
        'approval_flow' => 'heroicon-o-rectangle-stack',
        'approval_task' => 'heroicon-o-rectangle-stack',
    ],
];
