<?php
// Configurações de email para Point Tracing
// IMPORTANTE: Configure uma senha de app no seu provedor de email
//
// OPÇÃO 1: Outlook/Hotmail
// 1. Acesse https://account.microsoft.com/security/app-passwords
// 2. Gere uma senha de app
// 3. Substitua '' pela senha gerada abaixo
//
// OPÇÃO 2: Gmail (recomendado se Outlook não funcionar)
// 1. Acesse https://myaccount.google.com/security
// 2. Ative a verificação em 2 etapas
// 3. Vá para https://myaccount.google.com/apppasswords
// 4. Gere senha para "Point Tracing"
// 5. Use as configurações do Gmail abaixo

return [
    'smtp' => [
        // Configurações Outlook/Hotmail
        'host' => 'smtp-mail.outlook.com',
        'username' => 'fernandodev@hotmail.com',
        'password' => '', // <-- COLOQUE A SENHA DE APP AQUI
        'port' => 587,
        'encryption' => 'tls'

        // Se usar Gmail, descomente as linhas abaixo e comente as acima:
        /*
        'host' => 'smtp.gmail.com',
        'username' => 'seuemail@gmail.com',
        'password' => '', // <-- SENHA DE APP DO GMAIL
        'port' => 587,
        'encryption' => 'tls'
        */
    ],
    'from' => [
        'email' => 'fernandodev@hotmail.com',
        'name' => 'Point Tracing'
        // Se usar Gmail: 'email' => 'seuemail@gmail.com'
    ],
    'to' => [
        'email' => 'fernandodev@hotmail.com',
        'name' => 'Fernando'
    ]
];
?>