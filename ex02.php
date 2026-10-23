<?php
declare(strict_types=1);

// Solicita uma senha pelo terminal.
echo "Digite uma senha: ";
$senha = trim((string) fgets(STDIN));

// Gera o hash usando Argon2id.
$hash = password_hash($senha, PASSWORD_ARGON2ID);

if ($hash === false) {
    exit("Erro ao gerar o hash.\n");
}

// Separa os blocos do hash.
$partes = explode('$', $hash);

echo "\n=== Inspetor de Hash ===\n";
echo "Hash completo: $hash\n";
echo "Algoritmo: " . ($partes[1] ?? 'indisponível') . "\n";
echo "Versão e custos: " . ($partes[2] ?? 'indisponível') . "\n";
echo "Salt codificado: " . ($partes[3] ?? 'indisponível') . "\n";
echo "Hash final: " . ($partes[4] ?? 'indisponível') . "\n";
