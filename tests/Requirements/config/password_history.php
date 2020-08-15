<?php

use Imanghafoori\PasswordHistoryTests\Requirements\Models\User;

return [
    /**
     * The table name for password histories.
     */
    'table_name' => 'password_histories',

    /**
     * The number of most recent previous passwords to check against when changing/resetting a password
     * false is off which doesn't log password changes or check against them
     */
    'check_depth' => env('PASSWORD_HISTORY_DEPTH', 3),

    /**
     * The models to be observed on the "saved" event
     */
    'models' => [
        User::class => [
            'password_column' => 'password',
            'guard' => 'user',
        ],
    ],
];
