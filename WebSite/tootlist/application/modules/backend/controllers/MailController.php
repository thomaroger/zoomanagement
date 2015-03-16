<?php

class Backend_MailController extends Zend_Controller_Action {
	
	    public function init()
    {
        /* Initialize action controller here */
      $this->_helper->layout()->setLayout('layout.backoffice');
      
      $user = new Model_DbTable_User();
      if($this->current_user = $user->getUser())
      {
        $this->view->current_user = $this->current_user;
        if($this->current_user->privilege == 0)
         $this->_redirect("/");
  	  }
    }

    public function listAction(){
      $this->_helper->layout()->setLayout('layout.backoffice');
      $fp = fopen('https://tootlist:ing3sigl@mail.google.com/mail/feed/atom', 'r');
      $this->view->gmail = explode(" ",fpassthru($fp));
    }

}