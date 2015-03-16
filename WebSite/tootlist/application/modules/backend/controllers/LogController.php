<?php

class Backend_LogController extends Zend_Controller_Action {
	
	public $inst_list;
	public $inst_category;
	
	    public function init()
    {
        /* Initialize action controller here */
      $this->_helper->layout()->setLayout('layout.backoffice');
      $this->inst_user = new Model_DbTable_User();
      $this->inst_list = new Model_DbTable_List();
      $this->inst_log = new Model_DbTable_Log();
      $this->inst_category = new Model_DbTable_Categorie();   
      $user = new Model_DbTable_User();
      if($this->current_user = $user->getUser())
      {
        $this->view->current_user = $this->current_user;
  	  }
    }
        
    public function viewAction(){
      $this->_helper->layout->disableLayout(); 
      $db = Zend_Db_Table::getDefaultAdapter();
      $logs = $db->query($db->select()->from("log")->order("idLog DESC"))->fetchAll();
      $this->view->logs = $logs;
    }
     
}
?>