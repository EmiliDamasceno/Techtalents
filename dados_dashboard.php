<?php
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "techtalents");
if ($mysqli->connect_errno) {
    echo json_encode(["erro" => "Erro de conexão: " . $mysqli->connect_error]);
    exit;
}

// 1. Contagem geral
$vagas = $mysqli->query("SELECT COUNT(*) AS total FROM vaga")->fetch_assoc()['total'];
$candidaturas = $mysqli->query("SELECT COUNT(*) AS total FROM candidatura")->fetch_assoc()['total'];
$testes = $mysqli->query("SELECT COUNT(*) AS total FROM teste_realizado")->fetch_assoc()['total'];
$aprovados = $mysqli->query("SELECT COUNT(*) AS total FROM candidatura WHERE status = 'Aprovado'")->fetch_assoc()['total'];

// Contagem por status (detalhado)
$statusesEspecificos = ['Em análise', 'Aprovado', 'Reprovado'];
$quantidadesPorStatus = [];
foreach ($statusesEspecificos as $status) {
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS total FROM candidatura WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $quantidadesPorStatus[$status] = (int)$res['total'];
    $stmt->close();
}

// Candidatos por status
$statusArray = [];
$valoresStatus = [];
$totalCandidatos = (int)$candidaturas; // já pegamos acima
$resultStatus = $mysqli->query("SELECT status, COUNT(*) AS total FROM candidatura GROUP BY status");
while ($row = $resultStatus->fetch_assoc()) {
    $statusArray[] = $row['status'];
    $valoresStatus[] = (int)$row['total'];
}
$candidatosPorStatus = [
    'status' => $statusArray,
    'valores' => $valoresStatus,
    'total' => $totalCandidatos
];

// Montar resposta completa
$response = [
    "vagas" => (int)$vagas,
    "candidaturas" => (int)$candidaturas,
    "testes" => (int)$testes,
    "aprovados" => (int)$aprovados,
    "quantidadePorStatusEspecificos" => $quantidadesPorStatus,
    "candidatosPorStatus" => $candidatosPorStatus
];

echo json_encode($response);



