<?php

class Model_DbTable_Model extends Zend_Db_Table_Abstract{

  protected $_name = 'model';
  protected $_primary = 'idModel';
  public $Model_id = 1;

  public function all() {
    // Permet de recuperer tous les models qui sont listables
    // return un tableau de row
		$select = $this->select()
		          ->where('isList = 1');
		         
		return $select->query()->fetchAll();
  }


  public function allDynamic() {
    // Permet de recuperer tous les models qui sont listables
    // return un tableau de row
		$select = $this->select()
		          ->where('isList = 1')
		          ->where('table_name !="pkmn_user"');

		return $select->query()->fetchAll();
  }
  
  public function getModel($id_model){
    // Recuperation du model 
    // $id_model : Donne l'id du model
    // Return le model
    $rows = $this->fetchAll($this->select()->where('model_id = ?', (int) $id_model));
    return $rows->current();
  }
  
  
  public function getModelItem($idItem) {
    // Permet de recuperer le model d'un item
    // $idItem : id de l'item 
    // retourne un tableau du model
    $db = Zend_Db_Table::getDefaultAdapter();
  
    $select = $db->select()->from(array('m'=>'model'),array('table_name','idModel'))
                            ->join(array('t'=>'type'),'m.idModel=t.model_id',array())
                            ->join(array('i'=>'item'),'i.type_idtype = t.idtype',array())
                            ->where('i.idItem = ?',$idItem);
          
      return $db->query($select)->fetchAll();
              
  }
} 