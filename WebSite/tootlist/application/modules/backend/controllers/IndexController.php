<?php

class Backend_IndexController extends Zend_Controller_Action {
	
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

    public function indexAction()
    {
      $form = new Form_signin(null,1);
	  	$this->view->form = $form;
		  
		  if($post = $this->_request->isPost() && isset ($_POST["email_log"])){
			  $formData = $this->getRequest()->getPost();
			  if($form->isValid($formData)){
          $user = new Model_DbTable_User();
          $result = $user->userSignin($formData);
          if($result['bool']->isValid()){
            $current_user = $user->find($result['result']->idUser)->current();
            $current_user->online = 1;
            if($current_user->language !=""){
              Zend_Registry::get('session')->lang =  $current_user->language;
            }
            $current_user->save();
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $authNamespace->user = serialize($current_user);
          
            if($current_user->privilege == 0)
             $this->_redirect('/');
            else
             $this->_redirect('/backend/');
        }else{
          $this->view->error = "Echec de l'identification";
        }
      }else{
				$form->populate($formData);
			}
		}
  }
  
  
  
  public function unsignAction()
  {
    $this->_helper->layout->disableLayout();
    $user = new Model_DbTable_User();
    if($user->getUser()){
      $authNamespace = new Zend_Session_Namespace('Zend_Auth');
      $current_user = $user->getUser();
      $current_user->online = 0;
      $current_user->save();
      $user->updateMeta($current_user->idUser,"Deconnexion du compte de ".$current_user->email,Zend_Log::INFO);
      unset($authNamespace->user);
      Zend_Auth::getInstance()->clearIdentity();
      $this->_redirect('/backend');
    }
  
  }
    

}