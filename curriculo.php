<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.html');
    exit();
}
include 'conexao.php';

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $conexao->real_escape_string($_POST['nomeCompleto']);
    $cpf = $conexao->real_escape_string($_POST['cpf']);
    $endereco = $conexao->real_escape_string($_POST['endereco']);
    $estadoCivil = $conexao->real_escape_string($_POST['estadoCivil']);
    $experiencia = $conexao->real_escape_string($_POST['experiencia']);
    $escolaridade = $conexao->real_escape_string($_POST['escolaridade']);
    $cursos = $conexao->real_escape_string($_POST['cursos']);

    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] === 0) {
        $nomeArquivo = basename($_FILES['curriculo']['name']);
        $diretorioDestino = 'curriculos/';
        $caminhoCompleto = $diretorioDestino . time() . "_" . $nomeArquivo;

        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true);
        }

        if (move_uploaded_file($_FILES['curriculo']['tmp_name'], $caminhoCompleto)) {
            $id_usuario = $_SESSION['id_usuario']; // já está na sessão

            $sql = "INSERT INTO curriculo (id_usuario, nome, endereco, experiencia, cursos, escolaridade, estado_civil, cpf, arquivo_curriculo)
                VALUES ('$id_usuario', '$nome', '$endereco', '$experiencia', '$cursos', '$escolaridade', '$estadoCivil', '$cpf', '$caminhoCompleto')";

            if ($conexao->query($sql) === TRUE) {
                $mensagem = "<p style='color:green;'>Currículo enviado com sucesso!</p>";
            } else {
                $mensagem = "<p style='color:red;'>Erro ao salvar no banco de dados: {$conexao->error}</p>";
            }
        } else {
            $mensagem = "<p style='color:red;'>Erro ao salvar o arquivo no servidor.</p>";
        }
    } else {
        $mensagem = "<p style='color:red;'>Erro no envio do arquivo.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Currículo - Tech Talents</title>
    <link rel="stylesheet" href="css/curriculo.css">
    <script src="js/curriculo.js"></script>
</head>
<body>
    <!-- Header -->
<header class="header">
    <div class="container">
        <!-- Navigation Menu -->
        <nav>
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="vagas_user.php" class="nav-link" data-section="vagas">Vagas</a>
                </li>
                <li class="nav-item">
                    <a href="pgteste.php" class="nav-link" data-section="testes">Testes</a>
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
        
       
    </div>
</header>

    <!-- Main Content -->
    <div class="main-container">
        <div class="form-container">
            <h1 class="form-title">Cadastro de Currículo</h1>
            <?php if (!empty($mensagem)) echo $mensagem; ?>
            
            <form id="curriculumForm" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nomeCompleto">Nome completo</label>
                        <input type="text" id="nomeCompleto" name="nomeCompleto" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="000.000.000-00" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="estadoCivil">Estado Civil</label>
                        <select id="estadoCivil" name="estadoCivil" required>
                            <option value="">Selecione...</option>
                            <option value="solteiro">Solteiro(a)</option>
                            <option value="casado">Casado(a)</option>
                            <option value="divorciado">Divorciado(a)</option>
                            <option value="viuvo">Viúvo(a)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="experiencia">Experiência</label>
                        <textarea id="experiencia" name="experiencia" placeholder="Descreva sua experiência profissional..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="escolaridade">Escolaridade</label>
                        <select id="escolaridade" name="escolaridade" required>

                        <option value="">Selecione...</option>
                            <option value="E.M inc">Ensino Médio incompleto</option>
                            <option value="E.M comp">Ensino Médio completo</option>
                            <option value="E.S inc">Ensino Superior incompleto</option>
                            <option value="E.S cur">Ensino Superior Cursando</option>  
                             <option value="E.S comp">Ensino Superior Completo</option> 
                        </select>  
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="cursos">Cursos</label>
                        <textarea id="cursos" name="cursos" placeholder="Liste seus cursos e certificações..."></textarea>
                    </div>
                </div>
                
                <!-- File Upload Section -->
                <div class="file-upload-section">
                    <label class="file-upload-label">Anexe seu currículo</label>
                    <div class="file-upload-container">
                        <button type="button" class="file-upload-btn" onclick="document.getElementById('curriculo').click()">
                            escolher arquivo
                        </button>
                        <input type="file" id="curriculo" name="curriculo" class="file-input" accept=".pdf,.doc,.docx" onchange="updateFileName(this)">
                    </div>
                    <div id="fileName" class="file-name"></div>
                </div>
                
                <!-- Submit Button -->
                <div class="submit-container">
                    <button type="submit" class="submit-btn">Enviar dados</button>
                </div>
            </form>
        </div>
    </div>
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