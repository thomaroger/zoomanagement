SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `tootlist` ;
CREATE SCHEMA IF NOT EXISTS `tootlist` DEFAULT CHARACTER SET latin1 ;
USE `tootlist`;

-- -----------------------------------------------------
-- Table `tootlist`.`categorie`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`categorie` (
  `idcategories` INT(11) NOT NULL AUTO_INCREMENT ,
  `description` TEXT NULL DEFAULT NULL ,
  `title_fr` VARCHAR(255) NULL DEFAULT NULL ,
  `title_en` VARCHAR(255) NULL DEFAULT NULL ,
  `tags` TEXT NULL DEFAULT NULL ,
  `categorie_idcategories` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`idcategories`) ,
  INDEX `fk_categorie_categorie1` (`categorie_idcategories` ASC) ,
  CONSTRAINT `fk_categorie_categorie1`
    FOREIGN KEY (`categorie_idcategories` )
    REFERENCES `tootlist`.`categorie` (`idcategories` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion catégories';

-- -----------------------------------------------------
-- Table `tootlist`.`pokemon`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`pokemon` (
  `id` SMALLINT(3) NOT NULL DEFAULT '0' ,
  `name_en` VARCHAR(20) NOT NULL DEFAULT '' ,
  `name_fr` VARCHAR(255) NULL DEFAULT NULL ,
  `evo_chain_id` SMALLINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `evo_parent_id` SMALLINT(3) NOT NULL ,
  `evo_param` VARCHAR(32) NOT NULL ,
  `type1` VARCHAR(8) NOT NULL DEFAULT '' ,
  `type2` VARCHAR(8) NULL DEFAULT NULL ,
  `species` VARCHAR(16) NOT NULL ,
  `stat_at` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `stat_de` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `stat_sa` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `stat_sd` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `stat_sp` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `stat_hp` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `effort` VARCHAR(6) NOT NULL DEFAULT '' ,
  `gameshark_rby` TINYINT(3) UNSIGNED NULL DEFAULT NULL ,
  `base_exp` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `gender_rate` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `base_happiness` TINYINT(3) UNSIGNED NOT NULL ,
  `real_pokemon_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `ATTACK` (`stat_at` ASC) ,
  INDEX `DEFENSE` (`stat_de` ASC) ,
  INDEX `SPATTACK` (`stat_sa` ASC) ,
  INDEX `SPDEFENSE` (`stat_sd` ASC) ,
  INDEX `SPEED` (`stat_sp` ASC) ,
  INDEX `HP` (`stat_hp` ASC) ,
  INDEX `REALID` USING BTREE (`real_pokemon_id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `tootlist`.`list`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`list` (
  `idList` INT(11) NOT NULL AUTO_INCREMENT ,
  `list_idList` INT(11) NOT NULL ,
  `nb_duplication` INT(11) NOT NULL ,
  `nb_view` INT(11) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `description` VARCHAR(255) NULL DEFAULT NULL ,
  `tag` VARCHAR(255) NULL DEFAULT NULL ,
  `categorie_idcategories` INT(11) NOT NULL ,
  `status` TINYINT( 1 ) NOT NULL DEFAULT  '1',
  PRIMARY KEY (`idList`) ,
  INDEX `fk_list_list1` (`list_idList` ASC) ,
  INDEX `fk_list_categorie1` (`categorie_idcategories` ASC) ,
  CONSTRAINT `fk_list_categorie1`
    FOREIGN KEY (`categorie_idcategories` )
    REFERENCES `tootlist`.`categorie` (`idcategories` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion liste';


-- -----------------------------------------------------
-- Table `tootlist`.`type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`type` (
  `idtype` INT(11) NOT NULL AUTO_INCREMENT ,
  `model_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`idtype`) )
ENGINE = InnoDB
AUTO_INCREMENT = 141
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion type item';


-- -----------------------------------------------------
-- Table `tootlist`.`item`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`item` (
  `idItem` INT(11) NOT NULL AUTO_INCREMENT ,
  `list_idList` INT(11) NOT NULL ,
  `position` INT(11) NULL DEFAULT NULL ,
  `type_idtype` INT(11) NOT NULL ,
  PRIMARY KEY (`idItem`) ,
  INDEX `fk_item_list1` (`list_idList` ASC) ,
  INDEX `fk_item_type1` (`type_idtype` ASC) ,
  CONSTRAINT `fk_item_list1`
    FOREIGN KEY (`list_idList` )
    REFERENCES `tootlist`.`list` (`idList` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_type1`
    FOREIGN KEY (`type_idtype` )
    REFERENCES `tootlist`.`type` (`idtype` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 91
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table qui va gérer les items';


-- -----------------------------------------------------
-- Table `tootlist`.`bookmark`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`bookmark` (
  `item_idItem` INT(11) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `link` VARCHAR(255) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `picture` VARCHAR(255) NULL DEFAULT NULL ,
  `tags` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_bookmark_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_bookmark_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion bookmark';


-- -----------------------------------------------------
-- Table `tootlist`.`city`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`city` (
  `item_idItem` INT(11) NOT NULL ,
  `city` VARCHAR(255) NULL DEFAULT NULL ,
  `postalcode` VARCHAR(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_city_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_city_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion ville meteo';


-- -----------------------------------------------------
-- Table `tootlist`.`configuration`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`configuration` (
  `idConfiguration` INT(11) NOT NULL AUTO_INCREMENT ,
  `help` TEXT NULL DEFAULT NULL ,
  `language` VARCHAR(2) NULL DEFAULT NULL ,
  `profile` TEXT NULL DEFAULT NULL ,
  `quota_list_user` INT(11) NULL DEFAULT '0' ,
  `quota_list_user_parent` INT(11) NULL DEFAULT '0' ,
  `status` TINYINT(1) NULL DEFAULT NULL ,
  PRIMARY KEY (`idConfiguration`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion configuration application';


-- -----------------------------------------------------
-- Table `tootlist`.`css`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`css` (
  `item_idItem` INT(11) NOT NULL ,
  `idCSS` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`, `idCSS`) ,
  INDEX `fk_css_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_css_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion css ';


-- -----------------------------------------------------
-- Table `tootlist`.`directory`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`directory` (
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_directory_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_directory_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion repertoire telephonique';


-- -----------------------------------------------------
-- Table `tootlist`.`disable`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`disable` (
  `item_idItem` INT(11) NOT NULL ,
  `status` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_disable_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_disable_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tootlist`.`document`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`document` (
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_document_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_document_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion document';


-- -----------------------------------------------------
-- Table `tootlist`.`envie`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`envie` (
  `item_idItem` INT(11) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_envie_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_envie_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tootlist`.`event`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`event` (
  `item_idItem` INT(11) NOT NULL ,
  `date_begin` DATETIME NULL DEFAULT NULL ,
  `date_end` DATETIME NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `location` VARCHAR(255) NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_event_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_event_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion evenements';


-- -----------------------------------------------------
-- Table `tootlist`.`pkmn_user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`pkmn_user` (
  `item_idItem` INT(11) NOT NULL ,
  `pokemon_idPokemon` INT(11) NOT NULL,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_pkmn_user_item1` (`item_idItem` ASC) ,
  INDEX `fk_id_pokemon`(`pokemon_idPokemon` ASC),
  CONSTRAINT `fk_pkmn_user_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion pokemon user';


-- -----------------------------------------------------
-- Table `tootlist`.`fight`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`fight` (
  `idFIGHT` INT(11) NOT NULL AUTO_INCREMENT ,
  `pkmn_user_item_idItem` INT(11) NOT NULL ,
  `pkmn_user_item_idItem1` INT(11) NOT NULL ,
  PRIMARY KEY (`idFIGHT`) ,
  INDEX `fk_fight_pkmn_user1` (`pkmn_user_item_idItem` ASC) ,
  INDEX `fk_fight_pkmn_user2` (`pkmn_user_item_idItem1` ASC) ,
  CONSTRAINT `fk_fight_pkmn_user1`
    FOREIGN KEY (`pkmn_user_item_idItem` )
    REFERENCES `tootlist`.`pkmn_user` (`item_idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fight_pkmn_user2`
    FOREIGN KEY (`pkmn_user_item_idItem1` )
    REFERENCES `tootlist`.`pkmn_user` (`item_idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion combat';


-- -----------------------------------------------------
-- Table `tootlist`.`friends`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`friend` (
  `item_idItem` INT(11) NOT NULL ,
  `id_user` VARCHAR(45) NULL DEFAULT NULL ,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_friends_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_friends_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion amis';


-- -----------------------------------------------------
-- Table `tootlist`.`log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`log` (
  `idLog` INT(11) NOT NULL AUTO_INCREMENT ,
  `model_id` INT(11) NULL DEFAULT NULL ,
  `record_id` INT(11) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`idLog`) )
ENGINE = InnoDB
AUTO_INCREMENT = 190
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion Logs';


-- -----------------------------------------------------
-- Table `tootlist`.`message`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`message` (
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_message_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_message_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion message';


-- -----------------------------------------------------
-- Table `tootlist`.`metadata`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`metadata` (
  `idMetadata` INT(11) NOT NULL AUTO_INCREMENT ,
  `model_id` INT(11) NULL DEFAULT NULL ,
  `record_id` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idMetadata`) )
ENGINE = InnoDB
AUTO_INCREMENT = 301
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion des creations, modifications';


-- -----------------------------------------------------
-- Table `tootlist`.`model`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`model` (
  `idModel` INT(11) NOT NULL AUTO_INCREMENT ,
  `islist` TINYINT(1) NULL DEFAULT NULL ,
  `libelle_fr` VARCHAR(255) NOT NULL ,
  `libelle_en` VARCHAR(255) NOT NULL ,
  `model_id` INT(11) NULL DEFAULT NULL ,
  `table_name` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`idModel`) )
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion model';


-- -----------------------------------------------------
-- Table `tootlist`.`movie`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`movie` (
  `item_idItem` INT(11) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `url` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_movie_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_movie_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion des movie';


-- -----------------------------------------------------
-- Table `tootlist`.`music`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`music` (
  `item_idItem` INT(11) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `url` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_music_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_music_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tootlist`.`notification_p`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`notification_p` (
  `item_idItem` INT(11) NOT NULL ,
  `click` TINYINT(1) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `lu` tinyint(4) NOT NULL,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_notification_p_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_notification_p_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion notifications';

-- -----------------------------------------------------
-- Table `tootlist`.`picture`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`picture` (
  `item_idItem` INT(11) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `url` VARCHAR(255) NULL DEFAULT NULL ,
  `url_new` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_picture_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_picture_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion image';


-- -----------------------------------------------------
-- Table `tootlist`.`pkmn_stock`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`pkmn_stock` (
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_pkmn_stock_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_pkmn_stock_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion pokemon sauvage';




-- -----------------------------------------------------
-- Table `tootlist`.`priority`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`priority` (
  `item_idItem` INT(11) NOT NULL ,
  `status` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_priority_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_priority_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion priorité';


-- -----------------------------------------------------
-- Table `tootlist`.`private_message`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`private_message` (
  `item_idItem` INT(11) NOT NULL ,
  `date` DATETIME NULL DEFAULT NULL ,
  `user_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_private_message_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_private_message_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion messages chat';


-- -----------------------------------------------------
-- Table `tootlist`.`product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`product` (
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_product_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_product_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion produit';


-- -----------------------------------------------------
-- Table `tootlist`.`profil`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`profil` (
  `item_idItem` INT(11) NOT NULL ,
  `property` VARCHAR(255) NULL DEFAULT NULL ,
  `value` VARCHAR(225) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_profil_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_profil_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion profil : Ajout des proprietes dans la BO';


-- -----------------------------------------------------
-- Table `tootlist`.`property`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`property` (
  `idProperty` INT(11) NOT NULL AUTO_INCREMENT ,
  `css_item_idItem` INT(11) NOT NULL ,
  `css_idCSS` INT(11) NOT NULL ,
  PRIMARY KEY (`idProperty`, `css_item_idItem`, `css_idCSS`) ,
  INDEX `fk_property_css1` (`css_item_idItem` ASC, `css_idCSS` ASC) ,
  CONSTRAINT `fk_property_css1`
    FOREIGN KEY (`css_item_idItem` , `css_idCSS` )
    REFERENCES `tootlist`.`css` (`item_idItem` , `idCSS` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion css property';


-- -----------------------------------------------------
-- Table `tootlist`.`publicite`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`publicite` (
  `idPublicite` INT(11) NOT NULL AUTO_INCREMENT ,
  `date_deb` DATE NULL DEFAULT NULL ,
  `date_end` DATE NULL DEFAULT NULL ,
  `description` VARCHAR(255) NULL DEFAULT NULL ,
  `link` VARCHAR(255) NULL DEFAULT NULL ,
  `name_contact` VARCHAR(255) NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  `position` INT(11) NULL DEFAULT NULL ,
  `status` TINYINT(1) NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `type` TINYINT(1) NULL DEFAULT NULL ,
  PRIMARY KEY (`idPublicite`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion publicite';


-- -----------------------------------------------------
-- Table `tootlist`.`purchase`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`purchase` (
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_purchase_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_purchase_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion achats';


-- -----------------------------------------------------
-- Table `tootlist`.`recall`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`recall` (
  `item_idItem` INT(11) NOT NULL ,
  `number` INT(11) NULL DEFAULT NULL ,
  `type` TINYINT(4) NULL DEFAULT NULL ,
  `timescale` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_recall_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_recall_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion  rappels';


-- -----------------------------------------------------
-- Table `tootlist`.`sauvegarde`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`sauvegarde` (
  `idSauvegarde` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`idSauvegarde`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion sauvegarde';


-- -----------------------------------------------------
-- Table `tootlist`.`structure`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`structure` (
  `idStructure` INT(11) NOT NULL AUTO_INCREMENT ,
  `list_idList` INT(11) NOT NULL ,
  PRIMARY KEY (`idStructure`) ,
  INDEX `fk_structure_list1` (`list_idList` ASC) ,
  CONSTRAINT `fk_structure_list1`
    FOREIGN KEY (`list_idList` )
    REFERENCES `tootlist`.`list` (`idList` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion structure d\'une liste';


-- -----------------------------------------------------
-- Table `tootlist`.`statut_g`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`statut_g` (
  `idstatut_g` INT(11) NOT NULL AUTO_INCREMENT ,
  `structure_idStructure` INT(11) NOT NULL ,
  `item_idItem` INT(11) NOT NULL ,
  PRIMARY KEY (`idstatut_g`) ,
  INDEX `fk_statut_g_structure1` (`structure_idStructure` ASC) ,
  INDEX `fk_statut_g_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_statut_g_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_statut_g_structure1`
    FOREIGN KEY (`structure_idStructure` )
    REFERENCES `tootlist`.`structure` (`idStructure` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion statut général';


-- -----------------------------------------------------
-- Table `tootlist`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`user` (
  `idUser` INT(11) NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NULL DEFAULT NULL ,
  `first` TINYINT(1) NULL DEFAULT NULL ,
  `ip` VARCHAR(45) NULL DEFAULT NULL ,
  `language` VARCHAR(2) NULL DEFAULT NULL ,
  `login` VARCHAR(255) NULL DEFAULT NULL ,
  `online` TINYINT(1) NULL DEFAULT NULL ,
  `quota_list` INT(11) NULL DEFAULT NULL ,
  `password` VARCHAR(45) NULL DEFAULT NULL ,
  `status` TINYINT(1) NULL DEFAULT NULL ,
  `privilege` TINYINT(1) NULL DEFAULT NULL ,
  `token` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`idUser`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion utilisateur';


-- -----------------------------------------------------
-- Table `tootlist`.`statut_p`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`statut_p` (
  `idstatut_p` INT(11) NOT NULL AUTO_INCREMENT ,
  `statut` TINYINT(4) NULL DEFAULT NULL ,
  `item_idItem` INT(11) NOT NULL ,
  `user_idUser` INT(11) NOT NULL ,
  PRIMARY KEY (`idstatut_p`) ,
  INDEX `fk_statut_p_item1` (`item_idItem` ASC) ,
  INDEX `fk_statut_p_user1` (`user_idUser` ASC) ,
  CONSTRAINT `fk_statut_p_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_statut_p_user1`
    FOREIGN KEY (`user_idUser` )
    REFERENCES `tootlist`.`user` (`idUser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Associer utilisateur item ou structure';


-- -----------------------------------------------------
-- Table `tootlist`.`structure_p`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`structure_p` (
  `item_idItem` INT(11) NOT NULL ,
  `name` VARCHAR(255) NULL DEFAULT NULL ,
  `value` TEXT NULL DEFAULT NULL ,
  INDEX `fk_structure_p_item` (`item_idItem` ASC) ,
  CONSTRAINT `fk_structure_p_item`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tootlist`.`todo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`todo` (
  `item_idItem` INT(11) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `due_date` DATE NULL DEFAULT NULL ,
  `check` TINYINT(1) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `withdrawal` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`item_idItem`) ,
  INDEX `fk_todo_item1` (`item_idItem` ASC) ,
  CONSTRAINT `fk_todo_item1`
    FOREIGN KEY (`item_idItem` )
    REFERENCES `tootlist`.`item` (`idItem` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Gestion de todo';


-- -----------------------------------------------------
-- Table `tootlist`.`user_has_list`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tootlist`.`user_has_list` (
  `user_idUser` INT(11) NOT NULL ,
  `list_idList` INT(11) NOT NULL ,
  INDEX `fk_user_has_list_user1` (`user_idUser` ASC) ,
  INDEX `fk_user_has_list_list1` (`list_idList` ASC) ,
  CONSTRAINT `fk_user_has_list_list1`
    FOREIGN KEY (`list_idList` )
    REFERENCES `tootlist`.`list` (`idList` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_list_user1`
    FOREIGN KEY (`user_idUser` )
    REFERENCES `tootlist`.`user` (`idUser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Liaison user list';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
