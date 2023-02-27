-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 fév. 2023 à 22:22
-- Version du serveur : 5.7.40
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_rti_courrier`
--

-- --------------------------------------------------------

--
-- Structure de la table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `attach_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `attach_label` varchar(50) NOT NULL,
  `attach_link` varchar(255) NOT NULL,
  `ref_mail` varchar(15) NOT NULL,
  PRIMARY KEY (`attach_id`),
  KEY `id_mail` (`ref_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `attachments`
--

INSERT INTO `attachments` (`attach_id`, `attach_label`, `attach_link`, `ref_mail`) VALUES
(1, 'Formulaire de demande de.doc', '../uploaded_files/documents/8179ccbe3c1669507bb335695c51154adba8ef5f.doc', '0DG23'),
(2, 'Mon rapport.docx', '../uploaded_files/documents/f9703b8db922dc42280ddc2e4bd85639e90b2b58.docx', '0DG23'),
(5, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', '3DSI23'),
(6, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', '3DSI23');

-- --------------------------------------------------------

--
-- Structure de la table `directions`
--

DROP TABLE IF EXISTS `directions`;
CREATE TABLE IF NOT EXISTS `directions` (
  `dir_id` int(11) NOT NULL AUTO_INCREMENT,
  `dir_label` varchar(255) NOT NULL,
  `dir_sigle` varchar(5) NOT NULL,
  PRIMARY KEY (`dir_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `directions`
--

INSERT INTO `directions` (`dir_id`, `dir_label`, `dir_sigle`) VALUES
(1, 'Direction des systèmes d\'information', 'DSI'),
(2, 'Direction Générale', 'DG');

-- --------------------------------------------------------

--
-- Structure de la table `mails`
--

DROP TABLE IF EXISTS `mails`;
CREATE TABLE IF NOT EXISTS `mails` (
  `mail_ref` varchar(15) NOT NULL,
  `mail_corresponding` varchar(60) NOT NULL,
  `mail_object` varchar(255) NOT NULL,
  `mail_date_received` date NOT NULL,
  `mail_shipping_date` date DEFAULT NULL,
  `mail_imputation` varchar(20) DEFAULT NULL,
  `mail_annotation` varchar(20) DEFAULT NULL,
  `id_direction` int(11) NOT NULL,
  `id_register` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`mail_ref`),
  KEY `id_register` (`id_register`),
  KEY `id_service` (`id_direction`),
  KEY `id_service_2` (`id_direction`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `mails`
--

INSERT INTO `mails` (`mail_ref`, `mail_corresponding`, `mail_object`, `mail_date_received`, `mail_shipping_date`, `mail_imputation`, `mail_annotation`, `id_direction`, `id_register`, `id_user`) VALUES
('0DG23', 'Socopao', 'Demande d\'argent', '2023-02-27', '2023-02-28', 'UI', 'AS', 2, 2, 48),
('2DG23', 'BNI', 'Demande de demande', '2023-02-22', '2023-02-27', '', '', 2, 2, 48),
('3DSI23', 'BAD', 'Demande de matériels', '2023-02-14', '2023-02-16', '', '', 1, 2, 48);

-- --------------------------------------------------------

--
-- Structure de la table `registers`
--

DROP TABLE IF EXISTS `registers`;
CREATE TABLE IF NOT EXISTS `registers` (
  `reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_label` varchar(30) NOT NULL,
  PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `registers`
--

INSERT INTO `registers` (`reg_id`, `reg_label`) VALUES
(1, 'REGISTRE DES ARRIVEES'),
(2, 'REGISTRE DES DEPARTS');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_lastname` varchar(25) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `user_password` varchar(255) NOT NULL,
  `user_isfirstconnection` tinyint(1) NOT NULL DEFAULT '0',
  `user_image` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_lastname`, `user_firstname`, `user_email`, `user_isadmin`, `user_password`, `user_isfirstconnection`, `user_image`) VALUES
(44, 'John', 'Doe', 'john.doe@rti.ci', 0, '$2y$10$RNKXJw/7RhNHnkCqSTyot.pNd60VKTUqS46PhLSxpFK9SSuE7UWo6', 1, '../uploaded_files/46a39d7ff66422b5cd822dfcc4ddd9eef17d32f5.jpg'),
(48, 'Alex', 'Stan', 'alex.stan@rti.ci', 1, '$2y$10$t3Z4V.UzJF7hRefvJOAk6ehY2nvsrGz0KZVS84k9W2E2DG7eqa3vq', 1, '../uploaded_files/user.png'),
(49, 'Sami', 'gfgff', 'jhjhjh@rti.ci', 0, '$2y$10$h/TVQN.ebXK9cxOLqx5ZdOV4WMjQdhEh2u0LfP1Z2/AJrtMIMI2oO', 0, '../uploaded_files/6ef59908325631a1b3d312ea7ae8e4cf918bf5c2.png');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`ref_mail`) REFERENCES `mails` (`mail_ref`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mails`
--
ALTER TABLE `mails`
  ADD CONSTRAINT `mails_ibfk_1` FOREIGN KEY (`id_direction`) REFERENCES `directions` (`dir_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mails_ibfk_2` FOREIGN KEY (`id_register`) REFERENCES `registers` (`reg_id`),
  ADD CONSTRAINT `mails_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
