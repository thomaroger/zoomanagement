-- phpMyAdmin SQL Dump
-- version 3.2.0-rc1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 09 Avril 2010 à 15:23
-- Version du serveur: 5.1.37
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

set character_set_database ='utf8';

--
-- Base de données: `tootlist`
--

-- --------------------------------------------------------

--
-- Structure de la table `bookmark`
--

CREATE TABLE IF NOT EXISTS `bookmark` (
  `item_idItem` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` text,
  `picture` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_bookmark_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion bookmark';

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `idcategories` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `tags` text,
  `categorie_idcategories` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcategories`),
  KEY `fk_categorie_categorie1` (`categorie_idcategories`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion catégories' AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `item_idItem` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(3) NOT NULL,
  `woeid` varchar(255) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_city_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion ville meteo';

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `idConfiguration` int(11) NOT NULL AUTO_INCREMENT,
  `help` text,
  `language` varchar(2) DEFAULT NULL,
  `forbidden_word` text NOT NULL,
  `profile` text,
  `quota_list_user` int(11) DEFAULT '0',
  `quota_list_user_parent` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idConfiguration`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion configuration application' AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- Structure de la table `css`
--

CREATE TABLE IF NOT EXISTS `css` (
  `item_idItem` int(11) NOT NULL,
  `idCSS` int(11) NOT NULL,
  PRIMARY KEY (`item_idItem`,`idCSS`),
  KEY `fk_css_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion css ';

-- --------------------------------------------------------

--
-- Structure de la table `directory`
--

CREATE TABLE IF NOT EXISTS `directory` (
  `item_idItem` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `business_phone` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email2` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_directory_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion repertoire telephonique';

-- --------------------------------------------------------

--
-- Structure de la table `disable`
--

CREATE TABLE IF NOT EXISTS `disable` (
  `item_idItem` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_disable_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `item_idItem` int(11) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_document_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion document';

-- --------------------------------------------------------

--
-- Structure de la table `envie`
--

CREATE TABLE IF NOT EXISTS `envie` (
  `item_idItem` int(11) NOT NULL,
  `description` text,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_envie_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `item_idItem` int(11) NOT NULL,
  `date_begin` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `description` text,
  `location` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_event_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion evenements';

-- --------------------------------------------------------

--
-- Structure de la table `fight`
--

CREATE TABLE IF NOT EXISTS `fight` (
  `idFIGHT` int(11) NOT NULL AUTO_INCREMENT,
  `pkmn_user_item_idItem` int(11) NOT NULL,
  `pkmn_user_item_idItem1` int(11) NOT NULL,
  PRIMARY KEY (`idFIGHT`),
  KEY `fk_fight_pkmn_user1` (`pkmn_user_item_idItem`),
  KEY `fk_fight_pkmn_user2` (`pkmn_user_item_idItem1`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion combat' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `item_idItem` int(11) NOT NULL,
  `id_user` varchar(45) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_friends_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion amis';

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `idItem` int(11) NOT NULL AUTO_INCREMENT,
  `list_idList` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `type_idtype` int(11) NOT NULL,
  PRIMARY KEY (`idItem`),
  KEY `fk_item_list1` (`list_idList`),
  KEY `fk_item_type1` (`type_idtype`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Table qui va gérer les items' AUTO_INCREMENT=395 ;

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `idList` int(11) NOT NULL AUTO_INCREMENT,
  `list_idList` int(11) NOT NULL,
  `nb_duplication` int(11) NOT NULL,
  `nb_view` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `categorie_idcategories` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `permission` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idList`),
  KEY `fk_list_list1` (`list_idList`),
  KEY `fk_list_categorie1` (`categorie_idcategories`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion liste' AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `description` text,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idLog`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion Logs' AUTO_INCREMENT=964 ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `item_idItem` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipients_id` text,
  `description` text,
  `state` text NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_message_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion message';

-- --------------------------------------------------------

--
-- Structure de la table `metadata`
--

CREATE TABLE IF NOT EXISTS `metadata` (
  `idMetadata` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idMetadata`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion des creations, modifications' AUTO_INCREMENT=1434 ;

-- --------------------------------------------------------

--
-- Structure de la table `model`
--

CREATE TABLE IF NOT EXISTS `model` (
  `idModel` int(11) NOT NULL AUTO_INCREMENT,
  `isbase` tinyint(1) DEFAULT 0,
  `islist` tinyint(1) DEFAULT NULL,
  `libelle_fr` varchar(255) NOT NULL,
  `libelle_en` varchar(255) NOT NULL,
  `model_id` int(11) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idModel`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion model' AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `item_idItem` int(11) NOT NULL,
  `description` text,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_movie_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion des movie';

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `item_idItem` int(11) NOT NULL,
  `description` text,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_music_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification_p`
--

CREATE TABLE IF NOT EXISTS `notification_p` (
  `item_idItem` int(11) NOT NULL,
  `click` tinyint(1) DEFAULT NULL,
  `description` text,
  `lu` tinyint(4) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_notification_p_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion notifications';

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `item_idItem` int(11) NOT NULL,
  `description` text,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_new` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_picture_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion image';

-- --------------------------------------------------------

--
-- Structure de la table `pkmn_stock`
--

CREATE TABLE IF NOT EXISTS `pkmn_stock` (
  `item_idItem` int(11) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_pkmn_stock_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion pokemon sauvage';

-- --------------------------------------------------------

--
-- Structure de la table `pkmn_user`
--

CREATE TABLE IF NOT EXISTS `pkmn_user` (
  `item_idItem` int(11) NOT NULL,
  `pokemon_idPokemon` int(11) NOT NULL,
   `first` BINARY( 1 ) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_idItem`),
  KEY `fk_pkmn_user_item1` (`item_idItem`),
  KEY `fk_id_pokemon` (`pokemon_idPokemon`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion pokemon user';

-- --------------------------------------------------------

--
-- Structure de la table `pokemon`
--

CREATE TABLE IF NOT EXISTS `pokemon` (
  `id` smallint(3) NOT NULL DEFAULT '0',
  `name_en` varchar(20) NOT NULL DEFAULT '',
  `name_fr` varchar(255) DEFAULT NULL,
  `evo_chain_id` smallint(3) unsigned NOT NULL DEFAULT '0',
  `evo_parent_id` smallint(3) NOT NULL,
  `evo_param` varchar(32) NOT NULL,
  `type1` varchar(8) NOT NULL DEFAULT '',
  `type2` varchar(8) DEFAULT NULL,
  `species` varchar(16) NOT NULL,
  `stat_at` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stat_de` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stat_sa` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stat_sd` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stat_sp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stat_hp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `effort` varchar(6) NOT NULL DEFAULT '',
  `gameshark_rby` tinyint(3) unsigned DEFAULT NULL,
  `base_exp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `gender_rate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `base_happiness` tinyint(3) unsigned NOT NULL,
  `real_pokemon_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ATTACK` (`stat_at`),
  KEY `DEFENSE` (`stat_de`),
  KEY `SPATTACK` (`stat_sa`),
  KEY `SPDEFENSE` (`stat_sd`),
  KEY `SPEED` (`stat_sp`),
  KEY `HP` (`stat_hp`),
  KEY `REALID` (`real_pokemon_id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `priority`
--

CREATE TABLE IF NOT EXISTS `priority` (
  `item_idItem` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_priority_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion priorité';

-- --------------------------------------------------------

--
-- Structure de la table `private_message`
--

CREATE TABLE IF NOT EXISTS `private_message` (
  `item_idItem` int(11) NOT NULL,
  `description` text,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_private_message_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion messages chat';

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `item_idItem` int(11) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_product_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion produit';

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE IF NOT EXISTS `profil` (
  `item_idItem` int(11) NOT NULL,
  `property` varchar(255) DEFAULT NULL,
  `value` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_profil_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion profil : Ajout des proprietes dans la BO';

-- --------------------------------------------------------

--
-- Structure de la table `property`
--

CREATE TABLE IF NOT EXISTS `property` (
  `idProperty` int(11) NOT NULL AUTO_INCREMENT,
  `css_item_idItem` int(11) NOT NULL,
  `css_idCSS` int(11) NOT NULL,
  PRIMARY KEY (`idProperty`,`css_item_idItem`,`css_idCSS`),
  KEY `fk_property_css1` (`css_item_idItem`,`css_idCSS`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion css property' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `publicite`
--

CREATE TABLE IF NOT EXISTS `publicite` (
  `idPublicite` int(11) NOT NULL AUTO_INCREMENT,
  `date_deb` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `name_contact` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idPublicite`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion publicite' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `item_idItem` int(11) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_purchase_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion achats';

-- --------------------------------------------------------

--
-- Structure de la table `recall`
--

CREATE TABLE IF NOT EXISTS `recall` (
  `item_idItem` int(11) NOT NULL,
  `Event_idEvent` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `timescale` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_idItem`),
  KEY `fk_recall_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion  rappels';

-- --------------------------------------------------------

--
-- Structure de la table `sauvegarde`
--

CREATE TABLE IF NOT EXISTS `sauvegarde` (
  `idSauvegarde` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idSauvegarde`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion sauvegarde' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `statut_g`
--

CREATE TABLE IF NOT EXISTS `statut_g` (
  `idstatut_g` int(11) NOT NULL AUTO_INCREMENT,
  `structure_idStructure` int(11) NOT NULL,
  `item_idItem` int(11) NOT NULL,
  PRIMARY KEY (`idstatut_g`),
  KEY `fk_statut_g_structure1` (`structure_idStructure`),
  KEY `fk_statut_g_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion statut général' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `statut_p`
--

CREATE TABLE IF NOT EXISTS `statut_p` (
  `idstatut_p` int(11) NOT NULL AUTO_INCREMENT,
  `statut` tinyint(4) DEFAULT NULL,
  `item_idItem` int(11) NOT NULL,
  `user_idUser` int(11) NOT NULL,
  PRIMARY KEY (`idstatut_p`),
  KEY `fk_statut_p_item1` (`item_idItem`),
  KEY `fk_statut_p_user1` (`user_idUser`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Associer utilisateur item ou structure' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `structure`
--

CREATE TABLE IF NOT EXISTS `structure` (
  `idStructure` int(11) NOT NULL AUTO_INCREMENT,
  `list_idList` int(11) NOT NULL,
  PRIMARY KEY (`idStructure`),
  KEY `fk_structure_list1` (`list_idList`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion structure d''une liste' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `structure_p`
--

CREATE TABLE IF NOT EXISTS `structure_p` (
  `item_idItem` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  KEY `fk_structure_p_item` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `item_idItem` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `check` tinyint(1) DEFAULT NULL,
  `description` text,
  `withdrawal` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_todo_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion de todo';

-- --------------------------------------------------------


-- ---------------------------------------------------------
--
-- Structure de la table youtube --
--
CREATE TABLE IF NOT EXISTS `youtube` (
  `item_idItem` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_youtube_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion youtube';

--
-- Structure de la table deezer --
--
CREATE TABLE IF NOT EXISTS `deezer` (
  `item_idItem` int(11) NOT NULL,
  `title` varchar(255)  NULL,
  `description` text  NULL,
  `url` varchar(255)  NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_deezer_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion deezer';


--
-- structure de la table dailymotion
--

CREATE TABLE IF NOT EXISTS `dailymotion` (
  `item_idItem` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_idItem`),
  KEY `fk_dailymotion_item1` (`item_idItem`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion dailymotion';

-- ---------------------------------------------------------
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `idtype` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idtype`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion type item' AUTO_INCREMENT=448 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `first` tinyint(1) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL,
  `quota_list` int(11) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `privilege` tinyint(1) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB  CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion utilisateur' AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_has_list`
--

CREATE TABLE IF NOT EXISTS `user_has_list` (
  `user_idUser` int(11) NOT NULL,
  `list_idList` int(11) NOT NULL,
  KEY `fk_user_has_list_user1` (`user_idUser`),
  KEY `fk_user_has_list_list1` (`list_idList`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Liaison user list';

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `fk_bookmark_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `fk_categorie_categorie1` FOREIGN KEY (`categorie_idcategories`) REFERENCES `categorie` (`idcategories`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `fk_city_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `css`
--
ALTER TABLE `css`
  ADD CONSTRAINT `fk_css_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `directory`
--
ALTER TABLE `directory`
  ADD CONSTRAINT `fk_directory_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `disable`
--
ALTER TABLE `disable`
  ADD CONSTRAINT `fk_disable_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `fk_document_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `envie`
--
ALTER TABLE `envie`
  ADD CONSTRAINT `fk_envie_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `fight`
--
ALTER TABLE `fight`
  ADD CONSTRAINT `fk_fight_pkmn_user1` FOREIGN KEY (`pkmn_user_item_idItem`) REFERENCES `pkmn_user` (`item_idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fight_pkmn_user2` FOREIGN KEY (`pkmn_user_item_idItem1`) REFERENCES `pkmn_user` (`item_idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `fk_friends_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_item_list1` FOREIGN KEY (`list_idList`) REFERENCES `list` (`idList`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_type1` FOREIGN KEY (`type_idtype`) REFERENCES `type` (`idtype`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `fk_list_categorie1` FOREIGN KEY (`categorie_idcategories`) REFERENCES `categorie` (`idcategories`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `fk_movie_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `fk_music_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `notification_p`
--
ALTER TABLE `notification_p`
  ADD CONSTRAINT `fk_notification_p_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `fk_picture_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `pkmn_stock`
--
ALTER TABLE `pkmn_stock`
  ADD CONSTRAINT `fk_pkmn_stock_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `pkmn_user`
--
ALTER TABLE `pkmn_user`
  ADD CONSTRAINT `fk_pkmn_user_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `priority`
--
ALTER TABLE `priority`
  ADD CONSTRAINT `fk_priority_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `private_message`
--
ALTER TABLE `private_message`
  ADD CONSTRAINT `fk_private_message_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `fk_profil_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `fk_property_css1` FOREIGN KEY (`css_item_idItem`, `css_idCSS`) REFERENCES `css` (`item_idItem`, `idCSS`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk_purchase_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `recall`
--
ALTER TABLE `recall`
  ADD CONSTRAINT `fk_recall_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `statut_g`
--
ALTER TABLE `statut_g`
  ADD CONSTRAINT `fk_statut_g_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_statut_g_structure1` FOREIGN KEY (`structure_idStructure`) REFERENCES `structure` (`idStructure`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `statut_p`
--
ALTER TABLE `statut_p`
  ADD CONSTRAINT `fk_statut_p_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_statut_p_user1` FOREIGN KEY (`user_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `structure`
--
ALTER TABLE `structure`
  ADD CONSTRAINT `fk_structure_list1` FOREIGN KEY (`list_idList`) REFERENCES `list` (`idList`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `structure_p`
--
ALTER TABLE `structure_p`
  ADD CONSTRAINT `fk_structure_p_item` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `fk_todo_item1` FOREIGN KEY (`item_idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_has_list`
--
ALTER TABLE `user_has_list`
  ADD CONSTRAINT `fk_user_has_list_list1` FOREIGN KEY (`list_idList`) REFERENCES `list` (`idList`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_list_user1` FOREIGN KEY (`user_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;
  
  
ALTER TABLE  `document` ADD  `title` VARCHAR( 255 ) NULL ,
ADD  `description` TEXT NULL ,
ADD  `url` VARCHAR( 255 ) NULL;



