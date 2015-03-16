<?php

class Model_DbTable_StructureP extends Zend_Db_Table_Abstract {

  protected $_name = 'structure_p';
  protected $_primary = 'item_idItem';
  
  public $Model_id = 19;
  
  
  public function getStructure($id){
  // Recupere l'item de la structure 
  // $id : id de l'item
  // Retourne la structure
  return $this->find($id)->current();
  }
              
}
