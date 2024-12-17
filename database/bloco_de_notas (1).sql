-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11/12/2024 às 19:59
-- Versão do servidor: 8.0.36
-- Versão do PHP: 8.2.13

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
CREATE DATABASE IF NOT EXISTS `bloco_de_notas` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci;
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
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `conteudo` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_modificacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID_Usuario` int NOT NULL,
  `tamanho_fonte` int DEFAULT '14',
  `id_pasta` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_PASTA` (`id_pasta`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
CREATE TABLE IF NOT EXISTS `documentos_pasta` (
`conteudo` longtext
,`data_criacao` datetime
,`data_modificacao` datetime
,`id` int
,`id_pasta` int
,`ID_Usuario` int
,`tamanho_fonte` int
,`titulo` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_pasta`
--

DROP TABLE IF EXISTS `tb_pasta`;
CREATE TABLE IF NOT EXISTS `tb_pasta` (
  `id_pasta` int NOT NULL AUTO_INCREMENT,
  `pasta_nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `pasta_data_criacao` date NOT NULL,
  PRIMARY KEY (`id_pasta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `usuario_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `usuario_senha` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `usuario_tipo` enum('ADM','COLLAB') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `usuario_data_entrada` datetime NOT NULL,
  `usuario_ativo` tinyint(1) NOT NULL,
  `usuario_foto` longblob,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `usuario_nome`, `usuario_email`, `usuario_senha`, `usuario_tipo`, `usuario_data_entrada`, `usuario_ativo`, `usuario_foto`) VALUES
(2, 'Kauan', 'kauan@gmail.com', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'ADM', '2024-10-14 13:50:11', 1, NULL),
(9, 'Ronaldo', 'ronaldo2@gmail.com', '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'ADM', '2024-11-21 17:04:49', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `usuarios_ativos`
-- (Veja abaixo para a visão atual)
--
DROP VIEW IF EXISTS `usuarios_ativos`;
CREATE TABLE IF NOT EXISTS `usuarios_ativos` (
`id_usuario` int
,`usuario_ativo` tinyint(1)
,`usuario_data_entrada` datetime
,`usuario_email` varchar(255)
,`usuario_nome` varchar(255)
,`usuario_senha` varchar(255)
,`usuario_tipo` enum('ADM','COLLAB')
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_documento`
--

DROP TABLE IF EXISTS `usuario_documento`;
CREATE TABLE IF NOT EXISTS `usuario_documento` (
  `id_usuario_documento` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_documento` int DEFAULT NULL,
  PRIMARY KEY (`id_usuario_documento`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_documento` (`id_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para view `documentos_pasta`
--
DROP TABLE IF EXISTS `documentos_pasta`;

DROP VIEW IF EXISTS `documentos_pasta`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `documentos_pasta`  AS SELECT `documentos`.`id` AS `id`, `documentos`.`titulo` AS `titulo`, `documentos`.`conteudo` AS `conteudo`, `documentos`.`data_criacao` AS `data_criacao`, `documentos`.`data_modificacao` AS `data_modificacao`, `documentos`.`ID_Usuario` AS `ID_Usuario`, `documentos`.`tamanho_fonte` AS `tamanho_fonte`, `documentos`.`id_pasta` AS `id_pasta` FROM `documentos` WHERE ((`documentos`.`id_pasta` is null) OR (`documentos`.`id_pasta` = 0)) ORDER BY `documentos`.`titulo` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para view `usuarios_ativos`
--
DROP TABLE IF EXISTS `usuarios_ativos`;

DROP VIEW IF EXISTS `usuarios_ativos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_ativos`  AS SELECT `tb_usuario`.`id_usuario` AS `id_usuario`, `tb_usuario`.`usuario_nome` AS `usuario_nome`, `tb_usuario`.`usuario_email` AS `usuario_email`, `tb_usuario`.`usuario_senha` AS `usuario_senha`, `tb_usuario`.`usuario_tipo` AS `usuario_tipo`, `tb_usuario`.`usuario_data_entrada` AS `usuario_data_entrada`, `tb_usuario`.`usuario_ativo` AS `usuario_ativo` FROM `tb_usuario` WHERE (`tb_usuario`.`usuario_ativo` = 1) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;