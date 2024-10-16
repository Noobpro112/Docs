-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/10/2024 às 16:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bloco_de_notas`
--
CREATE DATABASE IF NOT EXISTS `bloco_de_notas` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `bloco_de_notas`;

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `cadastrar_usuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_usuario` (IN `nome_usuario` VARCHAR(255), IN `email_usuario` VARCHAR(255), IN `senha_usuario` VARCHAR(255), IN `tipo_usuario` ENUM('ADM','COLLAB'), IN `data_entrada` DATETIME, OUT `Confirmacao` BOOLEAN)   BEGIN
-- Declarar uma variável local e temporária durante o processamento dessa procedure
DECLARE rows_count INT;

-- Procurar na tabela usuários para ver se o email digitado já está sendo usado
SELECT COUNT(*) INTO rows_count FROM tb_usuario WHERE usuario_email = email_usuario AND usuario_ativo = 1;

-- Bloco IF para caso o Email já esteja sendo usado || Bloco ELSE para Inserir usuário
IF rows_count > 0 THEN
	SET Confirmacao = FALSE;
ELSE
	INSERT INTO tb_usuario (usuario_nome, usuario_email, usuario_senha, usuario_tipo, usuario_data_entrada, usuario_ativo)
    VALUES (nome_usuario, email_usuario, senha_usuario, tipo_usuario, data_entrada, 1);
    SET Confirmacao = TRUE;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `documentos`
--

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` longtext DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `data_modificacao` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_Usuario` int(11) NOT NULL,
  `tamanho_fonte` int(11) DEFAULT 14
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario_nome` varchar(255) NOT NULL,
  `usuario_email` varchar(255) NOT NULL,
  `usuario_senha` varchar(255) NOT NULL,
  `usuario_tipo` enum('ADM','COLLAB') NOT NULL,
  `usuario_data_entrada` datetime NOT NULL,
  `usuario_ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `usuario_nome`, `usuario_email`, `usuario_senha`, `usuario_tipo`, `usuario_data_entrada`, `usuario_ativo`) VALUES
(1, 'Kauan', 'kauan@gmail.com', 'kauan_007', 'ADM', '2024-10-08 17:30:00', 1),
(9, 'Ronaldo', 'ronaldo@gmail.com', '1234', 'ADM', '2024-10-14 22:23:39', 1),
(13, 'Luiz', 'luiz@gmail', '1234', 'ADM', '2024-10-15 19:32:53', 1);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `usuarios_ativos`
-- (Veja abaixo para a visão atual)
--
DROP VIEW IF EXISTS `usuarios_ativos`;
CREATE TABLE `usuarios_ativos` (
`id_usuario` int(11)
,`usuario_nome` varchar(255)
,`usuario_email` varchar(255)
,`usuario_senha` varchar(255)
,`usuario_tipo` enum('ADM','COLLAB')
,`usuario_data_entrada` datetime
,`usuario_ativo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_documento`
--

DROP TABLE IF EXISTS `usuario_documento`;
CREATE TABLE `usuario_documento` (
  `id_usuario_documento` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_documento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para view `usuarios_ativos`
--
DROP TABLE IF EXISTS `usuarios_ativos`;

DROP VIEW IF EXISTS `usuarios_ativos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_ativos`  AS SELECT `tb_usuario`.`id_usuario` AS `id_usuario`, `tb_usuario`.`usuario_nome` AS `usuario_nome`, `tb_usuario`.`usuario_email` AS `usuario_email`, `tb_usuario`.`usuario_senha` AS `usuario_senha`, `tb_usuario`.`usuario_tipo` AS `usuario_tipo`, `tb_usuario`.`usuario_data_entrada` AS `usuario_data_entrada`, `tb_usuario`.`usuario_ativo` AS `usuario_ativo` FROM `tb_usuario` WHERE `tb_usuario`.`usuario_ativo` = 1 ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices de tabela `usuario_documento`
--
ALTER TABLE `usuario_documento`
  ADD PRIMARY KEY (`id_usuario_documento`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_documento` (`id_documento`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuario_documento`
--
ALTER TABLE `usuario_documento`
  MODIFY `id_usuario_documento` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
