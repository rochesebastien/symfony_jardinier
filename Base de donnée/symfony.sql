-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 30 mars 2022 à 09:39
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(2, 'Persistant'),
(3, 'Résineux'),
(4, 'Résistant');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`id`, `utilisateur_id`, `date`, `prix`) VALUES
(28, 4, '2022-03-29', 540),
(29, 4, '2022-03-29', 702),
(30, 4, '2022-03-29', 702),
(31, 6, '2022-03-29', 40),
(32, 4, '2022-03-29', 9),
(33, 4, '2022-03-29', 540),
(34, 4, '2022-03-29', 9),
(35, 4, '2022-03-29', 180),
(36, 4, '2022-03-29', 450),
(37, 4, '2022-03-29', 180),
(38, 4, '2022-03-29', 135),
(39, 4, '2022-03-29', 9),
(40, 4, '2022-03-29', 18),
(41, 6, '2022-03-29', 600),
(42, 5, '2022-03-30', 40),
(43, 6, '2022-03-30', 50);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220329174433', '2022-03-29 19:44:37', 284);

-- --------------------------------------------------------

--
-- Structure de la table `haie`
--

CREATE TABLE `haie` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `haie`
--

INSERT INTO `haie` (`id`, `categorie_id`, `code`, `nom`, `prix`) VALUES
(1, 3, 'SAPIN', 'Sapin', '40.00'),
(2, 3, 'LA', 'Laurier', '10.00'),
(3, 2, 'AB', 'Abélia', '12.00');

-- --------------------------------------------------------

--
-- Structure de la table `tailler`
--

CREATE TABLE `tailler` (
  `id` int(11) NOT NULL,
  `haie_id` int(11) NOT NULL,
  `devis_id` int(11) DEFAULT NULL,
  `longueur` int(11) NOT NULL,
  `hauteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tailler`
--

INSERT INTO `tailler` (`id`, `haie_id`, `devis_id`, `longueur`, `hauteur`) VALUES
(1, 1, 28, 10, 3),
(2, 1, 29, 10, 10),
(3, 1, 29, 3, 2),
(4, 1, 30, 10, 10),
(5, 1, 30, 3, 2),
(6, 1, 31, 1, 1),
(7, 2, 32, 1, 1),
(8, 1, 33, 10, 10),
(9, 2, 34, 1, 1),
(10, 1, 35, 5, 1),
(11, 2, 36, 50, 1),
(12, 1, 37, 5, 1),
(13, 2, 38, 10, 10),
(14, 2, 39, 1, 1),
(15, 1, 40, 0, 1),
(16, 1, 41, 10, 10),
(17, 1, 42, 1, 1),
(18, 1, 43, 1, 1),
(19, 2, 43, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeclient` tinyint(1) NOT NULL,
  `cp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `nom`, `prenom`, `adresse`, `ville`, `typeclient`, `cp`) VALUES
(4, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$aSGHS06AxrEtsFvdEsEUxuq9KHahAuqJfFhRs/JPye9ox9TpnN1Ze', 'Roche', 'Sébastien', '10 rue François test', 'Guéret', 1, 87000),
(5, 'test', '[\"ROLE_USER\"]', '$2y$13$RtG45I/nXqLS3K2Mx/9tQuCLbsUyR3yFGWFk3T1KjzgKsucsL2cW6', 'Rodrigues', 'Anthony', 'fayot', 'Limoges', 0, 87000),
(6, 'user', '[\"ROLE_USER\"]', '$2y$13$wzQdgqQGyLgnVqJKUbbsnu4B6EOZd/ET0xSrHMtwKDP1w9I63j0B6', 'SINGH', 'Paul', 'truc', 'Limoges', 0, 87000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8B27C52BFB88E14F` (`utilisateur_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `haie`
--
ALTER TABLE `haie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F24E4DEBCF5E72D` (`categorie_id`);

--
-- Index pour la table `tailler`
--
ALTER TABLE `tailler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_447D1788E7470F2C` (`haie_id`),
  ADD KEY `IDX_447D178841DEFADA` (`devis_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `haie`
--
ALTER TABLE `haie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tailler`
--
ALTER TABLE `tailler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `FK_8B27C52BFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `haie`
--
ALTER TABLE `haie`
  ADD CONSTRAINT `FK_1F24E4DEBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `tailler`
--
ALTER TABLE `tailler`
  ADD CONSTRAINT `FK_447D178841DEFADA` FOREIGN KEY (`devis_id`) REFERENCES `devis` (`id`),
  ADD CONSTRAINT `FK_447D1788E7470F2C` FOREIGN KEY (`haie_id`) REFERENCES `haie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
