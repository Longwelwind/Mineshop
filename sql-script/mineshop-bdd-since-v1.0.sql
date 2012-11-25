-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 28 Août 2012 à 08:28
-- Version du serveur: 5.1.63-0+squeeze1
-- Version de PHP: 5.3.3-7+squeeze13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mysurvivalcraft_site`
--

-- --------------------------------------------------------

--
-- Structure de la table `shp_offers`
--

CREATE TABLE IF NOT EXISTS `shp_offers` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_category_id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `offer_price` int(11) NOT NULL,
  `offer_is_unique` tinyint(1) NOT NULL,
  `offer_time_required` int(11) NOT NULL,
  `offer_offer_required` int(11) NOT NULL,
  `offer_can_pay_with_time` tinyint(1) NOT NULL,
  PRIMARY KEY (`offer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `shp_offers_categories`
--

CREATE TABLE IF NOT EXISTS `shp_offers_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `shp_offers_elements`
--

CREATE TABLE IF NOT EXISTS `shp_offers_elements` (
  `element_id` int(11) NOT NULL AUTO_INCREMENT,
  `element_type` int(11) NOT NULL,
  `element_args` varchar(255) NOT NULL,
  `offer_id` int(11) NOT NULL,
  PRIMARY KEY (`element_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `shp_offers_history`
--

CREATE TABLE IF NOT EXISTS `shp_offers_history` (
  `offer_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `offer_history_time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`offer_history_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shp_payements`
--

CREATE TABLE IF NOT EXISTS `shp_payements` (
  `payement_id` int(11) NOT NULL AUTO_INCREMENT,
  `payement_name` varchar(255) NOT NULL,
  `payement_token_reward` int(11) NOT NULL,
  `payement_type` int(11) NOT NULL,
  `payement_args` varchar(255) NOT NULL,
  PRIMARY KEY (`payement_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Structure de la table `shp_payements_history`
--

CREATE TABLE IF NOT EXISTS `shp_payements_history` (
  `payement_id` int(11) NOT NULL AUTO_INCREMENT,
  `payement_keyid` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `payement_time` int(11) NOT NULL,
  `payement_offer_id` int(11) NOT NULL,
  PRIMARY KEY (`payement_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `shp_servers`
--

CREATE TABLE IF NOT EXISTS `shp_servers` (
  `server_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(255) NOT NULL,
  `server_host` varchar(255) NOT NULL,
  `server_port` int(11) NOT NULL,
  `server_password` varchar(255) NOT NULL,
  PRIMARY KEY (`server_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shp_sessions`
--

CREATE TABLE IF NOT EXISTS `shp_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shp_users`
--

CREATE TABLE IF NOT EXISTS `shp_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_count_tokens` int(11) NOT NULL,
  `user_register_time` int(11) NOT NULL,
  `user_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
