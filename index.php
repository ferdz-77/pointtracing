<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

$config = require 'config.php';

// Processar formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $telefone = htmlspecialchars($_POST['telefone'] ?? '');
    $profissao = htmlspecialchars($_POST['profissao'] ?? '');
    $dispositivo = htmlspecialchars($_POST['dispositivo'] ?? '');

    // Validar campos obrigatórios
    if (empty($nome) || empty($email) || empty($telefone)) {
        $mensagem = "Por favor, preencha todos os campos obrigatórios.";
        $tipo_mensagem = "erro";
    } elseif (empty($config['smtp']['password'])) {
        $mensagem = "Erro: Senha de email não configurada. Configure a senha de app no arquivo config.php";
        $tipo_mensagem = "erro";
    } else {
        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor
            $mail->isSMTP();
            $mail->Host = $config['smtp']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['smtp']['username'];
            $mail->Password = $config['smtp']['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['smtp']['port'];

            // Configurações adicionais para compatibilidade
            $mail->SMTPDebug = 0; // Mude para 2 para debug detalhado
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Configurações do email
            $mail->setFrom($config['from']['email'], $config['from']['name']);
            $mail->addAddress($config['to']['email'], $config['to']['name']);

            // Conteúdo do email
            $mail->isHTML(true);
            $mail->Subject = 'Nova inscrição no Beta - Point Tracing';

            $mail->Body = "
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
                    .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    h2 { color: #00eaff; border-bottom: 2px solid #00eaff; padding-bottom: 10px; }
                    .info { margin: 15px 0; padding: 10px; background: #f9f9f9; border-left: 4px solid #00eaff; }
                    .label { font-weight: bold; color: #333; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>🎯 Nova Inscrição no Beta - Point Tracing</h2>

                    <div class='info'>
                        <span class='label'>Nome:</span> {$nome}
                    </div>

                    <div class='info'>
                        <span class='label'>E-mail:</span> {$email}
                    </div>

                    <div class='info'>
                        <span class='label'>Telefone:</span> {$telefone}
                    </div>

                    <div class='info'>
                        <span class='label'>Profissão:</span> {$profissao}
                    </div>

                    <div class='info'>
                        <span class='label'>Dispositivo:</span> {$dispositivo}
                    </div>

                    <p><strong>Data da inscrição:</strong> " . date('d/m/Y H:i:s') . "</p>
                </div>
            </body>
            </html>
            ";

            $mail->AltBody = "Nova inscrição no Beta - Point Tracing\n\nNome: {$nome}\nE-mail: {$email}\nTelefone: {$telefone}\nProfissão: {$profissao}\nDispositivo: {$dispositivo}\nData: " . date('d/m/Y H:i:s');

            $mail->send();
            $mensagem = "Inscrição enviada com sucesso! Entraremos em contato em breve.";
            $tipo_mensagem = "sucesso";

        } catch (Exception $e) {
            $mensagem = "Erro ao enviar inscrição: " . $e->getMessage() . ". Tente novamente mais tarde.";
            $tipo_mensagem = "erro";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Point Tracing - Construção Civil</title>

<style>
    :root {
        --font-weight-bold: 700;
        --font-weight-semibold: 600;
        --font-size-lg: 18px;
        --space-24: 24px;
        --pt-cyan-neon: #32dfff;
        --pt-cyan-dark: #00c8ff;
        --pt-cyan-glow: #00eaff;
        --pt-dark-bg: #001623;
        --line-height-tight: 1.1;
        --radius-full: 40px;
        --ease-standard: cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes buttonGlow {
        0%, 100% {
            box-shadow: 0 0 15px rgba(0, 217, 255, 0.3), 0 4px 15px rgba(0, 217, 255, 0.2);
        }
        50% {
            box-shadow: 0 0 20px rgba(0, 217, 255, 0.5), 0 6px 20px rgba(0, 217, 255, 0.3);
        }
    }

    .btn {
        display: inline-block;
        padding: 16px 48px;
        font-size: var(--font-size-lg);
        font-weight: var(--font-weight-semibold);
        border: none;
        border-radius: var(--radius-full);
        cursor: pointer;
        transition: all 0.3s var(--ease-standard);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--pt-cyan-neon), var(--pt-cyan-dark));
        color: var(--pt-dark-bg);
        font-weight: var(--font-weight-bold);
        animation: buttonGlow 2s ease-in-out infinite;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 20px var(--pt-cyan-glow), 0 8px 25px rgba(0, 217, 255, 0.4);
    }

    body {
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #001225 0%, #002a4a 50%, #003d66 100%);
        font-family: "FKGroteskNeue", "Geist", "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        overflow-x: hidden;
        color: #fff;
        min-height: 100vh;
    }

    /* Efeito de brilho sutil */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: radial-gradient(circle at 30% 20%, rgba(0, 200, 255, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(0, 107, 142, 0.06) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
    }

    /* Section Hero */
    .hero {
        position: relative;
        z-index: 2;
        padding: 120px 20px;
        text-align: center;
    }

    .hero-icon {
        width: 250px;
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 0 15px #00eaff);
    }

    .logos-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        margin-bottom: 30px;
    }

    .uplab-section {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin: 20px auto 40px;
        max-width: 800px;
    }

    .uplab-logo {
        width: 120px;
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 0 10px #00eaff);
        opacity: 0.9;
    }

    .uplab-text {
        font-size: 18px;
        color: #b8d8f0;
        line-height: 1.5;
        font-weight: 500;
        margin: 0;
        flex: 1;
    }

    .hero-title {
        font-size: clamp(36px, 6vw, 72px);
        font-weight: var(--font-weight-bold);
        margin-bottom: var(--space-24);
        color: var(--pt-cyan-neon);
        line-height: var(--line-height-tight);
        text-shadow: 0 0 20px var(--pt-cyan-glow), 0 0 40px var(--pt-cyan-glow), 0 0 60px var(--pt-cyan-glow);
        animation: shimmer 3s ease-in-out infinite;
        max-width: 900px;
        margin: 0 auto var(--space-24);
    }

    .hero-subtitle {
        font-size: 24px;
        color: #d8e8f0;
        max-width: 600px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    /* Botão removido - usando classes .btn e .btn-primary */

    @media (max-width: 768px) {
        .hero-title { font-size: 38px; }
        .hero-subtitle { font-size: 16px; }
        .hero-icon { width: 180px; }
        .uplab-logo { width: 100px; }
        .uplab-text { font-size: 16px; }
        .logos-container { flex-direction: column; gap: 20px; }
        .uplab-section { flex-direction: column; gap: 15px; text-align: center; }
    }

    /* Seção de Benefícios */
    .benefits {
        margin: 60px auto;
        max-width: 1200px;
        padding: 0 20px;
    }

    .benefits-title {
        font-size: 32px;
        color: var(--pt-cyan-neon);
        text-align: center;
        margin-bottom: 50px;
        font-weight: var(--font-weight-bold);
        text-shadow: 0 0 15px var(--pt-cyan-glow);
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        margin-top: 40px;
    }

    .benefit-item {
        background: rgba(0, 10, 25, 0.6);
        border: 1px solid rgba(0, 255, 255, 0.2);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .benefit-item:hover {
        transform: translateY(-5px);
        border-color: var(--pt-cyan-neon);
        box-shadow: 0 10px 30px rgba(0, 217, 255, 0.2);
    }

    .benefit-icon {
        font-size: 48px;
        margin-bottom: 20px;
        display: block;
    }

    .benefit-item h3 {
        color: var(--pt-cyan-neon);
        font-size: 24px;
        margin-bottom: 15px;
        font-weight: var(--font-weight-semibold);
    }

    .benefit-item p {
        color: #d8e8f0;
        line-height: 1.6;
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .benefits {
            margin: 40px auto;
            padding: 0 15px;
        }

        .benefits-title {
            font-size: 28px;
            margin-bottom: 30px;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .benefit-item {
            padding: 20px;
        }

        .benefit-icon {
            font-size: 40px;
        }

        .benefit-item h3 {
            font-size: 20px;
        }
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: #031727;
        background-image: radial-gradient(circle at 70% 50%, rgba(0,255,255,0.18), transparent 30%),
                          url('data:image/svg+xml,\
                          <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">\
                              <rect width="120" height="120" fill="none" stroke="%23055" stroke-width="0.5"/>\
                          </svg>');
        background-size: cover;
        margin: 8% auto;
        padding: 0;
        border: 1px solid #0ff;
        border-radius: 14px;
        width: 85%;
        max-width: 700px;
        box-shadow: 0 0 50px rgba(0,255,255,0.4);
        animation: modalFadeIn 0.3s ease-out;
        position: relative;
        color: #c8e9ff;
        font-family: "FKGroteskNeue", "Geist", "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        margin: 10px;
        cursor: pointer;
        transition: 0.2s;
    }

    .close:hover,
    .close:focus {
        color: #00eaff;
        text-decoration: none;
    }

    .modal h1 {
        text-align: center;
        margin-top: 20px;
        font-size: 36px;
        color: #26e5ff;
        text-shadow: 0 0 18px #00eaff;
        font-weight: 700;
    }

    .form-container {
        max-width: 700px;
        margin: 20px auto;
        padding: 30px;
        background: rgba(0, 10, 25, 0.7);
        border-radius: 14px;
        border: 1px solid #0ff;
        box-shadow: 0 0 25px rgba(0,255,255,0.4);
    }

    .form-container label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        color: #9fdfff;
    }

    .form-container input,
    .form-container select {
        width: 100%;
        padding: 16px;
        border-radius: 8px;
        background: rgba(255,255,255,0.08);
        border: 1px solid #1c2d3b;
        color: #c8e9ff;
        font-size: 16px;
        margin-bottom: 25px;
        outline: none;
        transition: 0.2s;
        box-sizing: border-box;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%239fdfff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6,9 12,15 18,9"></polyline></svg>');
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        padding-right: 48px;
    }

    .form-container select option {
        background: #031727;
        color: #c8e9ff;
        padding: 12px;
    }

    .form-container input:focus,
    .form-container select:focus {
        border-color: #00eaff;
        box-shadow: 0 0 10px rgba(0,255,255,0.4);
    }

    .form-container .btn {
        display: block;
        width: 100%;
        padding: 20px;
        background: linear-gradient(90deg, #00eaff, #00c1ff);
        border-radius: 40px;
        text-align: center;
        font-size: 20px;
        color: #003544;
        font-weight: 600;
        border: none;
        cursor: pointer;
        margin-top: 20px;
        text-decoration: none;
        box-shadow: 0 0 25px rgba(0,255,255,0.35);
        transition: 0.25s;
    }

    .form-container .btn:hover {
        box-shadow: 0 0 40px rgba(0,255,255,0.7);
        transform: scale(1.02);
    }

    @media (max-width: 768px) {
        .modal-content {
            margin: 5% auto;
            width: 95%;
        }

        .modal h1 {
            font-size: 28px;
            margin-top: 15px;
        }

        .form-container {
            padding: 20px;
            margin: 15px auto;
        }
    }
</style>
</head>

<body>

<section class="hero">

    <!-- Logos -->
    <div class="logos-container">
        <img src="assets/images/logo-point-tracing.png"
             alt="Point Tracing Logo"
             class="hero-icon">
    </div>

    <!-- Título -->
    <h1 class="hero-title">
        Point Tracing Rastreamento Inteligente para Construção Civil
    </h1>

    <!-- Subtexto -->
    <p class="hero-subtitle">
        Realidade Aumentada com IA para cálculos automáticos e precisão em tempo real.
        Transforme seus projetos com tecnologia de ponta.
    </p>

    <!-- Texto UpLab com logo -->
    <div class="uplab-section">
        <img src="assets/images/UpLab Branco Logo.png"
             alt="UpLab SENAI Logo"
             class="uplab-logo">
        <p class="uplab-text">
            Orgulhosamente parte do ecossistema UpLab SENAI, acelerando inovação em construção civil.
        </p>
    </div>

    <!-- Seção de Benefícios -->
    <section class="benefits">
        <h2 class="benefits-title">Revolucione sua Construção com Realidade Aumentada</h2>
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">🔍</div>
                <h3>Precisão em Tempo Real</h3>
                <p>Visualize medições exatas diretamente no canteiro de obras através do seu dispositivo móvel.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">🤖</div>
                <h3>IA Inteligente</h3>
                <p>Cálculos automáticos e sugestões inteligentes para otimizar seus projetos de construção.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">⚡</div>
                <h3>Eficiência Máxima</h3>
                <p>Reduza erros e acelere processos com tecnologia de ponta em realidade aumentada.</p>
            </div>
        </div>
    </section>

    <!-- Botão -->
    <a href="#" class="btn btn-primary" id="openModal">Participar do Beta Exclusivo</a>

</section>

<!-- Modal -->
<div id="betaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Participe do Beta Exclusivo</h1>

        <div class="form-container">
            <form method="POST" action="">
                <label>Nome Completo</label>
                <input type="text" name="nome" placeholder="Digite seu nome completo" required>

                <label>E-mail</label>
                <input type="email" name="email" placeholder="Seu e-mail" required>

                <label>Telefone</label>
                <input type="text" name="telefone" placeholder="(DDD) 00000-0000" required>

                <label>Profissão</label>
                <select name="profissao" required>
                    <option selected disabled>Selecione sua profissão</option>
                    <option>Engenheiro</option>
                    <option>Arquiteto</option>
                    <option>Mestre de Obras</option>
                    <option>Técnico de Edificações</option>
                    <option>Outro</option>
                </select>

                <label>Dispositivo</label>
                <select name="dispositivo" required>
                    <option selected disabled>Selecione seu dispositivo</option>
                    <option>iPhone</option>
                    <option>iPad</option>
                    <option>Android</option>
                </select>

                <button type="submit" class="btn">Receber Acesso ao Beta</button>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functionality
const modal = document.getElementById('betaModal');
const openModalBtn = document.getElementById('openModal');
const closeBtn = document.getElementsByClassName('close')[0];

// Open modal
openModalBtn.onclick = function(e) {
    e.preventDefault();
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close modal
closeBtn.onclick = function() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.style.display === 'block') {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});

// Mostrar mensagens de sucesso/erro
<?php if (isset($mensagem)): ?>
document.addEventListener('DOMContentLoaded', function() {
    // Criar elemento de mensagem
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message <?php echo $tipo_mensagem; ?>';
    messageDiv.innerHTML = '<?php echo $mensagem; ?>';

    // Estilos da mensagem
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        z-index: 10000;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        animation: slideIn 0.3s ease-out;
    `;

    if ('<?php echo $tipo_mensagem; ?>' === 'sucesso') {
        messageDiv.style.background = 'linear-gradient(135deg, #00eaff, #00c8ff)';
        messageDiv.style.border = '1px solid #00eaff';
    } else {
        messageDiv.style.background = 'linear-gradient(135deg, #ff4757, #ff3838)';
        messageDiv.style.border = '1px solid #ff4757';
    }

    // Adicionar ao body
    document.body.appendChild(messageDiv);

    // Abrir modal se foi sucesso
    <?php if ($tipo_mensagem === 'sucesso'): ?>
    setTimeout(function() {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }, 1000);
    <?php endif; ?>

    // Remover mensagem após 5 segundos
    setTimeout(function() {
        messageDiv.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(function() {
            if (messageDiv.parentNode) {
                messageDiv.parentNode.removeChild(messageDiv);
            }
        }, 300);
    }, 5000);
});
<?php endif; ?>
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

</body>
</html>
