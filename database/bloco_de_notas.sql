-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 21/11/2024 às 21:14
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_usuario` (IN `nome_usuario_digitado` VARCHAR(255), IN `email_usuario_digitado` VARCHAR(255), IN `senha_usuario_digitada` VARCHAR(255), IN `tipo_usuario_digitado` ENUM('ADM','COLLAB'), IN `data_entrada_usuario` DATETIME, OUT `Confirmacao` BOOLEAN)   BEGIN
    DECLARE linhas INT;

    SELECT COUNT(*) INTO linhas 
    FROM tb_usuario 
    WHERE usuario_email = email_usuario_digitado;

    IF linhas > 0 THEN
        SET Confirmacao = FALSE;
    ELSE
        INSERT INTO tb_usuario (
            usuario_nome, usuario_email, usuario_senha, usuario_tipo, usuario_data_entrada, usuario_ativo
        ) VALUES (
            nome_usuario_digitado, 
            email_usuario_digitado, 
            SHA2(senha_usuario_digitada, 256), 
            tipo_usuario_digitado, 
            data_entrada_usuario, 
            1
        );
        
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
  `tamanho_fonte` int(11) DEFAULT 14,
  `id_pasta` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `documentos`
--

INSERT INTO `documentos` (`id`, `titulo`, `conteudo`, `data_criacao`, `data_modificacao`, `ID_Usuario`, `tamanho_fonte`, `id_pasta`) VALUES
(1, 'ronaldinho', '\n        \n        <i style=\"\"><b>TESTE</b><br><br><br><b style=\"\">JanuARIO <strike>MEU</strike> AMIG</b><u>O</u></i>        ', '2024-10-12 05:17:11', '2024-10-24 21:00:10', 1, 14, 5),
(2, 'yan', '\n        <div style=\"text-align: center;\">teste</div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\">teste</div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div>    ', '2024-10-12 09:05:42', '2024-10-16 07:58:26', 1, 16, 0),
(5, 'Documento Sem Titulo', '\n        \n        <font color=\"#ff0000\">\n        Digite Aqui...    </font>        ', '2024-10-14 14:12:52', '2024-10-16 07:58:46', 1, 14, 0),
(3, 'Documento Sem Titulo', '\n        Digite Aqui...    ', '2024-10-12 09:06:52', '2024-10-16 07:58:45', 1, 14, 0),
(4, 'Documento Sem Titulo', '\n        \n        \n        \n        Digite&nbsp;            ', '2024-10-14 14:02:03', '2024-10-16 07:58:44', 1, 14, 0),
(10, 'Documento Sem Titulo', 'Digite Aqui...', '2024-10-22 20:37:40', '2024-10-22 20:37:40', 1, 14, NULL),
(9, 'Documento Sem Titulo', 'Digite Aqui...', '2024-10-22 20:19:12', '2024-10-22 20:19:12', 1, 14, NULL),
(8, 'adsadasd', '\n        adasdasdasdasdas<div><br></div>', '2024-10-22 18:32:48', '2024-10-23 19:55:45', 1, 14, 4),
(11, 'Documento Sem Titulo', 'Digite Aqui...', '2024-10-22 21:05:17', '2024-10-22 21:05:17', 1, 14, NULL),
(12, 'Documento Sem Titulo', 'Digite Aqui...', '2024-11-20 13:48:05', '2024-11-20 13:48:05', 1, 14, NULL);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `documentos_pasta`
-- (Veja abaixo para a visão atual)
--
DROP VIEW IF EXISTS `documentos_pasta`;
CREATE TABLE `documentos_pasta` (
`id` int(11)
,`titulo` varchar(255)
,`conteudo` longtext
,`data_criacao` datetime
,`data_modificacao` datetime
,`ID_Usuario` int(11)
,`tamanho_fonte` int(11)
,`id_pasta` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_pasta`
--

DROP TABLE IF EXISTS `tb_pasta`;
CREATE TABLE `tb_pasta` (
  `id_pasta` int(11) NOT NULL,
  `pasta_nome` varchar(255) NOT NULL,
  `pasta_data_criacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tb_pasta`
--

INSERT INTO `tb_pasta` (`id_pasta`, `pasta_nome`, `pasta_data_criacao`) VALUES
(4, 'Mercado Financeiro', '2024-10-23'),
(5, 'Mercado Financeir', '2024-10-24');

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
(1, 'Kauan', 'kauan@gmail.com', '8007c68d8718fa840f80bfe69792dd72cfe5534e538c1dda36b6d073cf68122c', 'ADM', '2024-10-08 17:30:00', 1),
(2, 'Matheus', 'matheus@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'COLLAB', '2024-10-14 13:50:11', 0),
(9, 'Ronaldo', 'ronaldo2@gmail.com', '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'ADM', '2024-11-21 17:04:49', 0);

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
-- Estrutura para view `documentos_pasta`
--
DROP TABLE IF EXISTS `documentos_pasta`;

DROP VIEW IF EXISTS `documentos_pasta`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `documentos_pasta`  AS SELECT `documentos`.`id` AS `id`, `documentos`.`titulo` AS `titulo`, `documentos`.`conteudo` AS `conteudo`, `documentos`.`data_criacao` AS `data_criacao`, `documentos`.`data_modificacao` AS `data_modificacao`, `documentos`.`ID_Usuario` AS `ID_Usuario`, `documentos`.`tamanho_fonte` AS `tamanho_fonte`, `documentos`.`id_pasta` AS `id_pasta` FROM `documentos` WHERE `documentos`.`id_pasta` is null OR `documentos`.`id_pasta` = 0 ORDER BY `documentos`.`titulo` ASC ;

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_PASTA` (`id_pasta`);

--
-- Índices de tabela `tb_pasta`
--
ALTER TABLE `tb_pasta`
  ADD PRIMARY KEY (`id_pasta`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tb_pasta`
--
ALTER TABLE `tb_pasta`
  MODIFY `id_pasta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
