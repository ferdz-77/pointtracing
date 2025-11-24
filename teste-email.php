<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

$config = require 'config.php';

echo "<h1>Teste de Envio de Email - Point Tracing</h1>";
echo "<pre>";

if (empty($config['smtp']['password'])) {
    echo "❌ ERRO: Senha de email não configurada!\n";
    echo "Configure a senha de app no arquivo config.php\n\n";
    echo "Para Outlook/Hotmail:\n";
    echo "1. Acesse: https://account.microsoft.com/security/app-passwords\n";
    echo "2. Gere uma senha de app\n";
    echo "3. Cole no campo 'password' do config.php\n\n";
    echo "Para Gmail:\n";
    echo "1. Ative verificação 2 etapas\n";
    echo "2. Acesse: https://myaccount.google.com/apppasswords\n";
    echo "3. Gere senha para 'Point Tracing'\n";
    echo "4. Descomente as configurações do Gmail no config.php\n";
    exit;
}

$mail = new PHPMailer(true);

try {
    echo "🔄 Configurando servidor SMTP...\n";

    $mail->isSMTP();
    $mail->Host = $config['smtp']['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp']['username'];
    $mail->Password = $config['smtp']['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $config['smtp']['port'];

    $mail->SMTPDebug = 2; // Debug detalhado
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    echo "✅ Servidor configurado\n";

    $mail->setFrom($config['from']['email'], $config['from']['name']);
    $mail->addAddress($config['to']['email'], $config['to']['name']);

    $mail->isHTML(true);
    $mail->Subject = 'Teste - Point Tracing Email System';
    $mail->Body = '<h2>🎯 Teste de Email</h2><p>Este é um teste do sistema de email da Point Tracing.</p><p>Data: ' . date('d/m/Y H:i:s') . '</p>';
    $mail->AltBody = 'Teste de Email - Point Tracing - ' . date('d/m/Y H:i:s');

    echo "📧 Enviando email...\n";
    $mail->send();

    echo "✅ EMAIL ENVIADO COM SUCESSO!\n";
    echo "Verifique sua caixa de entrada: " . $config['to']['email'] . "\n";

} catch (Exception $e) {
    echo "❌ ERRO AO ENVIAR EMAIL:\n";
    echo "Mensagem: " . $e->getMessage() . "\n\n";

    echo "🔧 POSSÍVEIS SOLUÇÕES:\n";
    echo "1. Verifique se a senha de app está correta\n";
    echo "2. Confirme se a conta de email existe\n";
    echo "3. Tente usar Gmail ao invés do Outlook\n";
    echo "4. Verifique se o firewall não está bloqueando\n";
    echo "5. Para Gmail: ative 'Acesso a app menos seguro' ou use senha de app\n";
}

echo "</pre>";
?>