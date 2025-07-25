<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.html');
    exit();
}

include 'conexao.php';

// Inicializa a variável
$nome_usuario = '';

// Pega o nome do usuário logado
$id_usuario = $_SESSION['id_usuario'];
$sql_nome = $conexao->prepare("SELECT nome FROM usuario WHERE id_usuario = ?");
$sql_nome->bind_param("i", $id_usuario);
$sql_nome->execute();
$res_nome = $sql_nome->get_result();

if ($res_nome->num_rows > 0) {
    $usuario = $res_nome->fetch_assoc();
    $nome_usuario = $usuario['nome'];
}

$mensagem_js = '';

if (isset($_POST['inscrever'])) {
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $id_vaga = $_POST['id_vaga'];
    // Verificar se a vaga ainda está dentro do prazo
    $sql_verifica_data = $conexao->prepare("SELECT data_limite FROM vaga WHERE id_vaga = ?");
    $sql_verifica_data->bind_param("i", $id_vaga);
    $sql_verifica_data->execute();
    $res_data = $sql_verifica_data->get_result();
    $vaga_data = $res_data->fetch_assoc();

    if (date('Y-m-d') > $vaga_data['data_limite']) {
        $mensagem_js = 'O prazo para candidatura nesta vaga expirou.';
        return;
    }


    if (!$id_usuario) {
        $mensagem_js = 'Você precisa estar logado para se inscrever.';
    } else {
        // Verifica currículo
        $sql_curriculo = $conexao->prepare("SELECT * FROM curriculo WHERE id_usuario = ?");
        $sql_curriculo->bind_param("i", $id_usuario);
        $sql_curriculo->execute();
        $res_curriculo = $sql_curriculo->get_result();

        if ($res_curriculo->num_rows == 0) {
            $mensagem_js = 'Você precisa cadastrar um currículo antes de se inscrever.';
        } else {
            // Verifica duplicidade
            $verifica = $conexao->prepare("SELECT * FROM candidatura WHERE id_usuario = ? AND id_vaga = ?");
            $verifica->bind_param("ii", $id_usuario, $id_vaga);
            $verifica->execute();
            $res = $verifica->get_result();

            if ($res->num_rows > 0) {
                $mensagem_js = 'Você já se inscreveu nessa vaga.';
            } else {
                $insere = $conexao->prepare("INSERT INTO candidatura (id_usuario, id_vaga) VALUES (?, ?)");
                $insere->bind_param("ii", $id_usuario, $id_vaga);
                if ($insere->execute()) {
                    $mensagem_js = 'Inscrição realizada com sucesso!';
                } else {
                    $mensagem_js = 'Erro ao se inscrever.';
                }
            }
        }
    }
}

// consulta de vagas
$sql = "
SELECT 
  v.id_vaga,
  v.titulo,
  v.modalidade_trabalho,
  v.cidade,
  v.numero_vagas,
  v.data_limite,
  COUNT(c.id_candidatura) AS total_candidatos
FROM vaga v
LEFT JOIN candidatura c ON v.id_vaga = c.id_vaga
GROUP BY v.id_vaga
ORDER BY v.data_criacao DESC
";

$result = $conexao->query($sql);


// Consulta das candidaturas do usuário
$candidaturas_result = null;
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    $sql_candidaturas = "
        SELECT v.titulo, v.cidade, v.modalidade_trabalho, c.data_candidatura, c.status
        FROM candidatura c
        JOIN vaga v ON c.id_vaga = v.id_vaga
        WHERE c.id_usuario = ?
        ORDER BY c.data_candidatura DESC
    ";

    $stmt = $conexao->prepare($sql_candidaturas);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $candidaturas_result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Talents - Portal de Vagas</title>
    <link rel="stylesheet" href="css/vagas_user.css">

