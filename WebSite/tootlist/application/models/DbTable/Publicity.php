<?php

class Model_DbTable_Publicity extends Zend_Db_Table_Abstract
{
  protected $_name    = 'publicite';
  protected $_primary = 'idPublicite';                                                 

  public function getPub($id_pred){
    // Permet de recuperer la publicite
    // $id_pred : Concerne la publicite precedente
    // Retourne un tableau de la publicite
    $position = 0;
    if($id_pred > 0){
      $pred_pub = $this->find($id_pred)->current();  
      $position = $pred_pub->position;
    }
    $db = Zend_Db_Table::getDefaultAdapter();
    $select= $db->select()->from($this->_name)->where("status = ?",1)->where("position > ?",$position)->where("date_end >= ?",date('Y-m-d'))->where("date_deb <= ?",date('Y-m-d'))->order("position ASC");
    
    $pubs_tmp = $db->query($select)->fetchAll();
    
    if(count($pubs_tmp) <= 0){
      $select= $db->select()->from($this->_name)->where("status = ?",1)->order("position ASC");
      $pubs_tmp = $db->query($select)->fetchAll();
    }
    return $pubs_tmp;  
  }
}
