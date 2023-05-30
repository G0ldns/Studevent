-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 07 mai 2023 à 22:52
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `id_auteur` int(11) DEFAULT NULL,
  `pseudo_auteur` varchar(255) DEFAULT NULL,
  `id_question` int(11) DEFAULT NULL,
  `contenu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `answers`
--

INSERT INTO `answers` (`id`, `id_auteur`, `pseudo_auteur`, `id_question`, `contenu`) VALUES
(1, 1, 'test', 3, 'coucou'),
(2, 1, 'test', 3, 'coucou'),
(3, 1, 'test', 3, 'coucou'),
(4, 2, 'avert', 3, 'coucou'),
(5, 2, 'avert', 3, 'coucou'),
(6, 2, 'avert', 3, 'coucou'),
(7, 2, 'avert', 3, 'coucou'),
(8, 2, 'avert', 4, 'yes'),
(9, 2, 'avert', 4, 'azerty'),
(10, 2, 'avert', 4, 'zute'),
(11, 1, 'test', 5, 'boit de l&#039;eau '),
(12, 1, 'test', 5, 'la clim'),
(13, 4, 'esgi', 6, 'ertyh'),
(14, 5, 'redhox', 7, 'rip'),
(15, 5, 'redhox', 7, 'va consulter mec'),
(16, 5, 'redhox', 7, 'belle beuteu'),
(17, 6, 'resst', 8, 'yes'),
(18, 6, 'resst', 5, 'glace'),
(19, 7, 'chris', 9, 'curseur pas beau'),
(20, 8, 'Chad', 10, 'yes'),
(21, 8, 'Chad', 10, 'yes'),
(22, 8, 'Chad', 10, 'yes'),
(23, 8, 'Chad', 10, 'yes'),
(24, 8, 'Chad', 5, 'écoute pas les rageux ╰(*°▽°*)╯????'),
(25, 8, 'Chad', 5, 'écoute pas les rageux ╰(*°▽°*)╯????'),
(26, 9, 'sergentkarotte', 5, 'teub'),
(27, 9, 'sergentkarotte', 11, 'grosse clakos<br />\r\n'),
(28, 10, 'proutt', 12, 'brfbgbrf'),
(29, 11, 'win', 13, 'chfcgbnfcg'),
(30, 11, 'win', 12, 'idk'),
(31, 11, 'win', 14, 'sananes'),
(32, 11, 'win', 4, 'c&#039;est vrai'),
(33, 11, 'win', 15, 'sananes');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `titre` text NOT NULL,
  `contenu` text NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `pseudo_auteur` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_publication` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `titre`, `contenu`, `id_auteur`, `pseudo_auteur`, `description`, `date_publication`) VALUES
(4, 'cool', 'cool', 2, 'avert', 'cool', '24/06/2022'),
(5, 'comment faire face à la canicule en été?', 'j&#039;en ai marre!', 3, 'papa', 'fais trop chaud', '25/06/2022'),
(12, 'minecraft', 'j&#039;aime les de lol', 10, 'proutt', 'lysa', '04/05/2023');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mdp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `nom`, `prenom`, `mdp`) VALUES
(1, 'test', '', 'test', '$2y$10$1VF8No2o1ucvE/W.IkGRseK1jnT9m77CZEQTAYSzUed60QIF8fJVa'),
(2, 'avert', 'avert', 'avert', '$2y$10$mfNVSHzq3eIJAXwY9X.NFeTVjVD6ERYi6gCcOUm/9iAcLxPKYkHxK'),
(3, 'papa', 'papa', 'papa', '$2y$10$SJjl7pRPVI5V0Yxol6DdWeQqEMXXBVhD2kzruezlV1IY6U9jLW4GS'),
(4, 'esgi', 'esgi', 'esgi', '$2y$10$ZU/iwszk9M3ZwWrI5qa9N.3sm.y6Jw28koC/GRkrlDFP.vVistdtS'),
(5, 'redhox', 'hox', 'red', '$2y$10$.MrXnid7Ii3omApnhz8zcucvpQqHYfnZoEj3FSMge3x3/O4COTJXi'),
(6, 'resst', 'resst', 'resst', '$2y$10$PwftXJbFdFYnsKsFcbfft.48iSIBHoPJUDu5HLvAOl677G82a8GiW'),
(7, 'chris', 'chris', 'chris', '$2y$10$GvGvGL.X/5dudPs/4Vmx.OUupcc8JKWzJes.nOTTgmCHDAAHexJnK'),
(8, 'Chad', 'Erard', 'delomon', '$2y$10$QMimup9UiXqjWt304yIVEe1DcMDhGqvI8PGG5oj0sqcQD7moZWC0W'),
(9, 'sergentkarotte', 'marlon', 'clément', '$2y$10$E23e144Ce6YGjPqivhyzyeC8I3asoS5GZTnZx.rn9pYqLNZlBuEMS'),
(10, 'proutt', 'bruce', 'orc&#039;est', '$2y$10$mxdu2z93zu1qN1shAnzncOIUutg3lPFuEFuIte3AAoIqWkYlbUAwO'),
(11, 'win', 'tagueule', 'delon', '$2y$10$4zBwQ.Yg5TO/UqMXo3/.M.kMgPBs4XE5o0t/nznF526DXPm1d7BDa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
