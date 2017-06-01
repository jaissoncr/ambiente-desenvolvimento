<?php

return [
    'defaults' => [
        'supportsCredentials' => true,
        'allowedOrigins' => ['*'],
        'allowedHeaders' => ['*'],
        'allowedMethods' => ['*'],
        'maxAge' => 3600,
        'hosts' => [
            'http://app.dev',
            'http://localhost:9000',
            'http://mltools.com.br'
        ]
    ],
    'paths' => [],
];
