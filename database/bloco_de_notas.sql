-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 16/10/2024 às 10:59
-- Versão do servidor: 8.0.36
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
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
CREATE
    DEFINER = `root`@`localhost` PROCEDURE `cadastrar_usuario`(IN `nome_usuario` VARCHAR(255),
                                                               IN `email_usuario` VARCHAR(255),
                                                               IN `senha_usuario` VARCHAR(255),
                                                               IN `tipo_usuario` ENUM ('ADM','COLLAB'),
                                                               IN `data_entrada` DATETIME, OUT `Confirmacao` BOOLEAN)
BEGIN
    -- Declarar uma variável local e temporária durante o processamento dessa procedure
    DECLARE rows_count INT;

-- Procurar na tabela usuários para ver se o email digitado já está sendo usado
    SELECT COUNT(*) INTO rows_count FROM tb_usuario WHERE usuario_email = email_usuario AND usuario_ativo = 1;

-- Bloco IF para caso o Email já esteja sendo usado || Bloco ELSE para Inserir usuário
    IF rows_count > 0 THEN
        SET Confirmacao = FALSE;
    ELSE
        INSERT INTO tb_usuario (usuario_nome, usuario_email, usuario_senha, usuario_tipo, usuario_data_entrada,
                                usuario_ativo)
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
CREATE TABLE IF NOT EXISTS `documentos`
(
    `id`               int                                                           NOT NULL AUTO_INCREMENT,
    `titulo`           varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
    `conteudo`         longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
    `data_criacao`     datetime DEFAULT CURRENT_TIMESTAMP,
    `data_modificacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `ID_Usuario`       int                                                           NOT NULL,
    `tamanho_fonte`    int      DEFAULT '14',
    PRIMARY KEY (`id`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8mb3
  COLLATE = utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `documentos`
--

INSERT INTO `documentos` (`id`, `titulo`, `conteudo`, `data_criacao`, `data_modificacao`, `ID_Usuario`, `tamanho_fonte`)
VALUES (1, 'ronaldinho',
        '\n        \n        <i style=\"\"><b>TESTE</b><br><br><br><b style=\"\">JanuARIO <strike>MEU</strike> AMIG</b><u>O</u></i>        ',
        '2024-10-12 05:17:11', '2024-10-16 07:58:36', 1, 14),
       (2, 'yan',
        '\n        <div style=\"text-align: center;\">teste</div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\">teste</div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div><div style=\"text-align: center;\"><br></div>    ',
        '2024-10-12 09:05:42', '2024-10-16 07:58:26', 1, 16),
       (5, 'Documento Sem Titulo',
        '\n        \n        <font color=\"#ff0000\">\n        Digite Aqui...    </font>        ',
        '2024-10-14 14:12:52', '2024-10-16 07:58:46', 1, 14),
       (3, 'Documento Sem Titulo', '\n        Digite Aqui...    ', '2024-10-12 09:06:52', '2024-10-16 07:58:45', 1, 14),
       (4, 'Documento Sem Titulo', '\n        \n        \n        \n        Digite&nbsp;            ',
        '2024-10-14 14:02:03', '2024-10-16 07:58:44', 1, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--


--


DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario`
(
    `id_usuario`           int                                                                    NOT NULL AUTO_INCREMENT,
    `usuario_nome`         varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci          NOT NULL,
    `usuario_email`        varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci          NOT NULL,
    `usuario_senha`        varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci          NOT NULL,
    `usuario_tipo`         enum ('ADM','COLLAB') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
    `usuario_data_entrada` datetime                                                               NOT NULL,
    `usuario_ativo`        tinyint(1)                                                             NOT NULL,
    PRIMARY KEY (`id_usuario`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb3
  COLLATE = utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `usuario_nome`, `usuario_email`, `usuario_senha`, `usuario_tipo`,
                          `usuario_data_entrada`, `usuario_ativo`)
VALUES (1, 'Kauan', 'kauan@gmail.com', 'kauan_007', 'ADM', '2024-10-08 17:30:00', 1),
       (2, 'Matheus', 'matheus@gmail.com', '1234', 'COLLAB', '2024-10-14 13:50:11', 1);

-- --------------------------------------------------------
DROP VIEW IF EXISTS `usuarios_ativos`;
CREATE TABLE `usuarios_ativos`
(
    `id_usuario`           int(11),
    `usuario_nome`         varchar(255),
    `usuario_email`        varchar(255),
    `usuario_senha`        varchar(255),
    `usuario_tipo`         enum ('ADM','COLLAB'),
    `usuario_data_entrada` datetime,
    `usuario_ativo`        tinyint(1)
);

DROP TABLE IF EXISTS `usuarios_ativos`;

DROP VIEW IF EXISTS `usuarios_ativos`;
CREATE ALGORITHM = UNDEFINED DEFINER =`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_ativos` AS
SELECT `tb_usuario`.`id_usuario`           AS `id_usuario`,
       `tb_usuario`.`usuario_nome`         AS `usuario_nome`,
       `tb_usuario`.`usuario_email`        AS `usuario_email`,
       `tb_usuario`.`usuario_senha`        AS `usuario_senha`,
       `tb_usuario`.`usuario_tipo`         AS `usuario_tipo`,
       `tb_usuario`.`usuario_data_entrada` AS `usuario_data_entrada`,
       `tb_usuario`.`usuario_ativo`        AS `usuario_ativo`
FROM `tb_usuario`
WHERE `tb_usuario`.`usuario_ativo` = 1;
--
-- Estrutura para tabela `usuario_documento`
--

DROP TABLE IF EXISTS `usuario_documento`;
CREATE TABLE IF NOT EXISTS `usuario_documento`
(
    `id_usuario_documento` int NOT NULL AUTO_INCREMENT,
    `id_usuario`           int DEFAULT NULL,
    `id_documento`         int DEFAULT NULL,
    PRIMARY KEY (`id_usuario_documento`),
    KEY `id_usuario` (`id_usuario`),
    KEY `id_documento` (`id_documento`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb3
  COLLATE = utf8mb3_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
