<?php

class Backend_SauvegardeController extends Zend_Controller_Action {
	
	 
	 public $inst_user;

	 
	 public function init()
    {
      $this->_helper->layout()->setLayout('layout.backoffice');
      $this->inst_user = new Model_DbTable_User();
      $this->inst_sauvegarde = new Model_DbTable_Sauvegarde();
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
      $sauvegardes = $db->query($db->select()->from("sauvegarde")->order("idSauvegarde DESC"))->fetchAll();
      $this->view->sauvegardes = $sauvegardes ; 
		}
    
    public function createAction(){
      $this->_helper->layout->disableLayout(); 
      $this->_helper->viewRenderer->setNoRender(true);
      
      $sauvegarde = "../../../Sauvegarde/sauvegarde_".date('Y-m-d-H-i').".tar.gz";
      
      $record["name"] = "sauvegarde_".date('Y-m-d-H-i').".tar.gz";
      $record["path"] = $sauvegarde;
      $record["title"] = "sauvegarde_".date('Y-m-d-H-i').".tar.gz";
      $this->inst_sauvegarde->insert($record);
      
      $todo =  'tar cvzf '.$sauvegarde.' ../../.';
      system($todo,$retval);
      
      $this->_redirect("/backend/");
    }		
}