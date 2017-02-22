<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => 'Admin Panel',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'userRole',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'ruleName' => 'userRole',
        'children' => [
            'dashboard',
        ],
    ],
];
