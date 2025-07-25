<?php
session_start();
if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.html");
    exit();
}
include 'conexao.php';

$id_empresa = $_SESSION['id_empresa']; // supondo que você armazene o ID da empresa na sessão

// Consulta todas as vagas da empresa com seus candidatos
$sql = "
SELECT 
    v.id_vaga, v.titulo,
    u.nome AS nome_candidato,
    c.id_candidatura,
    c.status,
    curr.arquivo_curriculo
FROM vaga v
LEFT JOIN candidatura c ON v.id_vaga = c.id_vaga
LEFT JOIN usuario u ON c.id_usuario = u.id_usuario
LEFT JOIN curriculo curr ON curr.id_usuario = u.id_usuario
WHERE v.id_empresa = ?
ORDER BY v.id_vaga DESC, u.nome ASC
";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();

// Agrupa por vaga
$vagas = [];
while ($row = $result->fetch_assoc()) {
    $vagas[$row['id_vaga']]['titulo'] = $row['titulo'];
    $vagas[$row['id_vaga']]['candidatos'][] = [
        'id_candidatura' => $row['id_candidatura'],
        'nome' => $row['nome_candidato'],
        'curriculo' => $row['arquivo_curriculo'],
        'status' => $row['status']
    ];
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil da Empresa</title>
    <link rel="stylesheet" href="css/perfil_empresa.css">

    <style>
        .vaga{
            align-items: center;
            text-align: center;
        }

        .box-vaga h2 {
            color:black;
            margin: 0;
            font-size: 18px;
        }

        .box-vaga .label {
           color:black;
           font-weight: bold;
           margin-right: 8px;
        }
        </style>
</head>

</style>

<body>

     <!-- Header -->
     <header class="header">
        <div class="container">
            <!-- Navigation Menu -->
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link" data-section="dashboard">Dashboard</a>
                    </li>
                </ul>
                
            </nav>

            <!-- Logo -->
            <div class="logo-container" onclick="goHome()">
                
                <img src="img/logo.png" alt="Tech Talents Logo" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                
                <!-- Texto de fallback caso a imagem não carregue -->
                <span class="logo-text">TECH TALENTS</span>
            </div>

        </div>
    </header>

    <?php foreach ($vagas as $id_vaga => $vaga): ?>

        <div class=vaga>
    <div class="box-vaga">
        <h2><span class="label"></span> <?= htmlspecialchars($vaga['titulo']) ?></h2>
    </div>

    <?php if (!empty($vaga['candidatos'])): ?>
        <ul style="list-style: none; padding-left: 0;">
        <?php foreach ($vaga['candidatos'] as $cand): ?>
            <li style="display: flex; align-items: center; margin-bottom: 10px; gap: 15px;">

                <form method="post" action="atualizar_status.php" style="display: flex; align-items: center; gap: 20px;">
                    <strong><span class="nome-candidato">👤<?= htmlspecialchars($cand['nome']) ?></span></strong>


                    <input type="hidden" name="id_candidatura" value="<?= $cand['id_candidatura'] ?>" class="vaga">

                    <select name="status" class="select-status">
                        <option value="Em análise" <?= $cand['status'] == 'Em análise' ? 'selected' : '' ?>>Em análise</option>
                        <option value="Aprovado" <?= $cand['status'] == 'Aprovado' ? 'selected' : '' ?>>Aprovado</option>
                        <option value="Reprovado" <?= $cand['status'] == 'Reprovado' ? 'selected' : '' ?>>Reprovado</option>
                    </select>

                    <button class="btn-salvar" type="submit">Salvar</button><br><br>
                </form>

                <?php
$caminho = $cand['curriculo'];
if (!empty($caminho)) {
    $caminho_relativo = htmlspecialchars($caminho);
    $caminho_fisico = __DIR__ . '/' . $caminho;
    if (file_exists($caminho_fisico)) {
        echo "<a href='{$caminho_relativo}' target='_blank' download class='btn-curriculo'>📄 Baixar currículo</a>";
    } else {
        echo "<span class='curriculo-info'>Arquivo não encontrado</span>";
    }
} else {
    echo "<span class='curriculo-info'>Sem currículo</span>";
}
?>

            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum candidato nesta vaga.</p>
    <?php endif; ?>
<?php endforeach; ?>
    </div>
<div id="mensagem-sucesso" style="display: none; color: green; margin-top: 10px; font-weight: bold;"></div>



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

    <script>
    // Seleciona todos os formulários de candidatura
    const formularios = document.querySelectorAll('form[action="atualizar_status.php"]');

    formularios.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Impede envio imediato

            // Envia o formulário via AJAX
            const formData = new FormData(form);

            fetch('atualizar_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Mostra mensagem de sucesso
                const msg = document.createElement('div');
                msg.innerText = 'Status atualizado com sucesso!';
                msg.style.color = 'green';;
                msg.style.marginTop = '10px';

                form.appendChild(msg);

                // Remove a mensagem depois de 3 segundos
                setTimeout(() => {
                    msg.remove();
                }, 3000);
            })
            .catch(error => {
                alert('Erro ao salvar status.');
                console.error(error);
            });
        });
    });
</script>

</body>
</html>