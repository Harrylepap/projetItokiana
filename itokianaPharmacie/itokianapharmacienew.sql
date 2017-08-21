-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 18 Novembre 2016 à 18:37
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `itokianapharmacienew`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(1, 'Rhume'),
(2, 'Toux'),
(3, 'Beauté');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `libelle`) VALUES
(1, 'OPHAM'),
(2, 'NCPC'),
(3, 'DROGEMAD'),
(4, 'SOPHARMAD');

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

CREATE TABLE IF NOT EXISTS `medicament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unite_id` int(11) DEFAULT NULL,
  `sorte_id` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL,
  `picture_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9A9C723AEC4A74AB` (`unite_id`),
  KEY `IDX_9A9C723AE54384C0` (`sorte_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `medicament`
--

INSERT INTO `medicament` (`id`, `unite_id`, `sorte_id`, `prix`, `libelle`, `dose`, `nombre`, `picture_name`) VALUES
(1, 1, 1, 1000, 'Vitamine C', '500 mg', 45, 'Delire at home (3).jpg'),
(3, 2, 2, 5000, 'Farmad', '100 ml', 5, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `medicament_categorie`
--

CREATE TABLE IF NOT EXISTS `medicament_categorie` (
  `medicament_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`medicament_id`,`categorie_id`),
  KEY `IDX_96F20647AB0D61F7` (`medicament_id`),
  KEY `IDX_96F20647BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `medicament_categorie`
--

INSERT INTO `medicament_categorie` (`medicament_id`, `categorie_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

CREATE TABLE IF NOT EXISTS `prix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode` datetime NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `prix`
--

INSERT INTO `prix` (`id`, `periode`, `prix`) VALUES
(1, '2016-10-31 04:11:38', 3000),
(2, '2016-10-31 11:06:45', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `sorte`
--

CREATE TABLE IF NOT EXISTS `sorte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `sorte`
--

INSERT INTO `sorte` (`id`, `libelle`) VALUES
(1, 'Pile'),
(2, 'Sirop'),
(3, 'Gellule'),
(4, 'Injectable'),
(5, 'Poudre'),
(6, 'Crème');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medicament_id` int(11) DEFAULT NULL,
  `dateEntree` datetime NOT NULL,
  `datePeremption` datetime NOT NULL,
  `nombre` int(11) NOT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B365660AB0D61F7` (`medicament_id`),
  KEY `IDX_4B365660670C757F` (`fournisseur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `stock`
--

INSERT INTO `stock` (`id`, `medicament_id`, `dateEntree`, `datePeremption`, `nombre`, `fournisseur_id`) VALUES
(1, 1, '2016-10-05 00:00:00', '2017-03-31 00:00:00', 50, 3),
(2, 3, '2016-10-31 00:00:00', '2017-05-31 00:00:00', 10, 4);

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

CREATE TABLE IF NOT EXISTS `unite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valeur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `unite`
--

INSERT INTO `unite` (`id`, `type`, `valeur`) VALUES
(1, 'Plaquette', 10),
(2, 'Boite', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9B80EC6492FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_9B80EC64A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_9B80EC64C05FB297` (`confirmation_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(2, 'admin', 'admin', 'admin@admin.fr', 'admin@admin.fr', 1, 'ii378vp0ck0880400wg4sw0s00o0k4o', '$2y$13$GbTzspW5Vz0tTNw5HrcTd.QrZPPKwe9DKq90I1sXOEYmh7p/hvcLq', '2016-11-17 14:03:55', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL),
(3, 'Hanta', 'hanta', 'hanta@pharmacie-itokiana.mg', 'hanta@pharmacie-itokiana.mg', 1, 'srg24wo5z6s4w04gcwkwc8o4k88gc88', '$2y$13$mKYkyFSaXSw8bwqTo8pW2.8GoUXgOXVOQCkxGv/JKvCO4Git4UgUK', '2016-11-08 19:06:15', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_VENDEUR";}', 0, NULL),
(4, 'Hary', 'hary', 'hary@pharmacie-itokiana.mg', 'hary@pharmacie-itokiana.mg', 1, 'j1wwicilhuog48goo8c08o8g8k08kkw', '$2y$13$wbh6SlvXsj2scKDIFoVm5ernhsekq5zwBmlqDBvnx1G3hcCM6Yy32', '2016-11-08 19:07:27', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_VENDEUR";}', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE IF NOT EXISTS `vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `medicament_id` int(11) DEFAULT NULL,
  `daty` datetime NOT NULL,
  `personne` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prixUnitaire` int(11) NOT NULL,
  `nombre` int(11) NOT NULL,
  `somme` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_888A2A4CFB88E14F` (`utilisateur_id`),
  KEY `IDX_888A2A4CAB0D61F7` (`medicament_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `vente`
--

INSERT INTO `vente` (`id`, `utilisateur_id`, `medicament_id`, `daty`, `personne`, `prixUnitaire`, `nombre`, `somme`) VALUES
(1, 2, 1, '2016-11-17 20:51:38', 'Sandrine', 1000, 5, 5000),
(2, 2, 3, '2016-11-17 20:51:39', 'Sandrine', 5000, 3, 15000),
(3, 2, 3, '2016-11-17 20:54:54', 'Harry', 5000, 2, 10000);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD CONSTRAINT `FK_9A9C723AE54384C0` FOREIGN KEY (`sorte_id`) REFERENCES `sorte` (`id`),
  ADD CONSTRAINT `FK_9A9C723AEC4A74AB` FOREIGN KEY (`unite_id`) REFERENCES `unite` (`id`);

--
-- Contraintes pour la table `medicament_categorie`
--
ALTER TABLE `medicament_categorie`
  ADD CONSTRAINT `FK_96F20647AB0D61F7` FOREIGN KEY (`medicament_id`) REFERENCES `medicament` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_96F20647BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_4B365660670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur` (`id`),
  ADD CONSTRAINT `FK_4B365660AB0D61F7` FOREIGN KEY (`medicament_id`) REFERENCES `medicament` (`id`);

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `FK_888A2A4CAB0D61F7` FOREIGN KEY (`medicament_id`) REFERENCES `medicament` (`id`),
  ADD CONSTRAINT `FK_888A2A4CFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
