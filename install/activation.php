<?php

function smfr_tournament_activation() {
    global $wpdb;
    // create table !
    $sql[] = "CREATE TABLE IF NOT EXISTS ".SMFR_TOURNAMENT_DB_PREFIX."tournament (
              id INT NOT NULL AUTO_INCREMENT ,
              name VARCHAR(100) NULL DEFAULT NULL,
              description TEXT NULL DEFAULT NULL,
              size INT NULL DEFAULT NULL,
              nb_player INT NULL DEFAULT NULL,
              nb_remplacant INT NULL DEFAULT NULL,
              date TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
              time_check VARCHAR(5) NULL DEFAULT '00:00',
              time_check_end VARCHAR(5) NULL DEFAULT '00:00',
              time_start VARCHAR(5) NULL DEFAULT '00:00',
              url_reglement TEXT NULL DEFAULT NULL,
              url_bracket TEXT NULL DEFAULT NULL,
              updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              created_at TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
              status TINYINT(4) NULL DEFAULT '2',
              PRIMARY KEY (id))
            ENGINE = InnoDB;";

    $sql[] = "CREATE TABLE IF NOT EXISTS ".SMFR_TOURNAMENT_DB_PREFIX."player (
              id INT NOT NULL AUTO_INCREMENT,
              id_team INT NOT NULL,
              name VARCHAR(45) NULL DEFAULT NULL,
              titulaire INT NOT NULL,
              updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              created_at TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
              status TINYINT(4) NULL DEFAULT '2',
              PRIMARY KEY (id))
            ENGINE = InnoDB";


    $sql[] = "CREATE TABLE IF NOT EXISTS ".SMFR_TOURNAMENT_DB_PREFIX."team (
  id INT NOT NULL AUTO_INCREMENT,
  id_tournament INT NOT NULL,
  name VARCHAR(45) NULL DEFAULT NULL,
  pass text NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_at TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
  status TINYINT(4) NULL DEFAULT '2',
  PRIMARY KEY (id))
ENGINE = InnoDB;";

// execute query !
    foreach($sql as $key => $query){
        $wpdb->query($query);
    }

}