-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 26 fév. 2023 à 20:22
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
  `attach_file` varchar(255) NOT NULL,
  `id_mail` int(11) NOT NULL,
  PRIMARY KEY (`attach_id`),
  KEY `id_mail` (`id_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `attachments`
--

INSERT INTO `attachments` (`attach_id`, `attach_label`, `attach_file`, `id_mail`) VALUES
(5, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', 6),
(6, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', 7),
(7, 'Formulaire de demande de.doc', '../uploaded_files/documents/8179ccbe3c1669507bb335695c51154adba8ef5f.doc', 7),
(8, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', 12),
(9, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', 15),
(10, 'Mon rapport.docx', '../uploaded_files/documents/f9703b8db922dc42280ddc2e4bd85639e90b2b58.docx', 16),
(11, 'FICHE DE VALIDATION DE THEME.docx', '../uploaded_files/documents/5f2adf1cc551092cdd333411f76b5e72f8126ed4.docx', 17),
(12, 'reclamer.png', '../uploaded_files/documents/82f4aa02750de91a40912a3422a29eb9ead57f28.png', 26),
(13, 'Mon rapport.pdf', '../uploaded_files/documents/86c0ae56af9dd9829282523bba43cedfc4386419.pdf', 27);

-- --------------------------------------------------------

--
-- Structure de la table `mails`
--

DROP TABLE IF EXISTS `mails`;
CREATE TABLE IF NOT EXISTS `mails` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_corresponding` varchar(60) NOT NULL,
  `mail_object` varchar(255) NOT NULL,
  `mail_date_received` date NOT NULL,
  `mail_shipping_date` date DEFAULT NULL,
  `mail_imputation` varchar(20) DEFAULT NULL,
  `mail_annotation` varchar(20) DEFAULT NULL,
  `id_service` int(11) NOT NULL,
  `id_register` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`),
  KEY `id_register` (`id_register`),
  KEY `id_service` (`id_service`),
  KEY `id_service_2` (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `mails`
--

INSERT INTO `mails` (`mail_id`, `mail_corresponding`, `mail_object`, `mail_date_received`, `mail_shipping_date`, `mail_imputation`, `mail_annotation`, `id_service`, `id_register`) VALUES
(6, 'Agence RTI PUBLICITE VALLON', 'TEts', '2023-02-21', '2023-02-16', '', '', 358, 2),
(7, 'Audio et Sonorisation', 'Demande de demande', '2023-02-16', '2023-02-16', 'AF', 'DSI', 199, 2),
(12, 'Agence RTI PUBLICITE VALLON', 'Demande de demande', '2023-02-18', '2023-02-10', '', '', 384, 2),
(15, 'Agence COSMOS Yopougon', 'Demande de demande', '2023-02-23', '2023-02-18', '', '', 370, 2),
(16, 'Socopao', 'Demande d\'aide', '2023-02-23', '2023-02-24', 'OI', 'SH', 151, 2),
(17, ' Reporting et Analyse des Résultats Commerciaux', 'Demande d\'aide', '2023-02-24', '2023-02-16', '', '', 370, 2),
(21, 'Agence COSMOS Yopougon', 'Demande de demande', '2023-02-16', '2023-02-25', '', '', 384, 2),
(22, 'Agence COSMOS Yopougon', 'Demande de demande', '2023-02-16', '2023-02-26', '', '', 384, 2),
(24, 'Agence RTI PUBLICITE BOUAKE', 'kjkjks', '2023-02-10', '2023-02-25', '', '', 202, 2),
(26, 'Eric Stéphane', 'Demande de personnels', '2023-02-25', NULL, NULL, NULL, 77, 1),
(27, ' Reporting et Analyse des Résultats Commerciaux', 'Demande de ménage', '2023-02-26', NULL, NULL, NULL, 125, 1),
(28, 'kjdkjdkdj', 'Demande de demande', '2023-02-27', '2023-02-27', '', '', 384, 2);

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
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `serv_id` int(11) NOT NULL AUTO_INCREMENT,
  `serv_label` longtext,
  PRIMARY KEY (`serv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=386 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`serv_id`, `serv_label`) VALUES
