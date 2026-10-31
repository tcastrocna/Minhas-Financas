# Minhas-Financas
Saindo de um caderno para um app - Aplicação Web para gerenciamento  financeiro pessoal. 

# INFRAESTRUTURA DE APLICATIVOS (SaaS)

Este repositório contém a documentação e os scripts de banco de dados para os aplicativos hospedados no servidor.

## ESTRUTURA DO SERVIDOR

```txt
📁 ROOT (Raiz do Servidor Apache)
│
├── 📁 private/ (Seguro - Nível acima da public_html, ninguém acessa por URL)
│   └── config.php (Senhas do banco, conexões PDO do App Finanças)
│
└── 📁 public_html/ (Público - Raiz dos domínios, acessível pela Internet)
    ├── 📁 assets/
    ├── 📁 backend/ 
    │   ├── api.php      <-- (Gateway: Recebe requisições do App Finanças)
    │   └── 📁 modules/  <-- (Lógica de negócio: onde está o seu core.php)
    └── index.php       <-- (App Finanças)
```

## ARQUIVOS DA PASTA ``PRIVATE``

**📁 private/finance/config.php**

```php
<?php
// Define o fuso horário padrão do sistema
date_default_timezone_set('America/Sao_Paulo');

// Inicia a sessão globalmente e com segurança, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 1); // Exige HTTPS (Certifique-se de que o app finanças roda com SSL/HTTPS)
    
    session_start();
}

// Configurações do Banco de Dados FINANÇAS
define('DB_HOST', 'localhost');
define('DB_NAME', 'xxxxxxxxxxxxxxxxxxxxxxxx'); // Coloque o banco do novo app
define('DB_USER', 'xxxxxxxxxxxxxxxxxxxxxxxx');        // Coloque o usuário do novo app
define('DB_PASS', 'xxxxxxxxxxxxxxxxxxxxxxxx');          // Coloque a senha do novo app

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, 
        PDO::ATTR_STRINGIFY_FETCHES  => false
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    // Altere o caminho do log para a pasta do app financeiro, se preferir
    error_log("Erro de conexão PDO: " . $e->getMessage(), 3, __DIR__ . '/db_error.log');
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados. Contate o administrador.']));
}
?>

```

## ARQUIVOS DA ``PUBLIC_HTML``

- Os arquivos da ``public_html`` esta em anexo, todos os arquivos na ``main`` deste repositorio, eles são os de deploy do sistema. 


---
## 💻 COMO RODAR O PROJETO LOCALMENTE (AMBIENTE DE DESENVOLVIMENTO)

Para programar e testar em sua máquina antes de enviar para o GitHub, siga estes passos:

1. Instale o **XAMPP**.
2. Clone este repositório **dentro** de uma pasta no `htdocs`. (Ex: `C:/xampp/htdocs/meu_sistema/public_html`).
3. Crie manualmente a pasta `private` um nível acima da `public_html` (ela é ignorada pelo Git por segurança).
4. Crie os arquivos `config.php` dentro da pasta `private/one` e `private/finance` com as seguintes credenciais locais do XAMPP:
   - `DB_HOST`: 'localhost'
   - `DB_USER`: 'root'
   - `DB_PASS`: '' (vazio)
   - `DB_NAME`: 'nome_do_banco_local_que_voce_criou'
5. Abra o `http://localhost/phpmyadmin`, crie os bancos de dados e rode os scripts SQL descritos neste documento.
6. Acesse o sistema pelo navegador: `http://localhost/meu_sistema/public_html/financas/`

---
# BANCO DE DADOS

Aplicativo SaaS para controle de finanças pessoais. Base de dados centralizada onde o `usuario_id` garante a privacidade dos dados (cada usuário só vê os próprios lançamentos).

