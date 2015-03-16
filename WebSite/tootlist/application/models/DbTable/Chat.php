<?php

class Model_DbTable_Chat extends Zend_Db_Table_Abstract {

  protected $_name    = 'private_message';
  protected $_primary = 'item_idItem';
  public $Model_id    = 24;
  
  public $Category_id = 10;
  
  const NOUVEAU = 0;
  const LU = 1;
  const SUPPRIMER =2;
  
  const TEMPS = "-1 hours";
  
  
  public $inst_user;
  public $inst_message;
  public $inst_list;
  
  public function getChat($current_user, $user){
  // Permet de recuperer la conversation privee entre deux utilisateur
  // $current_user : l'utilisateur qui est connecte
  // $user : l'user avec qui l'utilisateur courant discute
  // retourne la discussion
    $this->inst_user = new Model_DbTable_User();
    $this->inst_message = new Model_DbTable_Message();
    $this->inst_list = new Model_DbTable_List();
    
    $select = $this->inst_list->select()->where('categorie_idcategories = ?',$this->inst_message->Category_id)->where('title = ?', 'chat_'.$user->idUser);
    $list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select);
	  if(count($list)==0){
	     $select2 = $this->inst_list->select()->where('categorie_idcategories = ?',$this->inst_message->Category_id)->where('title = ?', 'chat_'.$current_user->idUser);
       $list2 = $user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select2);
	     if(count($list2) == 0){
          $idList=0;
	     }else {
	       $idList = $list2[0]['idList'];
	     }
	  }else{
	     $idList = $list[0]['idList'];
	  }
	  return $idList; 
  }
  
}
