<?php

class Backend_DictonnaryController extends Zend_Controller_Action {
	
	 
	 public $inst_user;

	 
	 public function init()
    {
      $this->_helper->layout()->setLayout('layout.backoffice');
      $this->inst_user = new Model_DbTable_User();
      
      if($this->current_user = $this->inst_user->getUser())
      {
        $this->view->current_user = $this->current_user;
        if($this->current_user->privilege == 0)
         $this->_redirect("/");
  	  }
  	  
    }

    public function indexAction(){
      $this->_helper->layout->disableLayout(); 
		}
		
		public function editAction(){
		  $this->_helper->layout->disableLayout(); 
		  $filename = $this->getRequest()->getParam("idList");
		  $arbo_fic = "../application/languages/".$filename;
		  $flux = fopen($arbo_fic,'r'); 
      $content = fread($flux, filesize($arbo_fic)); 
      fclose($flux);
      $this->view->filename = $filename;
      $this->view->content = $content; 
		}
		
		public function writeAction(){
		  $this->_helper->layout->disableLayout(); 
      $this->_helper->viewRenderer->setNoRender();
      $filename = $this->getRequest()->getParam("filename");
      $arbo_fic = "../application/languages/".$filename;
      $flux = fopen($arbo_fic,'w'); 
      fwrite($flux,$this->getRequest()->getParam("content"));
      fclose($flux);
      $this->_redirect("/backend/");
		}
}