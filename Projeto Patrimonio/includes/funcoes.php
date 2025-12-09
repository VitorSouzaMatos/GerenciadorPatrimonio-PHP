<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$con = mysqli_connect("localhost", "root", "", "db");


function limpeza($ent) {
    return htmlspecialchars(stripslashes(trim($ent)));
}

function crip($ent) {
    return hash("sha256", $ent);
}

function expulsa() {
    if(!isset($_SESSION['logado']) || $_SESSION['logado']!=true) {
        header("location: login.php"); 
        exit;
    }
}

function verificarPermissao($nivel_necessario) {
    expulsa();

    if($_SESSION['nivel'] > $nivel_necessario) {
        echo "<script>alert('Acesso Negado!'); window.location='index.php';</script>";
        exit;
    }
}
?>