<?php

class Backend_ConfigurationController extends Zend_Controller_Action {
	
	 
	 public $inst_user;
	 public $inst_configuration;
	 
	 public function init()
    {
      $this->_helper->layout()->setLayout('layout.backoffice');
      $this->inst_user = new Model_DbTable_User();
      $this->inst_configuration = new Model_DbTable_Configuration();
      
      if($this->current_user = $this->inst_user->getUser())
      {
        $this->view->current_user = $this->current_user;
        if($this->current_user->privilege == 0)
         $this->_redirect("/");
  	  }
  	  
    }

    public function indexAction(){
      $this->_helper->layout->disableLayout(); 
      $db = Zend_Db_Table::getDefaultAdapter();
     	$confs = $db->query($db->select()->from("configuration")->order("idConfiguration DESC"))->fetchAll();
      $this->view->confs = $confs;	  
		}
  
    public function createAction(){     
      $this->_helper->layout->disableLayout(); 
      $current_config = $this->inst_configuration->find($this->getRequest()->getParam('idList'))->current();
      $this->view->current_config = $current_config;
    }
  
    public function editAction(){
      $this->_helper->layout->disableLayout(); 
      $this->_helper->viewRenderer->setNoRender();
      $record = $this->getRequest()->getParam("record");
      $current_config = $this->inst_configuration->find($record["idConfiguration"])->current();
      $current_config->delete();
      $record["status"]=1;
      $this->inst_configuration->insert($record);
      $this->_redirect("/backend/");
    }
}