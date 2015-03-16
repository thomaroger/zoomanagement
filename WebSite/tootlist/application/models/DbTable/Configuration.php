<?php

class Model_DbTable_Configuration extends Zend_Db_Table_Abstract
{

  protected $_name = 'configuration';
  protected $_primary = 'idConfiguration';
  public $Model_id = 9;
  
  const Nactive = 0;
  const Active = 1;

  public function getConfiguration($lang = 'fr'){
    // Recuperation de la derniere configuration active
    // $lang (par defaut 'fr') : permet de recuperation la configuration en fonction de la langue 
    // Retourne un tableau de configuration
    $select = $this->select()->where('status = ?', self::Active)
                             ->where('language = ?', $lang)
                             ->order('idConfiguration DESC')
                             ->limit(1);
  	$row = $this->fetchRow($select);  
    return $row;
    }
}  