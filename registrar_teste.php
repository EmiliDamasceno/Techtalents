<?php
include('conexao.php');
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Verifica se já registrou
$sql_verifica = "SELECT id_teste FROM teste_realizado WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql_verifica);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Insere apenas se não existir
    $sql_insert = "INSERT INTO teste_realizado (id_usuario) VALUES (?)";
    $stmt_insert = $conexao->prepare($sql_insert);
    $stmt_insert->bind_param("i", $id_usuario);
    $stmt_insert->execute();
}

// Redireciona para página de conclusão
header('Location: pgteste.php');
exit();
?>
