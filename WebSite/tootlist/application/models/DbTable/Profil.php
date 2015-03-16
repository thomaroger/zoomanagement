<?php

class Model_DbTable_Profil extends Zend_Db_Table_Abstract
{

  protected $_name = 'profil';
  public $Model_id = 8;
  
  public $Category_id = 8;
  
  
  public function getSearch($query){
    // Permet de retourner tous les profils en fonction d'une chaine de caracteres
    // $query : la chaine a rechercher dans tous les profils
    // retourne les items des profils
    $tabs_searches = array();
    $user = new Model_DbTable_User();
    $current_user = $user->getUser();
    foreach ($this->fetchAll($this->select()->where("value LIKE '%".$query."%'")) as $profil){
      $photo = "";
      $name="";
      $firstname="";
      $current_item = new Model_DbTable_Item();
      $profil_item = $current_item->find($profil['item_idItem'])->current();
      $tab_list = $profil_item->findParentRow(Model_DbTable_List);
      $list = new Model_DbTable_List();
      $current_list = $list->find($tab_list['idList'])->current();
      $list_user = $current_list->findModel_DbTable_UserViaModel_DbTable_UserHasListByListAndUser()->current();
    
      $profil_user =  new Model_DbTable_User();
      $profiles_associed = $profil_user->getProfile($list_user['idUser']);
      if($list_user['idUser'] == 1 || $current_user->idUser == $list_user['idUser']) continue;
      foreach($profiles_associed as $profile_associed){
        if($profile_associed["property"]=="name") 
          $name = $profile_associed["value"];
        if($profile_associed["property"]=="firstname") 
          $firstname = $profile_associed["value"];
        if($profile_associed["property"]=="photo") 
          $photo = $profile_associed["value"];
          
      }
      $tabs_searches[$list_user['idUser']] = array("login"=>$list_user['login'],
                                                   "name" => $name,
                                                   "firstname"=>$firstname,
                                                   "photo"=>$photo); 
    }
    
    $search_user = new Model_Dbtable_User();
    foreach ($search_user->fetchAll($search_user->select()->where("email LIKE '%".$query."%'")->orWhere("login LIKE '%".$query."%'")) as $list_user){
      $photo = "";
      $name="";
      $firstname="";
      $profiles_associed = $search_user->getProfile($list_user['idUser']);
        if($list_user['idUser'] == 1 || $current_user->idUser == $list_user['idUser'])  continue;
        if($profiles_associed){
          foreach($profiles_associed as $profile_associed){
            if($profile_associed["property"]=="name") 
              $name = $profile_associed["value"];
            if($profile_associed["property"]=="firstname") 
              $firstname = $profile_associed["value"];
            if($profile_associed["property"]=="photo") 
              $photo = $profile_associed["value"];
              
          }
        }
        $tabs_searches[$list_user['idUser']] = array("login"=>$list_user['login'],
                                                     "name" => $name,
                                                     "firstname"=>$firstname,
                                                     "photo"=>$photo); 
    }
    
    
    
    return $tabs_searches;
  }
}  