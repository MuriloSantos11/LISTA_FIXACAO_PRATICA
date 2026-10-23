Parte A — Exercícios Teóricos de Fixação
## 1. Protocolo Stateless: O HTTP é stateless porque não guarda automaticamente informações entre requisições. Cookies e sessões permitem manter o usuário conectado e lembrar seus dados.

## 2. Cookies vs. Sessões: Cookies armazenam dados no navegador do usuário, enquanto sessões armazenam dados no servidor. As sessões são mais seguras para informações confidenciais.

## 3. Flag HttpOnly: Impede que scripts JavaScript acessem o cookie da sessão, dificultando o roubo do cookie em ataques XSS. Porém, não impede todos os efeitos de um ataque XSS.

## 4. Flag SameSite: O atributo SameSite=Lax restringe o envio de cookies em requisições iniciadas por outros sites, ajudando a proteger contra ataques CSRF.

## 5. Ataque de Session Fixation: Ocorre quando um invasor tenta fazer a vítima usar um identificador de sessão conhecido por ele. session_regenerate_id(true) troca o identificador após o login, reduzindo esse risco.

## 6. MD5 e Rainbow Tables: MD5 e SHA-256 são algoritmos rápidos demais para armazenar senhas. Rainbow Tables são tabelas pré-calculadas que ajudam a descobrir senhas correspondentes a hashes vulneráveis.

## 7. Papel do Salt: É um valor aleatório adicionado ao processo de criação do hash da senha. Assim, usuários com a mesma senha podem ter hashes diferentes, dificultando ataques com tabelas pré-calculadas.

## 8. Argon2id vs. Bcrypt: Argon2id permite configurar o uso de memória, aumentando o custo de ataques com GPUs e ASICs. Por isso, pode oferecer maior resistência à força bruta quando configurado adequadamente.

## 9. Timing Attacks: password_verify() verifica a senha usando o hash armazenado e realiza a comparação de forma resistente a ataques de temporização, ao contrário de uma comparação comum com ===.