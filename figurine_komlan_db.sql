-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 06 oct. 2026 à 11:00
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `figurine_komlan_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20261006095920', '2026-10-06 10:00:40', 74);

-- --------------------------------------------------------

--
-- Structure de la table `figurines`
--

DROP TABLE IF EXISTS `figurines`;
CREATE TABLE IF NOT EXISTS `figurines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` longtext,
  `price` double NOT NULL,
  `image_name` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_45D9EB61A76ED395` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `figurines`
--

INSERT INTO `figurines` (`id`, `title`, `description`, `price`, `image_name`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Samouraï articulé édition collector', 'Figurine de 28 cm avec armure amovible, deux sabres et socle lumineux.', 129.9, 'fig-01.svg', '2026-09-24 10:03:20', '2026-09-24 10:03:20', 1),
(2, 'Dragon d\'obsidienne 30 cm', 'Dragon en résine peinte à la main, ailes déployées. Tirage limité à 500 exemplaires.', 89, 'fig-02.svg', '2026-09-25 10:03:20', '2026-09-25 10:03:20', 2),
(3, 'Robot géant MK-II', 'Mecha en métal moulé et ABS, 14 points d\'articulation, accessoires inclus.', 74.5, 'fig-03.svg', '2026-09-26 10:03:20', '2026-09-26 10:03:20', 3),
(4, 'Chevalier lunaire', 'Statuette premium échelle 1/6, cape en tissu véritable.', 159.99, 'fig-04.svg', '2026-09-27 10:03:20', '2026-09-27 10:03:20', 1),
(5, 'Petit renard des neiges', 'Mini figurine kawaii de 8 cm, idéale pour un bureau.', 12.9, 'fig-05.svg', '2026-09-28 10:03:20', '2026-09-28 10:03:20', 2),
(6, 'Pirate des sept mers - édition deluxe avec perroquet', 'Un pirate haut en couleur livré avec son perroquet, son coffre et son drapeau.', 64, 'fig-06.svg', '2026-09-29 10:03:20', '2026-09-29 10:03:20', 3),
(7, 'Ninja de l\'ombre', NULL, 39.9, 'fig-07.svg', '2026-09-30 10:03:20', '2026-09-30 10:03:20', 1),
(8, 'Sorcière des marais', 'Figurine 1/8 avec chaudron fumigène (fumée non fournie).', 54.2, 'fig-08.svg', '2026-10-01 10:03:20', '2026-10-01 10:03:20', 2),
(9, 'Astronaute vintage', 'Hommage rétro aux années 60, casque transparent et drapeau.', 29.99, 'fig-09.svg', '2026-10-02 10:03:20', '2026-10-02 10:03:20', 3),
(10, 'Golem de pierre géant', 'Pièce imposante de 40 cm, peinture effet roche, yeux lumineux.', 189, 'fig-10.svg', '2026-10-03 10:03:20', '2026-10-03 10:03:20', 1),
(11, 'Pilote de course', 'Figurine 1/12 avec combinaison détaillée et casque amovible.', 24.5, 'fig-11.svg', '2026-10-04 10:03:20', '2026-10-04 10:03:20', 2),
(12, 'Elfe archère forêt profonde', 'Statuette en résine, arc articulé et carquois détachable.', 99.9, 'fig-12.svg', '2026-10-05 10:03:20', '2026-10-05 10:03:20', 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `image_name` varchar(500) NOT NULL,
  `is_verified` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `image_name`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'alice@example.com', '[]', '$2y$13$KNQGG6IUjVP5VGrUsUkJEOxLQaHsgCg7CPy2o6VLDHLhUeYGmG7ci', 'Alice', 'Martin', 'default-avatar.svg', 1, '2026-10-06 10:03:19', '2026-10-06 10:03:19'),
(2, 'bruno@example.com', '[]', '$2y$13$g1BvliYZSMuPQAAF0e6TQuvsphszWWODLLc263r38HJ.XhsiEaqW6', 'Bruno', 'Dupont', 'default-avatar.svg', 1, '2026-10-06 10:03:20', '2026-10-06 10:03:20'),
(3, 'chloe@example.com', '[]', '$2y$13$pzNbY7dr7Y5M8lLKomHTa.9OsofyOgc.sNsADJGaF3y13gsJs4.3C', 'Chloé', 'Lambert', 'default-avatar.svg', 1, '2026-10-06 10:03:20', '2026-10-06 10:03:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
