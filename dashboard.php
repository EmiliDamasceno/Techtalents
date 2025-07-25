<?php
session_start();
if (!isset($_SESSION['id_empresa'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Sistema de Vagas</title>
    <link rel="stylesheet" href="css/dashboard.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet" />
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <div class="container">
        <nav>
          <ul class="nav-menu" id="navMenu">
            <li class="nav-item">
              <a href="perfil_empresa.php" class="nav-link">Perfil</a>
            </li>
          </ul>
        </nav>

        <div class="logo-container" onclick="goHome()" role="button" tabindex="0" aria-label="Ir para a página inicial">
          <img src="img/logo.png" alt="Tech Talents Logo" class="logo-image"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
          <span class="logo-text">TECH TALENTS</span>
        </div>

        <form action="logout.php" method="post" class="form-logout">
          <button type="submit" class="btn_sair">Sair</button>
        </form>
      </div>
    </header>

    <div class="conteudo-dashboard">
      <!-- Dashboard Header -->
      <div class="dashboard">
        <div class="dashboard-content">
          <h1><i class="fas fa-chart-line"></i> Dashboard - Sistema de Vagas</h1>
          <button class="btn-primary" id="btnCadastrarVaga">
            <i class="fas fa-plus"></i> Cadastrar Nova Vaga
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <section class="stats-section">
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon vagas">
              <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalVagas"></h3>
              <p>Vagas Cadastradas</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon candidatos">
              <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalCandidatos"></h3>
              <p>Candidatos</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon testes">
              <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalTestes"></h3>
              <p>Testes Aplicados</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon aprovados">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalAprovados"></h3>
              <p>Aprovados</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Gráfico de Candidatos por Status -->
      <section class="charts-section">
        <div class="chart-container">
          <div class="chart-header">
            <h3>Candidatos por Status</h3>
          </div>
          <div class="donut-chart">
            <div class="donut-center">
              <div class="donut-total">QNT</div>
              <div class="donut-label">Total</div>
            </div>
            <div class="donut-segments">
              <div class="donut-segment" style="--percentage: 40; --color: #667eea">
                <span class="segment-label">Em Análise</span>
                <span id="statusEmAndamento" class="segment-value">QNT</span>
              </div>
              <div class="donut-segment" style="--percentage: 22; --color: #43e97b">
                <span class="segment-label">Aprovados</span>
                <span id="statusAprovado" class="segment-value">QNT</span>
              </div>
              <div class="donut-segment" style="--percentage: 18; --color: #f5576c">
                <span class="segment-label">Reprovados</span>
                <span id="statusReprovado" class="segment-value">QNT</span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>


    <!-- Modal Cadastro de Vaga -->
    <div class="modal-overlay" id="modalOverlay">
      <div class="modal">
        <div class="modal-header">
          <h2><i class="fas fa-briefcase"></i> Cadastrar Nova Vaga</h2>
          <button class="btn-close" id="btnFecharModal">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <form class="modal-form" id="formCadastroVaga" method="POST" action="cadastrar_vaga.php">

          <!-- Seção: Informações Básicas -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-info-circle"></i>
              Informações Básicas
            </h3>

            <div class="form-row">
              <div class="form-group">
                <label for="tituloVaga">
                  Título da Vaga
                  <span class="required">*</span>
                </label>
                <input
                  type="text"
                  id="tituloVaga"
                  name="titulo"
                  required
                  placeholder="Ex: Desenvolvedor Frontend React"
                />
              </div>
              <div class="form-group">
                <label for="categoriaVaga">
                  Categoria
                  <span class="required">*</span>
                </label>
                <select id="categoriaVaga" name="categoria" required>
                  <option value="">Selecione uma categoria</option>
                  <option value="desenvolvimento">💻 Desenvolvimento</option>
                  <option value="design">🎨 Design</option>
                  <option value="marketing">📢 Marketing</option>
                  <option value="vendas">💼 Vendas</option>
                  <option value="rh">👥 Recursos Humanos</option>
                  <option value="financeiro">💰 Financeiro</option>
                  <option value="operacoes">⚙️ Operações</option>
                  <option value="suporte">🎧 Suporte</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="nivelVaga">
                  Nível de Experiência
                  <span class="required">*</span>
                </label>
                <select id="nivelVaga" name="nivel_experiencia" required>
                  <option value="">Selecione o nível</option>
                  <option value="estagio">🌱 Estágio</option>
                  <option value="junior">🚀 Júnior (0-2 anos)</option>
                  <option value="pleno">⭐ Pleno (2-5 anos)</option>
                  <option value="senior">🏆 Sênior (5+ anos)</option>
                  <option value="especialista">💎 Especialista</option>
                  <option value="lider">👑 Liderança</option>
                </select>
              </div>
              <div class="form-group">
                <label for="salarioVaga">Faixa Salarial (R$)</label>
                <input
                  type="number"
                  id="salarioVaga"
                  name="faixa_salarial"
                  min="0"
                  step="100"
                  placeholder="Ex: 5000" required
                />
              </div>
            </div>
          </div>

          <!-- Seção: Localização e Modalidade -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-map-marker-alt"></i>
              Localização e Modalidade
            </h3>

            <div class="form-row">
              <div class="form-group">
                <label for="localVaga">
                  Modalidade de Trabalho
                  <span class="required">*</span>
                </label>
                <select id="localVaga" name="modalidade_trabalho" required>
                  <option value="">Selecione a modalidade</option>
                  <option value="presencial">🏢 Presencial</option>
                  <option value="remoto">🏠 Remoto</option>
                  <option value="hibrido">🔄 Híbrido</option>
                </select>
              </div>
              <div class="form-group">
                <label for="cidadeVaga">Cidade</label>
                <input
                  type="text"
                  id="cidadeVaga"
                  name="cidade"
                  placeholder="Ex: São Paulo, SP" required
                />
              </div>
            </div>
          </div>

          <!-- Seção: Descrição da Vaga -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-file-alt"></i>
              Descrição da Vaga
            </h3>

            <div class="form-group full-width">
              <label for="descricaoVaga">
                Descrição Detalhada
                <span class="required">*</span>
              </label>
              <textarea id="descricaoVaga" name="descricao_detalhada" rows="5" required></textarea>

            </div>

            <div class="form-group full-width">
              <label for="requisitosVaga">Requisitos e Qualificações</label>
              <textarea
                id="requisitosVaga"
                name="requisitos"
                rows="4"
                placeholder="Liste os requisitos técnicos, experiências necessárias, formação, certificações, etc..."
              ></textarea>
              
            </div>

            <div class="form-group full-width">
              <label for="beneficiosVaga">Benefícios Oferecidos</label>
              <textarea
                id="beneficiosVaga"
                name="beneficios"
                rows="3"
                placeholder="Ex: Vale alimentação, plano de saúde, home office, horário flexível..."
              ></textarea>
            </div>
          </div>

          <!-- Seção: Configurações -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-cog"></i>
              Configurações da Vaga
            </h3>

            <div class="form-row">
              <div class="form-group">
                <label for="dataLimite">Data Limite para Candidatura</label>
                <input type="date" id="dataLimite" name="data_limite" />

              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="vagasDisponiveis">Número de Vagas</label>
                <input type="number" id="vagasDisponiveis" name="numero_vagas" min="1" value="1" placeholder="Quantas vagas disponíveis?">

              </div>
              <div class="form-group">
                <label for="urgenciaVaga">Urgência</label>
                <select id="urgenciaVaga" name="urgencia">
                     <option value="Normal">🟢 Normal</option>
                     <option value="Alta">🔴 Alta</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn-secondary" id="btnCancelar">
              <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="submit" class="btn-primary" id="btnSalvarVaga">
              <i class="fas fa-save"></i> Cadastrar Vaga
            </button>
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

    <script src="js/dashboard.js"></script>

  </body>
</html>
