-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Dez-2022 às 16:29
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `parceriaanimal`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `animal`
--

CREATE TABLE `animal` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Telefone_dono` varchar(255) NOT NULL,
  `Email_dono` varchar(255) NOT NULL,
  `Data_nas` date NOT NULL,
  `Descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `animal`
--

INSERT INTO `animal` (`Id`, `Nome`, `Telefone_dono`, `Email_dono`, `Data_nas`, `Descricao`) VALUES
(1, 'Bummer', '(16)99378-6843', 'valeriasartorio3@gmail.com', '2019-03-25', 'muito medroso e assustado'),
(4, 'Toquinho', '(16)99378-6843', 'milton@gmail.com', '2022-10-01', 'medroso'),
(5, 'Meg', '(16)98805-5419', 'vaasart445@gmail.com', '2017-12-01', 'muito amigavel e agitada'),
(7, 'Princesa', '(16)98805-5419', 'ze@gmail.com', '2016-09-05', 'muito amigavel e agitada'),
(8, 'Laika', '(16)98805-5419', 'valeria@gmail.com', '1999-11-02', 'muito fofa e tranquila');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consulta`
--

CREATE TABLE `consulta` (
  `Id_Veterinario` int(11) NOT NULL,
  `Id_Animal` int(11) NOT NULL,
  `Data` date NOT NULL,
  `Hora` time NOT NULL,
  `Tipo` varchar(255) NOT NULL,
  `Custo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consulta`
--

INSERT INTO `consulta` (`Id_Veterinario`, `Id_Animal`, `Data`, `Hora`, `Tipo`, `Custo`) VALUES
(1, 1, '2022-12-05', '14:00:00', 'diagnostica', 20),
(8, 4, '2022-01-06', '15:00:00', 'diagnostica', 20),
(8, 4, '2022-12-06', '15:00:00', 'diagnostica', 20),
(8, 7, '2022-12-20', '15:00:00', 'diagnostica', 20),
(8, 8, '2022-12-20', '09:00:00', 'diagnostica', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `veterinario`
--

CREATE TABLE `veterinario` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Telefone` varchar(255) NOT NULL,
  `Senha` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `veterinario`
--

INSERT INTO `veterinario` (`Id`, `Nome`, `Email`, `Telefone`, `Senha`) VALUES
(1, 'Mariana', 'mariana.montilha@gmail.com', '(16)99222-4444', '$2y$10$oUajuSreIrSbuzpZkjIQe.srJY90eluXtfUdPBMkFMetEQ/l3Morq'),
(4, 'Ana Clara', 'anaclara_linda@gmail.com', '(16)99999-9999', '$2y$10$FDS3lmUwLRMwnNXaNMUUR.qXHKyykLG2.3b3XOQxnYpa3GFZPJQbK'),
(6, 'Jubiscleu', 'jubiscleu@gmail.com', '(19)88888-7777', '$2y$10$oeGrMGdyoWufgXcgzJ98ee57E5DVLheCTVWNC0vTcy8/.8sZjq22W'),
(8, 'Valéria', 'valeriasartorio3@gmail.com', '(16)99378-6843', '$2y$10$r7WEXfU2Dc7t45e26BR0l.PdoY.btU5w7OVxoIOFjpZTnMnIcoCdC');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`Id_Veterinario`,`Id_Animal`,`Data`,`Hora`),
  ADD KEY `Id_Animal` (`Id_Animal`);

--
-- Índices para tabela `veterinario`
--
ALTER TABLE `veterinario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `animal`
--
ALTER TABLE `animal`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `veterinario`
--
ALTER TABLE `veterinario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`Id_Veterinario`) REFERENCES `veterinario` (`Id`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`Id_Animal`) REFERENCES `animal` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
