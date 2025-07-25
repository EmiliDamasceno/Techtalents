<?php

if (isset($_POST['submit'])) {
  include_once("conexao.php");

  $nome = $_POST['nome'];
  $celular = $_POST['celular'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $dia = $_POST['dia'];
  $mes = $_POST['mes'];
  $ano = $_POST['ano'];
  $genero = $_POST['genero'];

  $datanasc = "$ano-$mes-$dia";

  $result = mysqli_query($conexao, 
    "INSERT INTO usuario(nome, celular, email, senha, data_nasc, genero) 
     VALUES ('$nome', '$celular', '$email', '$senha', '$datanasc', '$genero')");

  if ($result) {
    echo "<script>alert('Cadastro realizado com sucesso.');</script>";
  } else {
    echo "<script>alert('Erro ao realizar o cadastro.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <link rel="stylesheet" href="css/cadastro.css">

  <style>
  .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 60px;
}

.nav-menu {
  display: flex;
  list-style: none;
  gap: 30px;
  align-items: center;
}

.nav-item {
  position: relative;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  padding: 8px 12px;
  border-radius: 4px;
  transition: all 0.3s ease;
  position: relative;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  transform: translateY(-1px);
}

.nav-link.active {
  background-color: rgba(255, 255, 255, 0.15);
}

<style>
  * {
     margin: 0;
            padding: 0;
            box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
 
}
 .header {
            width: 100%;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 50%, #374151 100%);
            padding: 12px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

          .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
        }

        /* Navigation Styles */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Logo Styles */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .auth-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

          .btn-login {
            background: transparent;
            color: white;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-register {
            background: white;
            color: #374151;
            border: 1.5px solid white;
        }

        .btn-register:hover {
            background: #f9fafb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }
         .logo-image {
                 width: 120px;
                 height: 80px;
                 border-radius: 50%;
                 object-fit: cover
            }
            



.form-container {
   background: linear-gradient( #9fa7b6 );
  max-width: 400px;
  margin: 40px auto;
  padding: 30px;
  border-radius: 8px;
  text-align: center;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: black;
  font-size: 30px;
}

form input[type="text"],
form input[type="email"],
form input[type="password"],
form select {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border-radius: 10px;
  border: 1px solid #999;
  outline: none;
}

.date-select {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
}

.date-select select {
  flex: 1;
}

.gender-options {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.gender-options label {
  background-color: #fff;
  padding: 5px 10px;
  border-radius: 10px;
  border: 1px solid #999;
  cursor: pointer;
}

.gender-options input[type="radio"] {
  margin-right: 5px;
}


button {
  width: 100%;
  padding: 12px;
  background-color: #495C7E;
  color: #fff;
  border: none;
  border-radius: 12px;
  font-weight: bold;
  cursor: pointer;
}

button:hover {
  background-color: #2e518e;
}

.logo{
  width: 120px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover
}

 .footer {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 50%, #374151 100%);
            color: white;
            padding: 60px 20px 20px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h4 {
            font-size: 16px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .footer-info {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
</style>

</style>
</head>

<body>

<header class="header">
        <div class="container">
         
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="vagas.php" class="nav-link" data-section="vagas">Vagas</a>
                    </li>
                </ul>
            </nav>               
                <img src="img/logo.png" alt="Tech Talents Logo" class="logo"/>
                


        </div>
</header>
 


  <main>
    <div class="form-container">
    <h2>CADASTRO</h2>
    <form id="form" action="cadastro.php" method="POST">
      <input name="nome" type="text" placeholder="Nome completo" required>
      <input name="celular" type="text" placeholder="Celular" required>
      <input name="email" type="email" placeholder="E-mail" required>
      <input name="senha" type="password" placeholder="Senha" required minlength="6">

      <label>Data de nascimento:</label>
      <div class="date-select">
        <select name="dia" id="dia" required>
          <option value="">Dia</option>
        </select>

        <select name="mes" id="mes" required>
          <option value="">Mês</option>
        </select>

        <select name="ano" id="ano" required>
          <option value="">Ano</option>
        </select>
        </div>

      <label>Gênero:</label>
      <div class="gender-options">
        <label><input type="radio" name="genero" value="F" required> Femenino</label>
        <label><input type="radio" name="genero" value="M"> Masculino</label>
        <label><input type="radio" name="genero" value="Outro"> Outro</label>
      </div>

      <button type="submit" name="submit">Cadastre-se</button>
    </form>
  </div>
  </main>
  
  <footer>
    <div class="footer-links">
      <div>
        <strong>Perfil</strong><br />
        Minhas Candidaturas<br />
        Currículo
      </div>
      <div>
        <strong>Recursos</strong><br />
        Vagas<br />
        Testes
      </div>
    </div>
    <img src="img/logo.png" alt="Tech Talents Logo" class="footer-logo"/>
    <p>&copy; 2025 Tech Talents. Todos os direitos reservados. | <a href="#">Política de Privacidade</a> | <a href="#">Termos de Serviço</a></p>
  </footer>

  <script>
    
    const selectDia = document.getElementById("dia");
    for (let i = 1; i <= 31; i++) {
      const option = document.createElement("option");
      option.value = i;
      option.textContent = i;
      selectDia.appendChild(option);
    }

   
    const selectMes = document.getElementById("mes");
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    meses.forEach((mes, index) => {
      const option = document.createElement("option");
      option.value = index + 1;
      option.textContent = mes;
      selectMes.appendChild(option);
    });

    
    const selectAno = document.getElementById("ano");
    for (let ano = 2025; ano >= 1900; ano--) {
      const option = document.createElement("option");
      option.value = ano;
      option.textContent = ano;
      selectAno.appendChild(option);
    }
  </script>


</body>
</html>