<?php
session_start();
include("conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

// Primeiro tenta login como empresa
$query_empresa = "SELECT * FROM empresa WHERE email = '$email' AND senha = '$senha'";
$result_empresa = mysqli_query($conexao, $query_empresa);

if (mysqli_num_rows($result_empresa) == 1) {
    $empresa = mysqli_fetch_assoc($result_empresa);
    $_SESSION['id_empresa'] = $empresa['id_empresa'];
    $_SESSION['nome_empresa'] = $empresa['nome'];
    header("Location: dashboard.php");
    exit();
}

// Se não for empresa, tenta como usuário
$query_usuario = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
$result_usuario = mysqli_query($conexao, $query_usuario);

if (mysqli_num_rows($result_usuario) == 1) {
    $usuario = mysqli_fetch_assoc($result_usuario);
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nome_usuario'] = $usuario['nome'];
    header("Location: vagas_user.php");
    exit();
}

// Se não encontrou em nenhuma tabela → redireciona com erro
header("Location: login.html?erro=1");
exit();
?>
