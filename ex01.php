
<?php
declare(strict_types=1);

require_once __DIR__ . '/../6-ConexaoBD/src/ConexaoBanco.php';

$pdo = ConexaoBanco::obterConexao(
    __DIR__ . '/../6-ConexaoBD/config/database.ini'
);

// Classe responsável pelo cadastro.
class UsuarioDAO
{
    public function __construct(private PDO $pdo) {}

    public function cadastrar(
        string $nome,
        string $email,
        string $hash
    ): void {
        $sql = "INSERT INTO usuarios (nome, email, senha)
                VALUES (:nome, :email, :senha)";
        $comando = $this->pdo->prepare($sql);
        $comando->execute([
            'nome' => $nome,
            'email' => $email,
            'senha' => $hash
        ]);
    }
}

// Valida a complexidade da senha.
function senhaValida(string $senha): bool
{
    return strlen($senha) >= 8
        && preg_match('/[A-Z]/', $senha) === 1
        && preg_match('/[a-z]/', $senha) === 1
        && preg_match('/[0-9]/', $senha) === 1
        && preg_match('/[^a-zA-Z0-9]/', $senha) === 1;
}

echo "=== Cadastro de Colaborador ===\n";
echo "Nome: ";
$nome = trim((string) fgets(STDIN));
echo "E-mail: ";
$email = trim((string) fgets(STDIN));
echo "Senha: ";
$senha = trim((string) fgets(STDIN));

if (!senhaValida($senha)) {
    exit("Senha inválida! Use 8 caracteres, maiúscula, minúscula, número e símbolo.\n");
}

$hash = password_hash($senha, PASSWORD_ARGON2ID);
$dao = new UsuarioDAO($pdo);
$dao->cadastrar($nome, $email, $hash);

echo "Cadastro realizado com sucesso!\n";
