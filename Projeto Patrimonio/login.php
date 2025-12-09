
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f0f0; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input[type="text"], input[type="password"] { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; }
        input[type="submit"] { background-color: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; width: 100%; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .erro { color: red; font-size: 0.9em; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Acesso - Gerenciador de Patrimonio - FATEC AQA</h2>
        
        <?php
        if(isset($_GET['msg']) && $_GET['msg'] == 'falha') {
            echo "<p class='erro'>Usuário ou senha incorretos!</p>";
        }
        ?>

        <form action="valida.php" method="post">
            <input type="text" name="txtuser" placeholder="Usuário" required>
            <input type="password" name="txtpw" placeholder="Senha" required>
            <input type="submit" value="Entrar">
        </form>
        
        <p>Credenciais:</p><p>admin / admin</p> 
        <p>operador/operador</p>
    </div>

</body>
</html>