</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item"><a href="curriculo.php" class="nav-link">Cadastrar Currículo</a></li>
                    <li class="nav-item"><a href="pgteste.php" class="nav-link">Testes</a></li>
                </ul>
               <!-- <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button> -->
            </nav>

            <div class="logo-container" onclick="goHome()">
                <img src="img/logo.png" alt="Tech Talents Logo" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span class="logo-text">TECH TALENTS</span>
            </div>

            <form action="logout.php" method="post">
                <button type="submit" class="btn_sair">Sair</button>
            </form>
        </div>
    </header>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-container">
            <div class="avatar">👨‍💻</div>
            <div class="welcome-content">
               <h2>Olá, <?= htmlspecialchars($nome_usuario) ?></h2>
                <p>Seja bem-vindo(a) à nova área de candidatos da Tech talents.<br>
                Veja as <strong>empresas que você já se candidatou</strong> ou acesse o <strong>Portal de Vagas</strong> para buscar novas oportunidades.</p>
            
            </div>
        </div>
    </section>

    <!-- Jobs Section -->
    <section class="jobs-section">
        <div class="jobs-container">
            <h2 class="section-title">Vagas</h2>
            <div class="jobs-grid" id="jobsGrid">
                <?php while ($vaga = $result->fetch_assoc()): ?>
                <div class="job-card">
                    <h3 class="job-title"><?= htmlspecialchars($vaga['titulo']) ?></h3><br>
                    <p><strong>Cidade:</strong> <?= htmlspecialchars($vaga['cidade']) ?></p>
                    <p><strong>Modalidade:</strong> <?= htmlspecialchars($vaga['modalidade_trabalho']) ?></p>
                    <p><strong>Vagas Disponíveis:</strong> <?= (int)$vaga['numero_vagas'] ?></p>
                    <p><strong>Candidatos:</strong> <?= (int)($vaga['total_candidatos'] ?? 0) ?></p>
                    <p><strong>Data limite para candidatura:</strong> 
                        <?= $vaga['data_limite'] ? date('d/m/Y', strtotime($vaga['data_limite'])) : 'Não informada' ?>
                    </p>
                    <p><strong>Progresso:</strong> <?= (int)($vaga['total_candidatos'] ?? 0) ?> / <?= (int)$vaga['numero_vagas'] ?></p>

                    <?php
$data_limite = $vaga['data_limite'];
$hoje = date('Y-m-d');
if ($hoje <= $data_limite): ?>
    <form method="POST" action="vagas_user.php">
        <input type="hidden" name="id_vaga" value="<?= $vaga['id_vaga'] ?>"><br>
        <button type="submit" name="inscrever" class="btn btn-primary mt-2">Se inscrever</button>
    </form>
<?php else: ?>
    <p style="color:red;"><strong>Prazo encerrado para candidatura</strong></p>
<?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Candidaturas -->
    <section class="applications-section">
        <div class="applications-container">
            <h2 class="applications-title">Minhas candidaturas</h2>
            <div class="jobs-grid">
                <?php if ($candidaturas_result && $candidaturas_result->num_rows > 0): ?>
                    <?php while ($c = $candidaturas_result->fetch_assoc()): ?>
                        <div class="job-card">
                            <h3 class="job-title"><?= htmlspecialchars($c['titulo']) ?></h3><br>
                            <p><strong>Cidade:</strong> <?= htmlspecialchars($c['cidade']) ?> (<?= htmlspecialchars($c['modalidade_trabalho']) ?>)</p>
                            <p><strong>Data da candidatura:</strong> <?= date('d/m/Y H:i', strtotime($c['data_candidatura'])) ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($c['status']) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você ainda não se candidatou a nenhuma vaga.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4>Sou</h4>
                    <ul>
                        <li><a href="#">Minhas Candidaturas</a></li>
                        <li><a href="#">Currículo</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Empresa</h4>
                    <ul>
                        <li><a href="#">Vagas</a></li>
                        <li><a href="#">Testes</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-logo">
                    <img src="img/logo.png" alt="Tech Talents Logo" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                </div>
                <div class="footer-info">
                    © 2023 Talentos. All rights reserved. | Privacy Policy | Terms of Service
                </div>
            </div>
        </div>
    </footer>

    <?php if (!empty($mensagem_js)): ?>
    <script>
        alert("<?= addslashes($mensagem_js) ?>");
    </script>
    <?php endif; ?>
</body>
</html>
