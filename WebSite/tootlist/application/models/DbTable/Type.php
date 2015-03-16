<?php

class Model_DbTable_Type extends Zend_Db_Table_Abstract {

  protected $_name = 'type';
  protected $_primary = 'idtype';
  
  public $Model_id = 18;
  
  protected $_referenceMap    = array(
    'item' => array(
      'columns'           => array('idtype'),
      'refTableClass'     => 'item',
      'refColumns'        => array('type_idtype')
    ));
        
        
    public function getType($id_type){
    // Recuperation du type 
    // $id_model : Donne l'id du type
    // Retourne le type
      $rows = $this->fetchAll($this->select()->where('idtype = ?', (int) $id_type));
      return $rows->current();
  }  
  
  
  public function createType($sql) {
   // Permet de creer un type
   // $sql : requete sql
   $db = Zend_Db_Table::getDefaultAdapter();
   $db->query($sql);
  }   
        
}
