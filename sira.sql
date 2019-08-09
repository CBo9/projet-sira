-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 09 Août 2019 à 09:44
-- Version du serveur :  5.6.37
-- Version de PHP :  7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sira`
--

-- --------------------------------------------------------

--
-- Structure de la table `agences`
--

CREATE TABLE IF NOT EXISTS `agences` (
  `id_agence` int(11) NOT NULL,
  `titreA` varchar(200) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `cp` int(6) DEFAULT NULL,
  `descriptionA` text,
  `photoA` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `agences`
--

INSERT INTO `agences` (`id_agence`, `titreA`, `adresse`, `ville`, `cp`, `descriptionA`, `photoA`) VALUES
(1, 'Localoc Bordeaux', '15 rue Aristide Maillol', 'Bordeaux', 33000, 'Une jolie agence située à Bordeaux', 'Desert.jpg'),
(3, 'Paris-Champs-Elysées', 'avenue des Champs-Elysées', 'Paris', 75000, 'Des voitures luxueuses par centaines', 'Koala.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(4) NOT NULL,
  `id_membre` int(4) NOT NULL,
  `id_vehicule` int(4) NOT NULL,
  `id_agence` int(4) NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_fin` datetime NOT NULL,
  `prix_total` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `pseudo` varchar(30) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `statut` varchar(10) NOT NULL DEFAULT 'client',
  `mdp` varchar(200) DEFAULT NULL,
  `civilite` varchar(4) DEFAULT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `nom`, `prenom`, `pseudo`, `mail`, `statut`, `mdp`, `civilite`, `date_inscription`, `type`) VALUES
(3, 'kuyg', 'iuyg', 'iuyg', 'iuyg', 'client', '45120a603b2b8d48b1e918a080f24a', NULL, '2019-08-07 15:30:39', 'particulier'),
(4, 'iuyhoiuhy', 'oiuy', 'oiuy', 'oiuy', 'client', 'bd972929b3131ad6872146aa810ae3', NULL, '2019-08-07 15:31:09', 'particulier'),
(5, 'pi_uhy', 'oiuh', 'iuh', 'oiuh', 'client', '5e71146058ba3ecb19ccd623085b97', 'Mr', '2019-08-07 15:31:52', 'pro'),
(6, 'poiuh', 'oiuh', 'oiuh', 'lkuhliu', 'client', 'cc02c544c2197532fe0fc23ac7acfa', 'Mme', '2019-08-07 15:32:56', 'pro'),
(7, 'aaza', 'aaza', 'aaza', 'aaza', 'admin', 'b7efef83d33e3ce64b3c7758743fc418', 'Mr', '2019-08-08 15:01:39', 'pro'),
(8, 'aaa', 'aaa', 'aaa', 'aaa', 'client', '47bce5c74f589f4867dbd57e9ca9f808', 'Mme', '2019-08-09 11:08:43', 'pro');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE IF NOT EXISTS `vehicule` (
  `id_vehicule` int(4) NOT NULL,
  `id_agence` int(4) DEFAULT NULL,
  `titreV` varchar(200) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `descriptionV` text,
  `photoV` varchar(200) DEFAULT NULL,
  `prix_journalier` int(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `id_agence`, `titreV`, `marque`, `modele`, `descriptionV`, `photoV`, `prix_journalier`) VALUES
(3, 1, 'BMW Série 3', 'BMW', 'Série 3', 'Super', 'Tulips.jpg', 50),
(4, 3, 'BMW Série 4', 'BMW', 'Série 4', 'Vraiment super', 'Jellyfish.jpg', 60);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `agences`
--
ALTER TABLE `agences`
  ADD PRIMARY KEY (`id_agence`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD KEY `id_membre` (`id_membre`),
  ADD KEY `id_vehicule` (`id_vehicule`),
  ADD KEY `id_agence` (`id_agence`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `agences`
--
ALTER TABLE `agences`
  MODIFY `id_agence` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
