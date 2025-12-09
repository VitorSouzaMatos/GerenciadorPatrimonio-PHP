<?php 
    require_once("includes/funcoes.php"); 
    
    $user = limpeza($_POST['txtuser']);
    $senha = crip(limpeza($_POST['txtpw']));

    $sql = "SELECT id_user, username, nivel FROM tb_users WHERE username=? AND senha=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $user, $senha);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nome, $nivel);
    
    if(mysqli_stmt_fetch($stmt)) {
        $_SESSION['logado'] = true;
        $_SESSION['username'] = $nome;
        $_SESSION['nivel'] = $nivel;
        header("location: index.php"); 
    } else {
        header("location: login.php?msg=falha");
    }
?>