<?php
// Configurações de email para Point Tracing
// IMPORTANTE: Configure uma senha de app no Outlook/Hotmail
// Passos:
// 1. Acesse https://account.microsoft.com/security/app-passwords
// 2. Gere uma senha de app
// 3. Substitua '' pela senha gerada abaixo

return [
    'smtp' => [
        'host' => 'smtp-mail.outlook.com',
        'username' => 'fernandodev@hotmail.com',
        'password' => '', // <-- COLOQUE A SENHA DE APP AQUI
        'port' => 587,
        'encryption' => 'tls'
    ],
    'from' => [
        'email' => 'fernandodev@hotmail.com',
        'name' => 'Point Tracing'
    ],
    'to' => [
        'email' => 'fernandodev@hotmail.com',
        'name' => 'Fernando'
    ]
];
?>