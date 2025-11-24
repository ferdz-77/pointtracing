# Point Tracing - Landing Page

Página de destino para captação de leads do beta da Point Tracing, empresa de tecnologia para construção civil.

## 🚀 Funcionalidades

- **Design Moderno**: Interface futurista com tema ciano/tecnológico
- **Modal Interativo**: Formulário de inscrição no beta
- **Envio de Email**: Integração com PHPMailer para envio automático
- **Responsivo**: Funciona perfeitamente em desktop e mobile

## 📧 Configuração do Email

Para que o formulário funcione corretamente, você precisa configurar uma senha de app no Outlook/Hotmail:

### Passos para configurar:

1. **Acesse sua conta Microsoft:**
   - Vá para: https://account.microsoft.com/security/app-passwords
   - Faça login com sua conta `fernandodev@hotmail.com`

2. **Gere uma senha de app:**
   - Clique em "Criar uma senha de app"
   - Dê um nome (ex: "Point Tracing")
   - Copie a senha gerada (16 caracteres)

3. **Configure no arquivo `config.php`:**
   ```php
   'password' => 'SUA_SENHA_DE_APP_AQUI', // Cole a senha de 16 caracteres
   ```

4. **Teste o formulário:**
   - Acesse `http://localhost/pointtracing/`
   - Preencha e envie o formulário
   - Verifique se recebeu o email

## 📁 Estrutura do Projeto

```
pointtracing/
├── index.php              # Página principal com formulário
├── config.php             # Configurações de email
├── assets/
│   ├── css/
│   │   └── tapume.css     # Estilos da página de tapume
│   └── images/
│       └── logo-point-tracing.png
├── PHPMailer/             # Biblioteca PHPMailer
└── index.html             # Página de tapume (backup)
```

## 🛠️ Tecnologias Utilizadas

- **PHP 7.4+**: Processamento do formulário
- **PHPMailer**: Envio de emails
- **HTML5/CSS3**: Estrutura e estilos
- **JavaScript**: Interatividade do modal
- **SMTP Outlook**: Serviço de email

## 📱 Como Usar

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/ferdz-77/pointtracing.git
   ```

2. **Configure o XAMPP:**
   - Coloque a pasta no `htdocs`
   - Inicie Apache e MySQL

3. **Configure o email** (veja seção acima)

4. **Acesse:**
   - `http://localhost/pointtracing/`

## 📧 Formulário

O formulário coleta:
- Nome completo
- E-mail
- Telefone
- Profissão
- Dispositivo preferido

Os dados são enviados por email formatado em HTML para `fernandodev@hotmail.com`.

## 🎨 Design

- **Tema**: Azul ciano/tecnológico
- **Fonte**: FK Grotesk Neue, Geist, Inter
- **Efeitos**: Gradientes, sombras, animações
- **Grid**: Padrão sutil de fundo

## 🔧 Desenvolvimento

Para modificar:
- **Estilos**: Edite o CSS inline no `index.php`
- **PHP**: Modifique a lógica no topo do arquivo
- **Email**: Ajuste templates no código PHP

## 📞 Suporte

Para dúvidas ou problemas:
- Verifique os logs do PHP
- Confirme as configurações de email
- Teste com dados válidos

---

**Point Tracing** - Tecnologia de precisão para obras urbanas 🚀