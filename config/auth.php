<?php
 

return [

    'defaults' => [
        'guard' => 'web', // Guard padrão (admin)
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [ // Guard para admin
            'driver' => 'session',
            'provider' => 'users',
        ],

        'cliente' => [ // Guard para cliente
            'driver' => 'session',
            'provider' => 'clientes',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'clientes' => [
            'driver' => 'eloquent',
            'model' => App\Models\Cliente::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'clientes' => [
            'provider' => 'clientes',
            'table' => 'password_reset_tokens', // Utiliza a mesma tabela de reset
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];