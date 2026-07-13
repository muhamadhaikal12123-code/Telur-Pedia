<?php
return [
    'path' => 'admin',
    'auth' => [
        'guard' => 'web',
        'pages' => [
            'login' => \Filament\Http\Livewire\Auth\Login::class,
        ],
    ],
];
