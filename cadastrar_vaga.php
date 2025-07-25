<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_empresa'])) {
    die("Acesso não autorizado.");
}

$id_empresa = $_SESSION['id_empresa'];

// Pegando os dados do formulário
$titulo = $_POST['titulo'];
$categoria = $_POST['categoria'];
$nivel_experiencia = $_POST['nivel_experiencia'];
$faixa_salarial = $_POST['faixa_salarial'];
$modalidade_trabalho = $_POST['modalidade_trabalho'];
$cidade = $_POST['cidade'];
$descricao_detalhada = $_POST['descricao_detalhada'];
$requisitos = $_POST['requisitos'];
$beneficios = $_POST['beneficios'];
$data_limite = $_POST['data_limite'];
$numero_vagas = $_POST['numero_vagas'];
$urgencia = $_POST['urgencia'];

// Inserção no banco
$query = "INSERT INTO vaga (titulo, categoria, nivel_experiencia, faixa_salarial, modalidade_trabalho, cidade, 
descricao_detalhada, requisitos, beneficios, data_limite, numero_vagas, urgencia, id_empresa)
VALUES ('$titulo', '$categoria', '$nivel_experiencia', '$faixa_salarial', '$modalidade_trabalho', '$cidade', 
'$descricao_detalhada', '$requisitos', '$beneficios', '$data_limite', '$numero_vagas', '$urgencia', '$id_empresa')";

if (mysqli_query($conexao, $query)) {
    echo "Vaga cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar vaga: " . mysqli_error($conexao);
}


?>
