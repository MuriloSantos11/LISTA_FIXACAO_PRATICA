
<?php
declare(strict_types=1);

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

// Verifica se o perfil possui a permissão necessária.
function verificarPermissao(string $perfilMinimo): void
{
    $perfis = ['OPERADOR' => 1, 'ADMIN' => 2];

    $atual = $_SESSION['perfil'] ?? '';
    $nivelAtual = $perfis[$atual] ?? 0;
    $nivelMinimo = $perfis[$perfilMinimo] ?? 99;

    if ($nivelAtual < $nivelMinimo) {
        http_response_code(403);
        exit('<h1>Acesso negado</h1><p>Você não tem permissão para acessar esta página.</p>');
    }
}

// Exemplo: somente ADMIN pode acessar.
verificarPermissao('ADMIN');

echo "Acesso autorizado!";
