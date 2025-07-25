<?php
session_start();
include 'conexao.php';

$mensagem_js = '';

if (isset($_POST['inscrever'])) {
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $id_vaga = $_POST['id_vaga'];

    if (!$id_usuario) {
        $mensagem_js = 'Você precisa estar logado para se inscrever.';
    } else {
        // Verifica currículo
        $sql_curriculo = $conexao->prepare("SELECT * FROM curriculo WHERE cpf = (SELECT cpf FROM usuario WHERE id_usuario = ?)");
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
  COUNT(c.id_candidatura) AS total_candidatos,
  MAX(c.data_candidatura) AS ultima_candidatura
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
   <link rel="stylesheet" href="css/vagas.css">

    <style>
    .btn-inscrever {
  background-color: #2563eb;
  color: white;
  border: none;
  padding: 5px 8px; /* Botão um pouco maior */
  border-radius: 20px;
  cursor: pointer;
  font-size: 15px;
  font-weight: 500;
  transition: all 0.3s;
  width: 100%;
  margin-top: 20px; /* Espaço maior acima do botão */
  text-align: center;
  text-decoration: none;
  display: block;
  line-height: 1.5; /* Espaçamento interno no botão */
}

.btn-inscrever:hover {
  background-color: #1d4ed8;
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
}
    </style>

</head>

<body>
    <!-- Header -->
     <header class="header">
        <div class="container">
            <!-- Navigation Menu -->
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="vagas.php" class="nav-link" data-section="vagas">Vagas</a>
                    </li>
                </ul>
                
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    ☰
                </button>
     
            </nav>

            <!-- Logo -->
            <div class="logo-container" onclick="goHome()">
                
                <img src="img/logo.png" alt="Tech Talents Logo" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                
                <!-- Texto de fallback caso a imagem não carregue -->
                <span class="logo-text">TECH TALENTS</span>
            </div>

            <!-- Auth Buttons -->
            <div class="auth-buttons">
                <button class="btn btn-login" onclick="window.location.href='login.html'">Login</button>
                <button class="btn btn-register" onclick="window.location.href='cadastro.php'">Registre-se</button>
            </div>

        </div>
    </header>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-container">
            <div class="avatar">👨‍💻</div>
            <div class="welcome-content">
                <h2>Olá, Candidato(a)</h2>
                <p>Seja bem-vindo(a) à nova área de candidatos da Tech Talents.<br>
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
    <h3 class="job-title"><?= htmlspecialchars($vaga['titulo']) ?></h3>
    <div class="job-details">
    <p><strong>Cidade:</strong> <?= htmlspecialchars($vaga['cidade']) ?></p>
    <p><strong>Modalidade:</strong> <?= htmlspecialchars($vaga['modalidade_trabalho']) ?></p>
    <p><strong>Vagas Disponíveis:</strong> <?= (int)$vaga['numero_vagas'] ?></p>
    <p><strong>Candidatos:</strong> <?= (int)($vaga['total_candidatos'] ?? 0) ?></p>
    <p><strong>Última candidatura:</strong> 
      <?= $vaga['ultima_candidatura'] ? date('d/m/Y H:i', strtotime($vaga['ultima_candidatura'])) : 'Nenhuma' ?>
    </p>
    <p><strong>Progresso:</strong> <?= (int)($vaga['total_candidatos'] ?? 0) ?> / <?= (int)$vaga['numero_vagas'] ?></p>
    </div>


      <a href="login.html" class="btn btn-primary mt-2" role="button">Se inscrever</a>

  </div>
<?php endwhile; ?>

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
</body>
</html>