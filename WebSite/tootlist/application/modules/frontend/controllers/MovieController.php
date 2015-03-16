<?php

class MovieController extends Zend_Controller_Action {

  public function init() {
    $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
  }
  
  // Permet de voir tous les films de l'utilisateur
  public function indexAction(){
    $lists = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList();
    $items = array();
    $movie = new Model_DbTable_Movie();
    $inst_list = new Model_DbTable_List();
    foreach($lists as $list){
      $items[] = $inst_list->getItems($list,$movie->Model_id);
    }
    
    $movies = array();
    foreach ($items as $item_tmp){
      foreach($item_tmp as $item){
        if(is_array($item)){
          $movies[] = $item;
        }
      }
    }
    $this->view->movies = $movies;
  
  }  
}