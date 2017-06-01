<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => MLTools\User::class,
        'key' => '',
        'secret' => '',
    ],

    'meli' => [
        'client_id' => env('ML_CLIENT_ID', '4555385080285808'),
        'client_secret' => env('ML_CLIENT_SECRET', 'OuKK3oqpxondXB6VmnOVLTOoL3BXl9dt'),
        'redirect' => env('ML_REDIRECT', 'http://app.dev/login/meli'),
    ],

];
