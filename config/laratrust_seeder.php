<?php

return [
    'role_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'user' => 'c,r,u,d',
            'profile' => 'c,r,u,d',
            'ministries','c,r,u,d',
            'ministry','c,r,u,d',
            'events','c,r,u,d',
            'event','c,r,u,d',
            'sermons','c,r,u,d',
            'sermon','c,r,u,d',
            'giving','c,r,u,d',
            'gifts','c,r,u,d',
            'settings','c,r,u,d',
            'birthdays','c,r,u,d',
            'messaging','c,r,u,d',
            'templates','c,r,u,d',
            'themes','c,r,u,d',
            'blog','c,r,u,d',
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
