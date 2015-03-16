<?php

class Backend_UserController extends Zend_Controller_Action {
	
	public $inst_list;
	public $inst_category;
	
	    public function init()
    {
        /* Initialize action controller here */
      $this->_helper->layout()->setLayout('layout.backoffice');
      $this->inst_user = new Model_DbTable_User();
      $this->inst_list = new Model_DbTable_List();
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
      $users = $db->query($db->select()->from("user")->order("idUser DESC"))->fetchAll();
      $this->view->users = $users;
    }
    
    public function detailAction(){
      $this->_helper->layout->disableLayout(); 
      $current_user = $this->inst_user->find($this->getRequest()->getParam('idList'))->current();
      $this->view->user = $current_user;
      $this->view->profile = $this->inst_user->getProfile($this->view->user->idUser);
      if($lists_user = $this->inst_user->getLists($current_user->idUser)){
        $this->view->lists = $lists_user;
      }
    }
    
    public function adduserAction(){
      $this->_helper->layout->disableLayout(); 
      $this->_helper->viewRenderer->setNoRender();
      
      $idList = $this->_request->getPost("idList");

      $data = array('status'=>1);
      $where = $this->inst_user->getAdapter()->quoteInto('idUser = ?', $idList);
      $this->inst_user->update($data,$where);
    }
    
    public function deluserAction(){
      $this->_helper->layout->disableLayout();
      $this->_helper->viewRenderer->setNoRender(); 
      $idList = $this->_request->getPost("idList");

      $data = array('status'=>0);
      $where = $this->inst_user->getAdapter()->quoteInto('idUser = ?', $idList);
      $this->inst_user->update($data,$where);
    }  
}
?>