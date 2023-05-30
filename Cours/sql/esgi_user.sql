-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3309
-- Généré le : dim. 07 mai 2023 à 23:51
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_web_1a2`
--

-- --------------------------------------------------------

--
-- Structure de la table `esgi_user`
--

CREATE TABLE `esgi_user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(120) NOT NULL,
  `email` varchar(320) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `country` char(2) NOT NULL,
  `birthday` date NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT -1,
  `date_inserted` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `bio` text DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `esgi_user`
--

INSERT INTO `esgi_user` (`id`, `firstname`, `lastname`, `email`, `pwd`, `country`, `birthday`, `gender`, `status`, `date_inserted`, `date_updated`, `bio`, `pseudo`, `is_active`, `token`) VALUES
(19, 'udoname', 'zzzz', 'pseudo@gmail.com', '$2y$10$1rk75/YOiX35IaewUm5eoO9ctjWpqXIQ9YRYueg7rNrFy.mi4pR7W', 'fr', '2005-05-05', 0, -1, '2023-05-04 19:39:52', '2023-05-04 19:44:48', 'qu\'est ce que tu me raconte là ?', 'psido', 0, NULL),
(20, 'Milk', 'user', 'milk@gmail.com', '$2y$10$EC6Lg5TwloDbcnEpOa0.1ubD5RWHqUzFz74xMTBUFsRJNS7Iwonj.', 'fr', '2005-05-05', 0, -1, '2023-05-04 19:48:18', NULL, NULL, 'user', 0, NULL),
(21, 'Jquery', 'js_lover', 'js@gmail.com', '$2y$10$axw.oPotBir5GOqHgRTqGepJT9UXEhzTDaEO6qiLM2QlmkVwImeD.', 'fr', '2005-05-05', 0, -1, '2023-05-04 19:56:46', NULL, NULL, 'js_lover', 0, NULL),
(22, 'Llll', 'feudi', 'ooooo@gmail.com', '$2y$10$UCe.DemTVhoK0aIJXZDREuJeSAe78Q.Y6DYKl5fphWgvX0qAUrSE2', 'pl', '2005-05-05', 0, -1, '2023-05-04 20:46:20', NULL, NULL, 'feudi', 0, NULL),
(23, 'Jquery', 'useriop', 'lllllllllllllll@gmail.com', '$2y$10$HHjq2TKQZDFkOVG/XUliaOuJ9zXMpLtqOcU1/EXlFaowE6Q6O/1Q2', 'fr', '2005-05-05', 0, -1, '2023-05-04 21:05:55', NULL, NULL, 'useriop', 0, NULL),
(27, 'Pseudoname', 'PSEUDO', 'sihomahi.ogedugiv@gotgel.org', '$2y$10$czrcUh570vIJUA.huDd4BugHl2aNB4axZLh7SsNrJHFDnh86t5tT6', 'fr', '2005-05-05', 0, -1, '2023-05-05 14:27:54', NULL, NULL, 'jjjj', 0, '11e167893f941f45702ee710fec957f0'),
(28, 'Llll', 'OOOOO', 'nacedimem.rofematir@jollyfree.com', '$2y$10$QIenwQp0drQsA3g7VHncDOz8xAS3OReJX9JCwlztkOifcR5UDnxJu', 'pl', '2005-05-05', 0, -1, '2023-05-05 15:33:24', NULL, NULL, 'user545', 0, '2093a8a4a71b4c21ce996f913e454f13'),
(29, 'Mmm', 'MMM', 'rerehoto.oruhopo@rungel.net', '$2y$10$FTucndkd6yxdE6ipKQztveM8k100yzdI77NKmX/3X6ql9mRisUTai', 'fr', '2005-05-05', 0, -1, '2023-05-05 16:19:04', NULL, NULL, 'mmmm', 0, NULL),
(30, 'Llllaaa', 'QQQQQ', 'vehebohid.vibuqora@rungel.net', '$2y$10$Ti1nMFAx4E55.na7mgRQoOTn/k13dVW.iezhw26WRtQYTEFRq8U.W', 'fr', '2005-05-05', 0, -1, '2023-05-05 18:05:06', NULL, NULL, 'paaaa', 0, '3494a96922efc0dc2293b22e3614139a'),
(32, 'Zee', 'ERRTT', 'lopequji.ojupihe@jollyfree.com', '$2y$10$QQCiRwrYX1s0jau7cUG8t.g.DRXT2rXhQa9V33Rp94O4eoFZw02DO', 'fr', '2005-05-25', 0, -1, '2023-05-05 21:36:20', NULL, NULL, 'sdd', 0, 'a10048b8dde2e7e668005c41e2a462a7'),
(33, 'Wwwwwww', 'WWW', 'xfuybpi440@tempmailfree.com', '$2y$10$fE.iJZ5abNnM.dysFTXaE.t1Vj/VH/FqvaNxK7AlPFhCPcvantkda', 'fr', '2005-05-05', 0, -1, '2023-05-06 14:03:13', NULL, NULL, 'wwww', 0, '9bc3ba4efc2c0b2d1758402187d3469b'),
(34, 'Lklk', 'MNMS', 'juruja.ihetub@rungel.net', '$2y$10$nxyp6WxtHEghusnKM/Lkcee7CO.p2UwCCgdDaOZITxxQ6YybaEVSW', 'fr', '2005-05-05', 0, -1, '2023-05-06 16:56:54', '2023-05-06 16:56:59', NULL, 'juju', 1, 'be94bdeabaee711511c3b185d40eebff'),
(35, 'Clément', 'POURADIER', 'pouradier.clement@gmail.com', '$2y$10$xitSlFsINaXK3EaRZ5tpCeBHk5E12kx6J.W5kYB/TOkWVdyMZXCCq', 'fr', '2003-04-04', 0, -1, '2023-05-06 17:23:46', NULL, NULL, 'sergentKarot', 1, '9d828f9d9ed4f578071be2fce29ae0d4'),
(41, 'Wxcvbn', 'AZERTY', 'vivujuhig@gotgel.org', '$2y$10$At6plZBdKCcleG2xS1yh5OSYcfwjApgUv4L8WdOKhxST0NPjtCbgy', 'fr', '2005-05-05', 0, -1, '2023-05-07 13:41:15', '2023-05-07 13:50:49', NULL, 'qsdfghj', 1, '68eeccc79d916bb17529f2932da0ac0b'),
(42, 'Win', 'WIN', 'loducas.sanehub@gotgel.org\n', '$2y$10$GT64gXmtyFA.ExvQ4vJIk.FOWe/vgXgvH/Ij88jL8nGffZioemC5e', 'fr', '2005-05-05', 0, -1, '2023-05-07 14:34:04', '2023-05-07 20:56:21', NULL, 'win', 1, 'ca9001a25e8749eeda5f21c55841e66b');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `esgi_user`
--
ALTER TABLE `esgi_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `esgi_user`
--
ALTER TABLE `esgi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
