-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12/10/2024 às 08:44
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `documentos`
--

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE IF NOT EXISTS `documentos` (
                                            `id` int NOT NULL AUTO_INCREMENT,
                                            `titulo` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                                            `conteudo` text COLLATE utf8mb3_unicode_ci NOT NULL,
                                            `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
                                            `data_modificacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            `ID_Usuario` int NOT NULL,
                                            `tamanho_fonte` int DEFAULT '14',
                                            PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `documentos`
--

INSERT INTO `documentos` (`id`, `titulo`, `conteudo`, `data_criacao`, `data_modificacao`, `ID_Usuario`, `tamanho_fonte`) VALUES
    (1, 'Documento Sem Titulo', '<b><i>\n        \n        \n        teste é foda</i></b>', '2024-10-12 05:17:11', '2024-10-12 05:32:14', 1, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_documento`
--

DROP TABLE IF EXISTS `tb_documento`;
CREATE TABLE IF NOT EXISTS `tb_documento` (
                                              `id_documento` int NOT NULL AUTO_INCREMENT,
                                              `documento_titulo` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
                                              `documento_conteudo` text COLLATE utf8mb3_unicode_ci,
                                              `documento_data_criacao` datetime NOT NULL,
                                              `documento_data_atualizacao` datetime DEFAULT NULL,
                                              PRIMARY KEY (`id_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
                                            `id_usuario` int NOT NULL AUTO_INCREMENT,
                                            `usuario_nome` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                                            `usuario_email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                                            `usuario_senha` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                                            `usuario_tipo` enum('ADM','COLLAB') COLLATE utf8mb3_unicode_ci NOT NULL,
                                            `usuario_data_entrada` datetime NOT NULL,
                                            `usuario_ativo` tinyint(1) NOT NULL,
                                            PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `usuario_nome`, `usuario_email`, `usuario_senha`, `usuario_tipo`, `usuario_data_entrada`, `usuario_ativo`) VALUES
    (1, 'Kauan', 'kauan@gmail.com', '1234', 'ADM', '2024-10-08 17:30:00', 1);

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

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `usuario_documento`
--
ALTER TABLE `usuario_documento`
    ADD CONSTRAINT `usuario_documento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
    ADD CONSTRAINT `usuario_documento_ibfk_2` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento` (`id_documento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
