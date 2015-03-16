<?php

class PictureController extends Zend_Controller_Action {

  public function init() {
    $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
  }
  
  // Permet de voir toutes les images de l'utilisateur
  public function indexAction(){
    $lists = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList();
    $items = array();
    $picture = new Model_DbTable_Picture();
    $inst_list = new Model_DbTable_List();
    foreach($lists as $list){
      $items[] = $inst_list->getItems($list,$picture->Model_id);
    }
  
    $pictures = array();
    foreach ($items as $item_tmp){
      foreach($item_tmp as $item){
        if(is_array($item)){
          $pictures[] = $item;
        }
      }
    }
    $this->view->pictures = $pictures;
  }  
  
  // Permet de voir l'image
  public function pictureAction(){
    $this->_helper->layout->disableLayout();
    $inst_picture = new Model_DbTable_Picture();
    $picture = $inst_picture->find($this->getRequest()->getParam("picture"))->current();
    $this->view->picture = $picture;
  }
}