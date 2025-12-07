<?php
// auth/login.php
session_start();

// Se já estiver logado, redireciona
if (isset($_SESSION['usuario_id'])) {
    header('Location: /index.php');
    exit();
}

require_once '../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if (empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos';
    } else {
        $pdo = conectar();
        $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha, role, ativo FROM tb_usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            if ($usuario['ativo'] == 1) {
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_role'] = $usuario['role'];
                
                header('Location: /index.php');
                exit();
            } else {
                $erro = 'Usuário inativo. Contate o administrador.';
            }
        } else {
            $erro = 'Email ou senha incorretos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Patrimônio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Sistema de Patrimônio</h3>
                
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                
                <div class="mt-4 text-center">
                    <small class="text-muted">
                        <strong>Usuários de teste:</strong><br>
                        Admin: admin@sistema.com / admin123<br>
                        Operador: operador@sistema.com / admin123
                    </small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>