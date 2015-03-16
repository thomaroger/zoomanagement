<?php

class Model_DbTable_Message extends Zend_Db_Table_Abstract
{

  protected $_name    = 'message';
  protected $_primary = 'item_idItem';
  public $Model_id    = 23;
  
  public $Category_id = 9;
  
  public function getDiscussions($id_user=null){
    // Permet de recuperer les discussions d'un utilisateur
    // $id_user correspon à l'id de l'utilisateur
    // retourne un tableau de liste de messages recus
    $discussions = array();
    $inst_user = new Model_DbTable_User();
    $inst_list = new Model_DbTable_List();
    
    if($id_user > 0){
      $current_user = $this->find($id_user)->current();
      $id_user = $current_user->idUser;
    }else{
      $current_user = $inst_user->getUser();
      $id_user = $current_user->idUser;
    }  
    
    $select = $inst_list->select()->where('categorie_idcategories = ?',$this->Category_id);
    $lists = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select);
    foreach($lists as $list){
      $discussions[$list->idList] = array("user"=>$current_user->idUser,"count"=>count($inst_list->getCountItem($list->idList)));
    }
    
    foreach($this->fetchAll($this->select()->where("recipients_id LIKE '%".$id_user.",%'")) as $message){
      $inst_item = new Model_DbTable_Item();
      $inst_list = new Model_DbTable_List();
      $current_item = $inst_item->find($message["item_idItem"])->current();
      $current_list = $inst_list->find($current_item->list_idList)->current();
      $list_user = $current_list->findModel_DbTable_UserViaModel_DbTable_UserHasListByListAndUser()->current();    
      $other_user = $inst_user->find($list_user->idUser)->current();  
      $discussions[$current_item->list_idList] = array("user"=>$other_user->idUser,"count"=>count($inst_list->getCountItem($current_item->list_idList)));
    }
    krsort($discussions);
    return $discussions;   
  }
  
  public function getDiscussionsSend($id_user=null){
    // Permet de recuperer les discussions envoyes d'un utilisateur
    // $id_user correspon à l'id de l'utilisateur
    // retourne un tableau de liste de messages envoyes
    $discussions = array();
    $inst_user = new Model_DbTable_User();
    $inst_list = new Model_DbTable_List();
    
    if($id_user > 0){
      $current_user = $this->find($id_user)->current();
      $id_user = $current_user->idUser;
    }else{
      $current_user = $inst_user->getUser();
      $id_user = $current_user->idUser;
    }  
    
    $select = $inst_list->select()->where('categorie_idcategories = ?',$this->Category_id);
    $lists = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select);
    foreach($lists as $list){
      $discussions[$list->idList] = array("user"=>$current_user->idUser,"count"=>count($inst_list->getCountItem($list->idList)));
    }
    krsort($discussions);
    return $discussions;   
  }
  
  public function getNbMessageUnread($id_user=null){
    // Permet de recuperer le nombre de messages non lus
    // $id_user correspon à l'id de l'utilisateur
    // retourne un numerique qui correspond aux nombre de messages non lus
    $inst_user = new Model_DbTable_User();
   if($id_user > 0){
      $current_user = $this->find($id_user)->current();
      $id_user = $current_user->idUser;
    }else{
      $current_user = $inst_user->getUser();
      $id_user = $current_user->idUser;
    }
    return count($this->fetchAll($this->select()->where("state LIKE '%".$id_user.",%'")));
  }
  
  public function getDiscussionsUnread($id_user=null){
    // Permet de recuperer les discussions non lus
    // $id_user correspon à l'id de l'utilisateur
    // retourne un numerique qui correspond aux nombre de messages non lus
   $inst_user = new Model_DbTable_User();
   $inst_item = new Model_DbTable_Item();
   if($id_user > 0){
      $current_user = $this->find($id_user)->current();
      $id_user = $current_user->idUser;
    }else{
      $current_user = $inst_user->getUser();
      $id_user = $current_user->idUser;
    }
    $messages = $this->fetchAll($this->select()->where("state LIKE '%".$id_user.",%'"));
    $list_unread = array();
    foreach($messages as $message){
      $message_obj = $inst_item->find($message['item_idItem'])->current();
      $list_obj = $message_obj->findParentRow(Model_DbTable_List);
      $list_unread[$list_obj->idList] = $list_obj->idList;  
    }
    return $list_unread;
  }
  
}
