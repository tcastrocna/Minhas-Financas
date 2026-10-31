<?php
// TRAVA DE SEGURANÇA: Bloqueia acesso direto a este arquivo pela URL
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Acesso direto negado.']);
    exit;
}

$json = file_get_contents('php://input');
$request = json_decode($json, true);
$token = $request['token'] ?? null;

if ($token && session_status() === PHP_SESSION_NONE) {
    session_id($token);
}

require_once __DIR__ . '/../../../../private/finance/config.php';

if (!isset($request['action'])) {
    echo json_encode(['success' => false, 'message' => 'Ação não especificada.']);
    exit;
}

$action = $request['action'];
$payload = $request['payload'] ?? null;

function checkAuth()
{
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Sessão expirada.', 'expired' => true]);
        exit;
    }
    return $_SESSION['user_id'];
}

switch ($action) {
    case 'loginUser':
        $email = $payload['email'] ?? '';
        $senha = $payload['senha'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && ($senha === $user['senha'] || password_verify($senha, $user['senha']))) {
            $_SESSION['user_id'] = $user['id'];
            $app_config = json_decode($user['app_config'], true) ?? ['modo_dark' => 'false'];
            $userData = ['nome' => $user['nome'], 'email' => $user['email'], 'app_config' => $app_config];
            echo json_encode(['success' => true, 'user' => $userData, 'token' => session_id()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos.']);
        }
        break;

    case 'logoutUser':
        session_destroy();
        echo json_encode(['success' => true]);
        break;

    case 'getLancamentos':
        $userId = checkAuth();
        $stmt = $pdo->prepare("SELECT * FROM lancamentos WHERE usuario_id = ? AND ativo = 1 ORDER BY data_vencimento DESC");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        $lancamentos = [];
        foreach ($rows as $row) {
            $lancamentos[] = [
                'id' => $row['id'],
                'tipo' => $row['tipo'],
                'categoria' => $row['categoria'],
                'descricao' => $row['descricao'],
                'valorPrevisto' => $row['valor_previsto'],
                'valorReal' => $row['valor_real'],
                'data' => $row['data_vencimento'],
                'dataPago' => $row['data_pago'],
                'groupId' => $row['group_id'],
                'recurrenceType' => $row['recurrence_type'],
                'instituicao' => $row['instituicao'] ?? 'OUTROS' // Compatibilidade com antigos
            ];
        }
        echo json_encode(['success' => true, 'data' => $lancamentos]);
        break;

    case 'salvarLancamento':
        $userId = checkAuth();
        $dados = $payload['dados'];
        if (!is_array(reset($dados))) {
            $dados = [$dados];
        }

        try {
            $pdo->beginTransaction();
            $stmtInsert = $pdo->prepare("INSERT INTO lancamentos (id, usuario_id, tipo, categoria, descricao, valor_previsto, valor_real, data_vencimento, data_pago, group_id, recurrence_type, instituicao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtUpdate = $pdo->prepare("UPDATE lancamentos SET categoria = ?, descricao = ?, valor_previsto = ?, valor_real = ?, data_vencimento = ?, data_pago = ?, instituicao = ? WHERE id = ? AND usuario_id = ?");

            foreach ($dados as $item) {
                $id = !empty($item['id']) ? $item['id'] : uniqid('fin_');
                $tipo = $item['tipo'] ?? '';
                $categoria = $item['categoria'] ?? null;
                $descricao = $item['descricao'] ?? '';
                $valorPrevisto = !empty($item['valorPrevisto']) ? $item['valorPrevisto'] : 0.00;
                $valorReal = !empty($item['valorReal']) ? $item['valorReal'] : 0.00;
                $data = !empty($item['data']) ? $item['data'] : null;
                $dataPago = !empty($item['dataPago']) ? $item['dataPago'] : null;
                $groupId = $item['groupId'] ?? null;
                $recurrenceType = $item['recurrenceType'] ?? null;
                $instituicao = !empty($item['instituicao']) ? $item['instituicao'] : 'OUTROS';

                if (!empty($item['id'])) {
                    $stmtCheck = $pdo->prepare("SELECT id FROM lancamentos WHERE id = ? AND usuario_id = ?");
                    $stmtCheck->execute([$id, $userId]);
                    if ($stmtCheck->rowCount() > 0) {
                        $stmtUpdate->execute([$categoria, $descricao, $valorPrevisto, $valorReal, $data, $dataPago, $instituicao, $id, $userId]);
                        continue;
                    }
                }
                $stmtInsert->execute([$id, $userId, $tipo, $categoria, $descricao, $valorPrevisto, $valorReal, $data, $dataPago, $groupId, $recurrenceType, $instituicao]);
            }
            $pdo->commit();
            echo json_encode(['success' => true, 'message' => 'Salvo com sucesso!']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Erro ao salvar: ' . $e->getMessage()]);
        }
        break;

    case 'excluirLancamento':
        $userId = checkAuth();
        $id = $payload['id'];
        $stmt = $pdo->prepare("UPDATE lancamentos SET ativo = 0 WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $userId]);
        echo json_encode(['success' => true]);
        break;

    case 'getUserSetup':
        $userId = checkAuth();
        $stmt = $pdo->prepare("SELECT nome, email, app_config FROM usuarios WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        if ($user) {
            $userData = ['nome' => $user['nome'], 'email' => $user['email'], 'app_config' => json_decode($user['app_config'], true)];
            echo json_encode(['success' => true, 'data' => $userData]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
        }
        break;

    case 'excluirGrupoPendente':
        $userId = checkAuth();
        $groupId = $payload['groupId'];
        $stmt = $pdo->prepare("UPDATE lancamentos SET ativo = 0 WHERE group_id = ? AND usuario_id = ? AND (valor_real IS NULL OR valor_real = 0 OR valor_real = 0.00)");
        $stmt->execute([$groupId, $userId]);
        echo json_encode(['success' => true, 'message' => 'Parcelas pendentes canceladas.']);
        break;

    case 'saveUserSetup':
        $userId = checkAuth();
        $dados = $payload;
        $stmt = $pdo->prepare("SELECT senha FROM usuarios WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!empty($dados['newPassword'])) {
            if (empty($dados['currentPassword'])) {
                echo json_encode(['success' => false, 'message' => 'Informe a senha atual para alterar.']);
                exit;
            }
            if (!password_verify($dados['currentPassword'], $user['senha'])) {
                echo json_encode(['success' => false, 'message' => 'Senha atual incorreta.']);
                exit;
            }
            $novaSenhaHash = password_hash($dados['newPassword'], PASSWORD_DEFAULT);
            $stmtUpdatePass = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
            $stmtUpdatePass->execute([$novaSenhaHash, $userId]);
        }

        $modoDark = $dados['modo_dark'] ? 'true' : 'false';
        $corTema = $dados['cor_tema'] ?? '#007AFF';
        $contas = $dados['contas'] ?? []; // Pega as contas do Payload

        $appConfig = json_encode(['modo_dark' => $modoDark, 'cor_tema' => $corTema, 'contas' => $contas]);
        $stmtUpdate = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, app_config = ? WHERE id = ?");
        $stmtUpdate->execute([$dados['nome'], $dados['email'], $appConfig, $userId]);

        echo json_encode(['success' => true, 'data' => ['nome' => $dados['nome'], 'email' => $dados['email'], 'app_config' => ['modo_dark' => $modoDark, 'cor_tema' => $corTema, 'contas' => $contas]]]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Ação desconhecida.']);
        break;
}
?>