<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_candidatura = $_POST['id_candidatura'];
    $novo_status = $_POST['status'];

    $sql = "UPDATE candidatura SET status = ? WHERE id_candidatura = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $novo_status, $id_candidatura);
    if ($stmt->execute()) {
        header('Location: perfil_empresa.php');
    } else {
        echo "Erro ao atualizar status.";
    }
}
?>
