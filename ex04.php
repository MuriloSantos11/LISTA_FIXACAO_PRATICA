<?php
declare(strict_types=1);

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

// Inicializa o controle de tentativas.
$_SESSION['tentativas_login'] ??= 0;
$_SESSION['bloqueado_ate'] ??= 0;

$agora = time();
$mensagem = '';

if ($agora < $_SESSION['bloqueado_ate']) {
    $restante = $_SESSION['bloqueado_ate'] - $agora;
    $mensagem = "Aguarde $restante segundos para tentar novamente.";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = (string) ($_POST['senha'] ?? '');

    // Senha de teste: Senha123!
    if ($senha === 'Senha123!') {
        $_SESSION['tentativas_login'] = 0;
        $_SESSION['bloqueado_ate'] = 0;
        $mensagem = 'Login realizado com sucesso!';
    } else {
        $_SESSION['tentativas_login']++;

        if ($_SESSION['tentativas_login'] >= 3) {
            $_SESSION['bloqueado_ate'] = time() + 60;
            $_SESSION['tentativas_login'] = 0;
            $mensagem = 'Bloqueado por 60 segundos.';
        } else {
            $mensagem = 'Senha incorreta. Tentativas: '
                . $_SESSION['tentativas_login'];
        }
    }
}
?>

<h2>Login de teste</h2>
<form method="post">
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <button type="submit">Entrar</button>
</form>

<p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></p>

<?php if (time() < $_SESSION['bloqueado_ate']): ?>
    <p>Tempo restante: <?= $_SESSION['bloqueado_ate'] - time() ?> segundos.</p>
<?php endif; ?>
