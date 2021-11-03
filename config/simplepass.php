<?php

return [
    /*
     * Enable or disable SimplePass
     */
    'enabled' => env('SIMPLE_ENABLED', true),

    /*
     * The SimplePass secret. This must be a base 64 encoded, hashed password.
     * Use "artisan simplepass:set" to change the password.
     */
    'secret' => env('SIMPLE_SECRET'),

    /**
     * The expiration of the cookie in minutes.
     */
    'duration' => 120,

    /**
     * Where to redirect the user once logged in.
     */
    'redirect' => '/',

    /**
     * The name of the login view to display if the user is NOT logged in.
     */
    'view' => 'simplepass::login',
];
