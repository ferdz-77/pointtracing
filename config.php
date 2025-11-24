<?php
// Configurações de email para Point Tracing
// IMPORTANTE: Configure uma senha de app no seu provedor de email
//
// OPÇÃO 1: Outlook/Hotmail
// 1. Acesse https://account.microsoft.com/security/app-passwords
// 2. Gere uma senha de app
// 3. Substitua '' pela senha gerada abaixo
//
// OPÇÃO 2: Gmail (recomendado - MAIS FÁCIL)
// 1. Acesse https://myaccount.google.com/security
// 2. Ative a VERIFICAÇÃO EM 2 ETAPAS (obrigatório)
// 3. Vá para https://myaccount.google.com/apppasswords
// 4. Selecione "Outro" e digite "Point Tracing"
// 5. COPIE A SENHA DE 16 CARACTERES gerada
// 6. Cole no campo 'password' abaixo
// 7. DESCOMENTE as configurações do Gmail

return [
    'smtp' => [
        // Configurações Gmail (recomendado)
        'host' => 'smtp.gmail.com',
        'username' => 'ferdzagenciadigital@gmail.com',
        'password' => '', // <-- PRECISA GERAR SENHA DE APP NO GMAIL
        'port' => 587,
        'encryption' => 'tls'

        // Configurações Outlook/Hotmail (comentadas)
        /*
        'host' => 'smtp-mail.outlook.com',
        'username' => 'fernandodev@hotmail.com',
        'password' => '', // <-- COLOQUE A SENHA DE APP AQUI
        'port' => 587,
        'encryption' => 'tls'
        */
    ],
    'from' => [
        'email' => 'ferdzagenciadigital@gmail.com',
        'name' => 'Point Tracing'
    ],
    'to' => [
        'email' => 'fernandodev@hotmail.com',
        'name' => 'Fernando'
    ]
];
?>