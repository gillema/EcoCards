-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/06/2025 às 07:57
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
-- Banco de dados: `ecocards`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `assinatura`
--

CREATE TABLE `assinatura` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `plano` enum('basico','premium','deluxe') NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `status` enum('ativo','cancelado','suspenso') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `assinatura`
--

INSERT INTO `assinatura` (`id`, `usuario_id`, `plano`, `data_inicio`, `data_fim`, `status`) VALUES
(1, 1, 'basico', '2025-06-06', '2025-07-06', 'ativo'),
(2, 1, 'premium', '2025-06-06', '2025-07-06', 'ativo'),
(3, 1, 'deluxe', '2025-06-06', '2025-07-06', 'ativo'),
(4, 1, 'basico', '2025-06-06', '2025-07-06', 'ativo'),
(5, 1, 'deluxe', '2025-06-06', '2025-07-06', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`id`, `nome`, `email`, `senha`, `telefone`) VALUES
(1, 'Giullyano Enzo da Cunha Marques', 'giullyanoenzo@gmail.com', '$2y$10$AWMKK82n862O9oFL6t5PDe129OTYzEwNCOMtnEJ2G5/FDEvfd5cfO', '91992474057'),
(2, 'João Pedro', 'jp@gmail.com', '$2y$10$uP11uWBki5xfvIJfXlGaauSWLms42.drDGN2huvKHq6M5ZF57m3zO', '11111111111'),
(3, 'Erica Silva Carvalho', 'ericakawaiiproprey@gmail.com', '$2y$10$gnqyeUNsBvSNvYVM1jZJj.H4s4le0sK/1iFFl6/Pnxv6qt00Y29lO', '98970699665'),
(4, 'felipe', 'fk@gmail.com', '$2y$10$t6QXEhcG4.PxIb4TPsTwsuYVyg/q6.XfuLs7AgOArmNCQNBxriOye', '99999999999');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `assinatura`
--
ALTER TABLE `assinatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gmail` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assinatura`
--
ALTER TABLE `assinatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `assinatura`
--
ALTER TABLE `assinatura`
  ADD CONSTRAINT `assinatura_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `cadastro` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
