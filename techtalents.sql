-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/07/2025 às 01:36
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `techtalents`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidatura`
--

CREATE TABLE `candidatura` (
  `id_candidatura` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `data_candidatura` datetime DEFAULT current_timestamp(),
  `status` enum('Em análise','Aprovado','Reprovado') DEFAULT 'Em análise'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidatura`
--

INSERT INTO `candidatura` (`id_candidatura`, `id_usuario`, `id_vaga`, `data_candidatura`, `status`) VALUES
(7, 11, 2, '2025-07-21 14:24:30', 'Aprovado'),
(10, 13, 4, '2025-07-23 12:44:20', 'Aprovado'),
(11, 11, 4, '2025-07-23 19:34:46', 'Reprovado'),
(12, 14, 4, '2025-07-24 14:48:46', 'Aprovado'),
(13, 11, 9, '2025-07-24 20:36:54', 'Em análise'),
(16, 17, 9, '2025-07-24 21:32:19', 'Aprovado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curriculo`
--

CREATE TABLE `curriculo` (
  `id_curriculo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(300) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `experiencia` text NOT NULL,
  `cursos` text NOT NULL,
  `escolaridade` varchar(30) NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `arquivo_curriculo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curriculo`
--

INSERT INTO `curriculo` (`id_curriculo`, `id_usuario`, `nome`, `endereco`, `experiencia`, `cursos`, `escolaridade`, `estado_civil`, `cpf`, `arquivo_curriculo`) VALUES
(12, 11, 'Eduarda Rocha Dias', 'Rua Força Pública', 'Desenvolvedora Front-End', 'Graduação em ADS', 'E.S comp', 'casado', '65467843201', 'curriculos/1753118660_curriculo.pdf'),
(13, 13, 'Rafaela Santos', 'Av. Emilio Ribas', 'Assistente Administrativo', 'Não possuo', 'E.S cur', 'casado', '67537262353723', 'curriculos/1753285456_Curriculo_Rafaela_Santos.pdf'),
(14, 14, 'Kaue Oliveira', 'Internacional Shopping', 'Eletricista na empresa ANEL', 'Curso de eletricista', 'E.M comp', 'divorciado', '66666666666666', 'curriculos/1753379236_Curriculo_Kaue_Oliveira.pdf'),
(17, 17, 'Cristina Araujo', 'Rua Manga', 'sem experiencia', 'informatica basico', 'E.M comp', 'solteiro', '1234567894', 'curriculos/1753403530_curriculo cristina.pdf');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nome`, `cnpj`, `email`, `senha`) VALUES
(1, 'TechTalents', '01020304050607', 'techtalents@gmail.com', 'tech202512');

-- --------------------------------------------------------

--
-- Estrutura para tabela `teste_realizado`
--

CREATE TABLE `teste_realizado` (
  `id_teste` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_realizacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `teste_realizado`
--

INSERT INTO `teste_realizado` (`id_teste`, `id_usuario`, `data_realizacao`) VALUES
(1, 11, '2025-07-22 00:44:36'),
(2, 13, '2025-07-23 12:36:56'),
(3, 14, '2025-07-24 14:48:31'),
(5, 17, '2025-07-24 21:33:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `data_nasc` date NOT NULL,
  `genero` varchar(20) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `celular`, `email`, `senha`, `data_nasc`, `genero`, `data_cadastro`) VALUES
(11, 'Eduarda Rocha Dias', '11999999999', 'eduarda@gmail.com', 'eduarda11', '2002-06-18', 'F', '2025-07-18 00:15:53'),
(12, 'Pedro Mendes', '11967035373', 'pedro.mendes@eniac.edu.br', '123456', '2025-11-21', 'M', '2025-07-18 22:49:09'),
(13, 'Rafaela Santos', '11976543678', 'rafaela@gmail.com', 'rafaela12', '2007-01-04', 'F', '2025-07-23 15:36:24'),
(14, 'Kaue Oliveira', '11999999999', 'kaue@gmail.com', 'kaue12', '1991-04-19', 'M', '2025-07-24 17:34:10'),
(17, 'Cristina Araujo', '11950205020', 'cristina@gmail.com', '123123', '2006-12-20', 'F', '2025-07-25 00:30:57');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vaga`
--

CREATE TABLE `vaga` (
  `id_vaga` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `nivel_experiencia` varchar(50) NOT NULL,
  `faixa_salarial` decimal(10,2) NOT NULL,
  `modalidade_trabalho` varchar(50) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `descricao_detalhada` text NOT NULL,
  `requisitos` text NOT NULL,
  `beneficios` text NOT NULL,
  `data_limite` date DEFAULT NULL,
  `numero_vagas` int(11) DEFAULT 1,
  `urgencia` enum('Normal','Alta') DEFAULT 'Normal',
  `data_criacao` datetime DEFAULT current_timestamp(),
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vaga`
--

INSERT INTO `vaga` (`id_vaga`, `titulo`, `categoria`, `nivel_experiencia`, `faixa_salarial`, `modalidade_trabalho`, `cidade`, `descricao_detalhada`, `requisitos`, `beneficios`, `data_limite`, `numero_vagas`, `urgencia`, `data_criacao`, `id_empresa`) VALUES
(2, 'Estágio Desenvolvedor JavaScript', 'desenvolvimento', 'estagio', 1200.00, 'presencial', 'São Paulo - SP', 'Estamos em busca de Desenvolvedor JS para fazer parte da nossa equipe de desenvolvimento. ', 'Javascript, React e React-native, Gerenciador de pacotes como Yarn, styled components, git flow.', 'á combinar', '2025-07-25', 5, 'Alta', '2025-07-18 01:09:15', 1),
(3, 'Assistente de Help Desk', 'suporte', 'estagio', 1000.00, 'presencial', 'Guaianases - SP', 'Suporte de infraestrutura e telefonia, além de atendimento à fila de chamados solicitados pela operação ou gestão direta.', 'Ensino médio completo, mínimo 6 meses de experiência na área de TI', 'Vale alimentação: R$ 30,00;\r\nVale-transporte (6% de desconto, caso utilize);\r\nSeguro de Vida;\r\nPlano de saúde.', '2025-07-21', 2, 'Normal', '2025-07-18 02:01:27', 1),
(4, 'Assistente de Marketing Digital', 'marketing', 'junior', 2000.00, 'hibrido', 'São Paulo - SP', 'Criará campanhas de marketing impactantes que conectem nossa marca ao público.\r\nDesenvolveremos conteúdos incríveis para nossas redes sociais, incluindo vídeos e fotos que engajamos.', 'Conhecimento em redes sociais e estratégias de marketing digital', 'á combinar', '2025-08-04', 2, 'Normal', '2025-07-18 02:42:27', 1),
(6, 'Vendedor de Loja', 'vendas', 'estagio', 1500.00, 'presencial', 'Guarulhos - SP', 'Realizar prospecção de novos clientes, atender e acompanhar clientes atuais.', 'Ensino médio completo.', 'Á combinar', '2025-07-22', 10, 'Normal', '2025-07-21 14:01:02', 1),
(9, 'Eletricista', 'operacoes', 'pleno', 2500.00, 'presencial', 'São Paulo - SP', 'INÍCIO IMEDIATO! Oportunidade em parceria com uma construtora de grande porte! ', 'Certificado de Eletricista, NR 10 e NR 35 atualizadas', 'Vale-transporte e Refeição no local', '2025-08-12', 5, 'Normal', '2025-07-24 15:12:30', 1),
(11, 'Desenvolvedor Front-End', 'desenvolvimento', 'estagio', 2000.00, 'presencial', 'Guararema', 'Estamos contratando Desenvolvedor Front End', 'Cursando ensino superior', 'á combinar', '2025-08-08', 2, 'Alta', '2025-07-25 18:17:07', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `candidatura`
--
ALTER TABLE `candidatura`
  ADD PRIMARY KEY (`id_candidatura`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_vaga` (`id_vaga`);

--
-- Índices de tabela `curriculo`
--
ALTER TABLE `curriculo`
  ADD PRIMARY KEY (`id_curriculo`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Índices de tabela `teste_realizado`
--
ALTER TABLE `teste_realizado`
  ADD PRIMARY KEY (`id_teste`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `celular_email` (`email`);

--
-- Índices de tabela `vaga`
--
ALTER TABLE `vaga`
  ADD PRIMARY KEY (`id_vaga`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `candidatura`
--
ALTER TABLE `candidatura`
  MODIFY `id_candidatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `curriculo`
--
ALTER TABLE `curriculo`
  MODIFY `id_curriculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `teste_realizado`
--
ALTER TABLE `teste_realizado`
  MODIFY `id_teste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `id_vaga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `candidatura`
--
ALTER TABLE `candidatura`
  ADD CONSTRAINT `candidatura_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `candidatura_ibfk_2` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id_vaga`);

--
-- Restrições para tabelas `teste_realizado`
--
ALTER TABLE `teste_realizado`
  ADD CONSTRAINT `teste_realizado_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `vaga`
--
ALTER TABLE `vaga`
  ADD CONSTRAINT `vaga_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