### 1.1 - CRIAÇÃO DAS TABELAS (Rodar apenas 1 vez)
```sql
-- Tabela de Usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL, 
    app_config JSON, 
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Lançamentos
CREATE TABLE lancamentos (
    id VARCHAR(50) PRIMARY KEY, 
    usuario_id INT NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    categoria VARCHAR(50),
    descricao VARCHAR(255),
    valor_previsto DECIMAL(10,2) DEFAULT 0.00,
    valor_real DECIMAL(10,2) DEFAULT 0.00,
    data_vencimento DATE,
    data_pago DATE NULL,
    group_id VARCHAR(50),
    recurrence_type VARCHAR(20),
    ativo TINYINT(1) DEFAULT 1, 
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
```

### 1.2 - ADICIONAR NOVO USUÁRIO (Dia a Dia)
Para conceder acesso ao aplicativo financeiro para um amigo ou cliente, execute o comando abaixo no phpMyAdmin.

```sql
INSERT INTO usuarios (nome, email, senha, app_config) 
VALUES (
    'Nome do Amigo', 
    'amigo@email.com', 
    '$2y$10$S.WjG/P0q...COLOQUE_O_HASH_AQUI', -- O Hash da senha gerada
    '{"modo_dark": "false"}'
);
```

---

# 2. UTILITÁRIO: GERADOR DE SENHAS CRIPTOGRAFADAS (HASH)
Como o sistema utiliza segurança moderna (`password_hash` do PHP), você **não pode** digitar "123456" direto no banco de dados. Se fizer isso, o usuário não conseguirá logar.

### Como gerar a senha para colocar no comando SQL:
Crie um arquivo temporário no seu servidor chamado `gerar_senha.php` (ou rode no seu computador local se tiver PHP instalado) com o código abaixo:

```php
<?php
$hash_gerado = "";
$senha_digitada = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {
    $senha_digitada = $_POST['senha'];
    // Gera o Hash seguro
    $hash_gerado = password_hash($senha_digitada, PASSWORD_DEFAULT);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Hash Seguro</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f2f2f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: #333; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 450px; }
        h2 { margin-top: 0; color: #007AFF; font-size: 1.5rem; text-align: center; }
        label { font-weight: 600; font-size: 0.9rem; display: block; margin-bottom: 8px; }
        input[type="text"] { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        button.btn-primary { width: 100%; padding: 12px; background: #007AFF; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: background 0.2s; }
        button.btn-primary:hover { background: #0056b3; }
        
        .result-box { margin-top: 25px; background: #f8f9fa; border: 1px solid #e5e5ea; padding: 15px; border-radius: 8px; text-align: center; }
        pre { background: #e5e5ea; padding: 10px; border-radius: 6px; font-size: 0.9rem; word-break: break-all; white-space: pre-wrap; margin: 10px 0; }
        button.btn-copy { background: #34C759; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; }
        button.btn-copy:hover { background: #28a745; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Gerador de Senha (Hash)</h2>
        <p style="text-align: center; font-size: 0.9rem; color: #666; margin-bottom: 20px;">
            Digite uma senha normal para convertê-la no padrão seguro do banco de dados.
        </p>

        <form method="POST">
            <label>Senha desejada:</label>
            <input type="text" name="senha" required placeholder="Ex: 123456" value="<?= htmlspecialchars($senha_digitada) ?>">
            <button type="submit" class="btn-primary">Gerar Hash</button>
        </form>

        <?php if ($hash_gerado): ?>
            <div class="result-box">
                <span style="font-size: 0.85rem; font-weight: bold; color: #555;">HASH GERADO:</span>
                <pre id="hashResult"><?= $hash_gerado ?></pre>
                <button type="button" class="btn-copy" onclick="copiarHash()">Copiar Hash</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function copiarHash() {
            var hashText = document.getElementById("hashResult").innerText;
            navigator.clipboard.writeText(hashText).then(function() {
                var btn = document.querySelector('.btn-copy');
                btn.innerText = "Copiado!";
                btn.style.background = "#007AFF";
                setTimeout(function() {
                    btn.innerText = "Copiar Hash";
                    btn.style.background = "#34C759";
                }, 2000);
            }, function(err) {
                alert('Erro ao copiar: ' + err);
            });
        }
    </script>
</body>
</html>
```

