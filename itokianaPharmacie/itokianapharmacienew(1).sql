-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Dim 15 Janvier 2017 à 07:52
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `itokianapharmacie`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `fournisseur` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `libelle`, `numero`) VALUES
(1, 'OPHAM', NULL),
(2, 'NCPC', NULL),
(3, 'DROGEMAD', NULL),
(4, 'SOPHARMAD', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

CREATE TABLE `medicament` (
  `id` int(11) NOT NULL,
  `unite_id` int(11) DEFAULT NULL,
  `sorte_id` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL,
  `picture_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `medicament`
--

INSERT INTO `medicament` (`id`, `unite_id`, `sorte_id`, `prix`, `libelle`, `dose`, `nombre`, `picture_name`) VALUES
(1, 1, 1, 1000, 'Vitamine C', '500 mg', 45, 'Delire at home (3).jpg'),
(3, 2, 2, 5000, 'Farmad', '100 ml', 0, NULL),
(4, 2, 1, 250, 'Paracetamol', '500mg', 52, 'paracetamol.jpg'),
(5, 2, 1, 500, 'teste', '500mg', 2, 'paracetamol.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `medicament_categorie`
--

CREATE TABLE `medicament_categorie` (
  `medicament_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `medicament_categorie`
--

INSERT INTO `medicament_categorie` (`medicament_id`, `categorie_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `sorte`
--

CREATE TABLE `sorte` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `medicament_id` int(11) DEFAULT NULL,
  `dateEntree` datetime NOT NULL,
  `datePeremption` datetime NOT NULL,
  `nombre` int(11) NOT NULL,
  `fournisseur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `unite` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
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
  `nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_entree` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `nom`, `description`, `date_entree`, `date_sortie`) VALUES
(2, 'admin', 'admin', 'admin@admin.fr', 'admin@admin.fr', 1, 'ii378vp0ck0880400wg4sw0s00o0k4o', '$2y$13$cT5WRonFtCDJ0evl.c2TBeJQMje3n7mDYep1vmgsNOco1M0SDALJO', '2017-01-15 07:33:21', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, NULL, NULL, NULL, NULL),
(3, 'Hanta', 'hanta', 'hanta@pharmacie-itokiana.mg', 'hanta@pharmacie-itokiana.mg', 1, 'srg24wo5z6s4w04gcwkwc8o4k88gc88', '$2y$13$mKYkyFSaXSw8bwqTo8pW2.8GoUXgOXVOQCkxGv/JKvCO4Git4UgUK', '2016-11-08 19:06:15', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_VENDEUR";}', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'Hary', 'hary', 'hary@pharmacie-itokiana.mg', 'hary@pharmacie-itokiana.mg', 1, 'j1wwicilhuog48goo8c08o8g8k08kkw', '$2y$13$wbh6SlvXsj2scKDIFoVm5ernhsekq5zwBmlqDBvnx1G3hcCM6Yy32', '2017-01-14 21:33:48', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_VENDEUR";}', 0, NULL, NULL, NULL, NULL, NULL),
(5, 'teste', 'teste', 'teste@teste.com', 'teste@teste.com', 1, '6hrsdgq5fj0ggco0s4w08kk0cs0c0wo', '$2y$13$u3OC2zYBkpA7.a6GgK5rluizq8VvLY3zAQXetGrJdvdXHO5.sPlX6', '2017-01-14 21:27:39', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `medicament_id` int(11) DEFAULT NULL,
  `daty` datetime NOT NULL,
  `personne` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prixUnitaire` int(11) NOT NULL,
  `nombre` int(11) NOT NULL,
  `somme` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `vente`
--

INSERT INTO `vente` (`id`, `utilisateur_id`, `medicament_id`, `daty`, `personne`, `prixUnitaire`, `nombre`, `somme`) VALUES
(1, 2, 1, '2016-11-17 20:51:38', 'Sandrine', 1000, 5, 5000),
(2, 2, 3, '2016-11-17 20:51:39', 'Sandrine', 5000, 3, 15000),
(3, 2, 3, '2016-11-17 20:54:54', 'Harry', 5000, 2, 10000),
(4, 2, 3, '2016-11-27 09:00:34', 'Harry', 5000, 1, 5000),
(5, 2, 3, '2016-11-27 09:04:38', 'Harry', 5000, 4, 20000),
(6, 2, 4, '2016-11-27 14:36:08', 'Harry', 250, 2, 500);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9A9C723AEC4A74AB` (`unite_id`),
  ADD KEY `IDX_9A9C723AE54384C0` (`sorte_id`);

--
-- Index pour la table `medicament_categorie`
--
ALTER TABLE `medicament_categorie`
  ADD PRIMARY KEY (`medicament_id`,`categorie_id`),
  ADD KEY `IDX_96F20647AB0D61F7` (`medicament_id`),
  ADD KEY `IDX_96F20647BCF5E72D` (`categorie_id`);

--
-- Index pour la table `sorte`
--
ALTER TABLE `sorte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B365660AB0D61F7` (`medicament_id`),
  ADD KEY `IDX_4B365660670C757F` (`fournisseur_id`);

--
-- Index pour la table `unite`
--
ALTER TABLE `unite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9B80EC6492FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_9B80EC64A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_9B80EC64C05FB297` (`confirmation_token`),
  ADD UNIQUE KEY `UNIQ_9B80EC646C6E55B5` (`nom`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_888A2A4CFB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_888A2A4CAB0D61F7` (`medicament_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `medicament`
--
ALTER TABLE `medicament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `sorte`
--
ALTER TABLE `sorte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `unite`
--
ALTER TABLE `unite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
