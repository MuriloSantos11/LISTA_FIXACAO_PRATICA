<?php
declare(strict_types=1);

require_once __DIR__ . '/../6-ConexaoBD/src/ConexaoBanco.php';

$pdo = ConexaoBanco::obterConexao(
    __DIR__ . '/../6-ConexaoBD/config/database.ini'
);

// Cria a tabela de auditoria.
$sql = "CREATE TABLE IF NOT EXISTS auditoria_logins (
    id SERIAL PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    ip VARCHAR(45),
    user_agent TEXT,
    sucesso BOOLEAN NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($sql);

// Registra uma tentativa de login.
function registrarLogin(
    PDO $pdo,
    string $email,
    bool $sucesso
): void {
    $sql = "INSERT INTO auditoria_logins
            (email, ip, user_agent, sucesso)
            VALUES (:email, :ip, :agente, :sucesso)";
    $comando = $pdo->prepare($sql);
    $comando->execute([
        'email' => $email,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        'agente' => $_SERVER['HTTP_USER_AGENT'] ?? 'desconhecido',
        'sucesso' => $sucesso
    ]);
}

// Consulta os últimos registros.
$comando = $pdo->query(
    "SELECT * FROM auditoria_logins
     ORDER BY data_hora DESC LIMIT 20"
);
$registros = $comando->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Auditoria de Acessos</title>
</head>
<body>
    <h2>Últimas tentativas de login</h2>

    <table border="1">
        <tr>
            <th>E-mail</th>
            <th>IP</th>
            <th>Navegador</th>
            <th>Sucesso</th>
            <th>Data e hora</th>
        </tr>

        <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?= htmlspecialchars($registro['email']) ?></td>
            <td><?= htmlspecialchars($registro['ip'] ?? '') ?></td>
            <td><?= htmlspecialchars($registro['user_agent'] ?? '') ?></td>
            <td><?= $registro['sucesso'] ? 'Sim' : 'Não' ?></td>
            <td><?= htmlspecialchars((string) $registro['data_hora']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
