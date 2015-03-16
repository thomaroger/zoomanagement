<?php
class AuthController extends Zend_Controller_Action {

 public function indexAction(){
      $session = Zend_Registry::get('session');
      $session->user = "userSessionTest";
      $this->_redirect("/");
 }
}

?>