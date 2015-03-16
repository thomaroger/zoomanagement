<?php

class SearchController extends Zend_Controller_Action {

  public $inst_model;
  public $inst_user;
  
  public function init() {
    $this->inst_user = new Model_DbTable_User();
    $this->inst_model = new Model_DbTable_Model();
    $this->inst_profil = new Model_DbTable_Profil();
    $this->inst_list = new Model_DbTable_List();
    $this->inst_item = new Model_DbTable_Item();
    if($this->current_user = $this->inst_user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      //$this->_redirect('/');
    }
  }
  
  // Permet de rechercher dans les listes 
  public function listAction(){
    $this->_helper->layout->disableLayout();
    $search = $this->_request->getParam('search');
    $this->view->lists_search = $this->inst_list->getListsSearch($search);
  }
}