(6, 'Département de la Programmation RTI 1'),
(7, 'Service de la Programmation RTI 1'),
(8, 'Service Suivi des Antennes RTI 1'),
(9, 'Coordination Editoriale des Contenus Information et Réligion'),
(10, 'Coordination Editoriale des Jeux et Divertissements'),
(11, 'Service Editorial des Productions RTI 1'),
(12, 'Département Projet RTI 3'),
(13, 'Direction de RTI 1'),
(26, 'Département Transmission'),
(27, 'Service Maintenance Transmission'),
(28, 'Service Reportage Transmission'),
(29, 'Station Terrienne (COMSAT)'),
(31, 'Département de la Fiction'),
(32, 'Service de la Fiction'),
(33, 'Service Planification et Montage'),
(34, 'Département des Archives et Conservation'),
(35, 'Service des Archives et Conservation'),
(36, 'Département des Documentaires'),
(37, 'Service des Documentaires'),
(38, 'Fiction et Documentaires'),
(39, 'Coordination des Productions Extérieures'),
(40, 'Cellule Maquillage'),
(41, 'Coordination des Productions Internes'),
(42, 'Service des Productions Internes RTI 1'),
(43, 'Service Production RTI 2'),
(44, 'Service Montage et Planification RTI 1'),
(45, 'Service Montage et Planification RTI 2'),
(46, 'Service Production d\'Information et Magazines d\'Information'),
(47, 'Département Artistique'),
(48, 'Service de l\'Auto Promotion'),
(49, 'Service Infographie'),
(50, 'Captations et Retransmissions Sportives, Institutionnelles et Religieuses'),
(51, 'Service Décor'),
(52, 'Planification, Machiniste, Cadreurs et Equipement ENG'),
(53, 'Production RTI 2'),
(54, 'Productions de Flux et des Evénementiels'),
(55, 'Productions Informations et Magazines d\'Informations'),
(56, 'Productions Magazines et Divertissements'),
(57, 'Productions Musique, Sport et Events RTI 1'),
(58, 'Infographie'),
(59, 'Montage et Planification RTI 1'),
(60, 'Montage et Planification RTI 2'),
(61, 'Post Production'),
(62, 'Direction de la Production TV'),
(63, 'Département de la Programmation RTI 2'),
(64, 'Service Programmes RTI 2'),
(65, 'Service Suivi des Antennes'),
(66, 'Coordination Editoriale des Magazines'),
(67, 'Coordination Editoriale Musique'),
(68, 'Département Editorial des productions RTI 2'),
(69, 'Direction de RTI 2'),
(70, 'Département des Programmes RTI 3'),
(71, 'Direction de RTI Digital'),
(72, 'Service Contenus RTI Divertissement'),
(73, 'Service Développement et Innovation'),
(74, 'Département Développement'),
(75, 'Département des Ventes Internationales'),
(76, 'Suivi des Co-Productions'),
(77, 'Direction de RTI Distribution'),
(78, 'Service Achat de Biens Techniques et de Programmes'),
(79, 'Service Achats de Biens Administratifs et Divers'),
(80, 'Département Achats'),
(81, 'Service Crédit Client'),
(82, 'Service Facturation'),
(83, 'Service Recouvrement'),
(84, 'Service Comptabilité'),
(85, 'Comptabilité et Fiscalité'),
(86, 'Service Fiscalité et Immobilisations'),
(87, 'Service Contrôle Budgétaire'),
(88, 'Service Contrôle de Gestion'),
(89, 'Département Contrôle de Gestion'),
(90, 'Département Trésorerie'),
(91, 'Service Gestion des Encaissements et des Décaissements'),
(92, 'Trésorerie'),
(93, 'Trésorerie Prévisionnelle et Financement'),
(94, 'Direction des Finances et Comptabilité'),
(95, 'Direction des Journaux d\'Information'),
(96, 'Editions de 13h RTI 1'),
(97, 'Langues Nationales et Information Régionale'),
(98, 'Rédaction JT RTI 1'),
(99, 'Service de la Programation des Reportages et de la Prévison'),
(100, 'Service des Editions du Soir RTI 1'),
(101, 'Service des Moyens de Tournages et de la Prévision'),
(102, 'Service Grandes Enquêtes'),
(103, 'Service Reportage ENG RTI 1'),
(104, 'Service Société'),
(105, 'Rédaction JT RTI 2'),
(106, 'Editions du Soir RTI 2'),
(107, 'Service Reportage RTI 2'),
(108, 'Service Edition des Débats'),
(109, 'Direction des Magazines d\'Information'),
(110, 'Direction des Magazines d\'Information'),
(111, 'Service Edition des Magazines'),
(112, 'Département Etudes et Travaux'),
(113, 'Département Ingénierie et Maintenance'),
(114, 'Service Energie et Froid'),
(115, 'Service Etudes et Travaux'),
(116, 'Département Logistique'),
(117, 'Service Entrepôt, Entretien et Réparation'),
(118, 'Service Moyens Généraux de la Radio'),
(119, 'Service Moyens Généraux RTI BOUAKE'),
(120, 'Service Parc Auto'),
(121, 'Département Patrimoine et Sécurité'),
(122, 'Service Patrimoine'),
(123, 'Service Patrimoine et Sécurité RADIO'),
(124, 'Service Sécurité'),
(125, 'Direction des Moyens Généraux'),
(126, 'Direction des Projets et de la Planification'),
(127, 'Gestion du Personnel et Rémunération'),
(128, 'Service Gestion du Personnel'),
(129, 'Service Missions et Voyages'),
(130, 'Service Rémunération'),
(131, 'Communication Interne et Courrier'),
(132, 'Formation et Stage'),
(133, 'GPEC et Mobilité'),
(134, 'Département Social et Médical'),
(135, 'Médical'),
(136, 'Service Social'),
(137, 'Direction des Ressources Humaines'),
(138, 'Département Infrastructures et Supports'),
(139, 'Support aux Utilisateurs'),
(140, 'Systèmes et Réseaux'),
(141, 'Département Projets et Applications'),
(142, 'Service Exploitation, Supervision et Maintenance'),
(143, 'Direction des Systèmes d\'Information'),
(144, 'Département Production Fréquence 2'),
(145, 'Service Production Fréquence 2'),
(146, 'Département Programmes Fréquence 2'),
(147, 'Service Programmation Fréquence 2'),
(148, 'Service Promotion Féquence 2'),
(149, 'Direction Fréquence 2'),
(150, 'Conseiller du DG'),
(151, 'Direction Générale'),
(152, 'Direction Générale Adjointe'),
(153, 'Service Autonome Chargé de la Planification et des Projets'),
(154, 'Facilitation Sociale'),
(155, 'Service Autonome de l\'Audit Interne'),
(156, 'Sce Aut Affaires Juridiques et Contentieux'),
(157, 'Section Affaires Juridiques'),
(158, 'Section Contentieux'),
(159, 'Rédaction des Sports TV'),
(160, 'Section Production SAS TV'),
(161, 'Section Reportages SAS TV'),
(162, 'Section Pige Antenne et Etudes d\'Audiences'),
(163, 'Section Pige Commerciale'),
(164, 'Service Autonome du Contrôle, du Suivi et de la Qualité de l\'antenne'),
(165, 'Département Etude et Veille'),
(166, 'Département Marketing Opérationnel'),
(167, 'Direction Marketing et Communication'),
(168, 'Département des Programmes RADIO CI'),
(169, 'Service Programme et Suivi de l\'Antenne'),
(170, 'Service Promotion Radio CI'),
(171, 'Département Production RADIO - CI'),
(172, 'Service Production Radio CI'),
(173, 'Département Sports Radio - CI'),
(174, 'Service des Productions Quotidiennes et Actualités Sportives Radio - CI'),
(175, 'Service Magazine et Retransmissions Radio - CI'),
(176, 'Direction Radio - Côte d\'Ivoire'),
(177, 'Direction Radio CI'),
(178, 'Département Energie et Froid'),
(179, 'Service Gestion du Parc Auto'),
(180, 'Magazines et Débats Radio CI'),
(181, 'Rédaction de Radio CI'),
(182, 'Reportages Radio CI'),
(183, 'Secretariat Information'),
(184, 'Editions du Soir Radio CI'),
(185, 'Rédaction de l\'Information Radio'),
(186, 'Bouaké'),
(187, 'Commercial -marketing Bouaké'),
(188, 'Département Radio Bouaké'),
(189, 'Programme et Promotion Radio Bké'),
(190, 'Service Information Radio Bouaké'),
(191, 'Département TV Bouaké'),
(192, 'Service Information TV'),
(193, 'Service Programme et Promotion TV Bouaké'),
(194, 'Direction RTI Bouaké'),
(195, 'Département Administration des Ventes'),
(196, 'Pôle Planning'),
(197, 'Pôle Trafic'),
(198, 'Service Crédit - Client et Projet ADV'),
(199, 'Agence RTI PUBLICITE BOUAKE'),
(200, 'Agence RTI PUBLICITE PLATEAU'),
(201, 'Service Etudes et Veilles'),
(202, 'Agence RTI PUBLICITE VALLON'),
(203, 'Département Agences RTI Publicité'),
(204, 'Département Commercial'),
(205, 'Pôle Agences Publicitaires'),
(206, 'Pôle Alimentation et Distribution'),
(207, 'Pôle Boissons'),
(208, 'Pôle BTP, Immobilier et Energie'),
(209, 'Pôle Hygiène et Beauté'),
(210, 'Pôle Services Financiers (Banques et Assurances) et Transport'),
(211, 'Pôle Suivi Commercial et Réclamation'),
(212, 'Pôle Suivi Sponsoring'),
(213, 'PôleTélécoms et Média'),
(214, 'Département de la Commercialisation des Infrastructures Techniques, de l\'Evenementiel et du P'),
(215, 'Pôle Commercialisation des Infrastructures Techniques'),
(216, 'Pôle Evénementiel'),
(217, 'Service de Ventes Pylônes'),
(218, 'Département des Projets Commerciaux'),
(219, 'Agenda et Productions Commerciales'),
(220, 'Agenda, Avis et Communiqués'),
(221, 'Direction RTI Publicité'),
(222, 'Service Planning'),
(223, 'Département Infrastructure et Projets'),
(224, 'Service Exploitation Nodal et Réception des Signaux'),
(225, 'Service Exploitation Régie Numérique'),
(226, 'Département Infrastructure TV et Radio'),
(227, 'Exploitation Régie de Diffusion et Nodal'),
(228, 'Infrastructures Radio'),
(229, 'Infrastructures TV'),
(230, 'Département Maintenance'),
(231, 'Service Maintenance Audio'),
(232, 'Service Maintenance Vidéo'),
(233, 'Service Stock et Matériels Techniques'),
(234, 'Maintenance Audio'),
(235, 'Maintenance Vidéo'),
(236, 'Audio et Sonorisation'),
(237, 'Eclairage Extérieur'),
(238, 'Eclairage Numérique et Artistique'),
(239, 'Exploitation des Caméras'),
(240, 'Exploitation des Serveurs de Production'),
(241, 'Moyen de Production TV'),
(242, 'Régie Mobile'),
(243, 'Vidéo'),
(244, 'Département des Moyens de Production Interne'),
(245, 'Exploitation Audio Vidéo'),
(246, 'Service Eclairage'),
(247, 'Service Exploitation Audio'),
(248, 'Service Exploitation des Caméras'),
(249, 'Service Exploitation Vidéo'),
(250, 'Service Reportages Lourds'),
(251, 'Exploitation Radio'),
(252, 'Maintenance Radio'),
(253, 'Moyens de Production Radio'),
(254, 'Moyens de Productions TV et Radio à  Bouaké'),
(255, 'Technique Radio Bouaké'),
(256, 'Technique TV Bouaké'),
(257, 'Département Technique Radio'),
(258, 'Service Exploitation Radio'),
(259, 'Service Exploitation Radio'),
(260, 'Service Maintenance Radio'),
(261, 'Maintenance'),
(262, 'Reportage'),
(263, 'Service Station Terrienne (COMSAT)'),
(264, 'Transmission'),
(265, 'Direction Technique'),
(266, 'Service Technique Bouaké'),
(267, 'MINICOM'),
(268, 'Médiation de l\'Information et des Programmes'),
(269, 'Médiation de l\'Information et des Programmes'),
(270, 'PCA'),
(271, 'Technique RTI 3'),
(272, 'Sports et Production La 3'),
(273, 'Sports et Production RTI 3'),
(274, 'Service Music'),
(275, 'Service Suivi d\'Antenne'),
(276, 'Service de la Planification'),
(277, 'Service Projets'),
(278, 'Service Gestion Banques, Caisse Centrale et Caisses Recettes'),
(279, 'Service Gestion des Régies et Caisse d\'Avance'),
(280, 'Rédaction des Journaux et Magazines'),
(281, 'Edition des Journaux et Magazines'),
(282, 'Rédaction des Retransmissions et Evènementiels'),
(283, 'Editions des Retransmissions et Evènementiels'),
(284, 'Service Pilotage des Contenus TV'),
(285, 'Service Pilotage des Contenus Radio'),
(286, 'Département Contenu'),
(287, 'Département Business Développement'),
(288, 'Département Conduite de Projet'),
(289, 'Département Marketing Digital Analytique et Stratégique'),
(290, 'Service Sponsoring et Partenariats'),
(291, 'Service Communication Institutionnelle'),
(292, 'Service Communication Antennes'),
(293, 'Service Production Contenu Digital'),
(294, 'Département Stratégie et Performances'),
(295, 'Service Etudes et Veilles'),
(296, 'Département Planification et Coûts'),
(297, 'Département Auto Promotion'),
(298, 'Département Infrastructures Administratives et Broadcast'),
(299, 'Service Administration Systèmes Office et Broadcast'),
(300, 'Service Projets et Développement d\'Application'),
(301, 'Service Déploiement et Assistance Applicative'),
(302, 'Service Supervision des Infrastructures Offices et Audiovisuelles'),
(303, 'Département Support et Supervision'),
(304, 'Editions du Jour RTI 2'),
(305, 'Service des Reportages et des Moyens de Tournage RTI 2'),
(306, 'Service Autonome du Journal Télévisé RTI 2'),
(307, 'Service Sécurité et Travaux'),
(308, 'Département Patrimoine, Logistique et Gestion des Stocks'),
(309, 'Service Logistique'),
(310, 'Service Maintenance Automobile'),
(311, 'Service Energie'),
(312, 'Service Froid'),
(313, 'Département Transmission et régies de Diffusion'),
(314, 'Service Editorial chargé des Magazines RTI 2'),
(315, 'Direction Marketing et Communication'),
(322, 'Service Trafic'),
(323, 'La 3'),
(324, 'Service Etudes'),
(325, 'Service Régie Finale RTI 1'),
(326, 'Service Exploitation des Serveurs de Production'),
(327, 'Service des Editions du Jour Radio Côte d\'Ivoire'),
(328, 'Service Production JT et Magazines'),
(329, 'Service Moyens Généraux RTI BOUAKE'),
(330, 'Service Vidéo '),
(331, 'Service Reportages '),
(332, 'Productions Extérieures'),
(333, 'Service d\'Affectation Radio Côte d\'Ivoire'),
(334, 'Service Support aux Utilisateurs'),
(335, 'Service Magazines et Débats'),
(336, 'Département Events'),
(337, 'Service Infographie'),
(338, 'Service Audio et Sonorisation'),
(339, 'Service Information en ligne'),
(340, 'Service Promotion de Fréquence 2'),
(341, 'Pôle Télécoms et Média'),
(342, 'Informations en Langues Nationales et Correspondants Régionaux'),
(343, 'Service Reportage Sport'),
(344, 'Service Economie'),
(345, 'Pôle 5 - Hygiène et Beauté'),
(346, 'Service Recouvrement'),
(347, 'Service d\'Affectation Journaux d\'Information'),
(348, 'Service Politique et Actualité Internationale'),
(349, 'Pôle 3 - Alimentaire et Boisson'),
(350, 'Département GPEC & Formation'),
(351, 'Service des Editions du Soir'),
(352, 'Pôle BTP, Immobilier et Energie'),
(353, 'Service Reportages Radio'),
(354, 'Service Suivi Sponsoring'),
(355, 'Service Editions du week-end'),
(356, 'Pôle BTP, Immobilier et Energie'),
(357, 'Exploitation des Serveurs de Production'),
(358, ' Entretien, Hygiène et Beauté'),
(359, 'Service Maintenance'),
(360, 'Service Promotion des Offres Editoriales'),
(361, 'Service d\'Affectation Fréquence 2'),
(362, 'Service Eclairage Extérieur et Energie'),
(363, 'Service Productions RTI 2'),
(364, 'Section Planification et Statistiques'),
(365, 'Service Production Sport'),
(366, 'Service Reportage'),
(367, 'Courtiers Agences Commerciales'),
(368, 'Service Matériels Techniques et Stockage'),
(369, 'Service Projets TV'),
(370, 'Agence COSMOS Yopougon'),
(371, 'Service Exploitation Radio'),
(372, 'Service Events'),
(373, 'Dpt Editorial chargé du Divertissement'),
(374, 'Service Productions RTI 1'),
(375, 'Service Editions de la Matinée'),
(376, 'Pôle Agences Publicitaires'),
(377, 'Programmation et Suivi de la Diffusion des Spots'),
(378, 'Service Clientèle'),
(379, 'Service des Reportages  '),
(380, 'Service Planning'),
(381, 'Département Ventes Directes'),
(382, 'Pôle Suivi Sponsoring'),
(383, 'Département Transport '),
(384, ' Reporting et Analyse des Résultats Commerciaux'),
(385, 'Service Moyens Généraux de la Radio');

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
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`id_mail`) REFERENCES `mails` (`mail_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mails`
--
ALTER TABLE `mails`
  ADD CONSTRAINT `mails_ibfk_2` FOREIGN KEY (`id_register`) REFERENCES `registers` (`reg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mails_ibfk_3` FOREIGN KEY (`id_service`) REFERENCES `services` (`serv_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
