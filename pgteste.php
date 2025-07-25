<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Técnico - Tech Talents</title>
    <link rel="stylesheet" href="css/pgteste.css">
    

</head>
<body>
  
    <header class="header">
        <div class="container">
           
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="vagas_user.php" class="nav-link" data-section="vagas">Vagas</a>
                    </li>

                </ul>
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    ☰
                </button>
            </nav>

           
            <div class="logo-container" onclick="goHome()">
                
                <img src="img/logo.png" alt="Tech Talents Logo" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                
               
                <span class="logo-text">TECH TALENTS</span>
            </div>

        </div>
    </header>

   
    <div class="test-container">
       
        <div class="progress-section">
            <div class="progress-info">
                <span class="progress-text">Progresso do Teste</span>
                <span class="progress-text" id="progressText">1 de 10 questões</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width: 10%"></div>
            </div>
        </div>

       
        <div class="question-nav">
            <div class="nav-title">Navegação das Questões</div>
            <div class="nav-buttons" id="questionNav">
              
            </div>
        </div>

        <!-- Question Card -->
        <div class="question-card" id="questionCard">
            <!-- Question content will be loaded by JavaScript -->
        </div>

        <!-- Navigation -->
        <div class="navigation">
            <button class="btn btn-secondary" id="prevBtn" onclick="previousQuestion()">
                <span>←</span> Anterior
            </button>
            <div>
                <button class="btn btn-primary" id="nextBtn" onclick="nextQuestion()">
                    Próxima <span>→</span>
                </button>
                <button class="btn btn-success" id="finishBtn" onclick="showFinishModal()" style="display: none;">
                    Finalizar Teste
                </button>
            </div>
        </div>
    </div>

    <form id="finalizarForm" action="registrar_teste.php" method="POST" style="display: none;">
    </form>




    <!-- Finish Modal -->
    <div class="modal" id="finishModal">
        <div class="modal-content">
            <h2 class="modal-title">Finalizar Teste?</h2>
            <p class="modal-text">
                Tem certeza que deseja finalizar o teste? Você respondeu <span id="answeredCount">0 de 5</span> questões.

                <br><br>
                Após finalizar, não será possível alterar suas respostas.
            </p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="closeFinishModal()">Cancelar</button>
                <button class="btn btn-success" onclick="finishTest()">Confirmar</button>

            </div>
        </div>
    </div>
    <script src="js/pgteste.js"></script>

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
