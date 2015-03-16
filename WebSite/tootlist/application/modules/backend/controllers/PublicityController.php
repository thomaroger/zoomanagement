<?php

class Backend_PublicityController extends Zend_Controller_Action {
	
	public $inst_list;
	public $inst_category;
	public $inst_publicity;

	
	 public function init()
   {
        /* Initialize action controller here */
      $this->_helper->layout()->setLayout('layout.backoffice');
      
      $this->inst_list = new Model_DbTable_List();
      $this->inst_category = new Model_DbTable_Categorie(); 
      $this->inst_publicity = new Model_DbTable_Publicity(); 
          
      $user = new Model_DbTable_User();
      if($this->current_user = $user->getUser())
      {
        $this->view->current_user = $this->current_user;
  	  }
    }

    public function indexAction()
    {
        // action body
       $this->_helper->layout->disableLayout();
       
       $this->view->pub = $this->inst_publicity->fetchAll();
        
    }
    
    public function displayAction()
    {
     
      $this->_helper->layout->disableLayout(); 
      $this->_helper->viewRenderer->setNoRender(true);
      
      $idPub = $this->_request->getPost("idPub");
      
      $data["status"] = $this->_request->getPost("display");
      
      $where = $this->inst_publicity->getAdapter()->quoteInto('idPublicite = ?', $idPub);
      $this->inst_publicity->update($data,$where);
    }
    
    
    public function createAction()
    {
       if($this->_request->getPost('titre')!="")
       {
          $data = array();
        
        $tmp = explode("/",$this->_request->getPost('date_deb'));
        
         $data["date_deb"] = $tmp[2]."-".$tmp[1]."-".$tmp[0];
         $tmp = explode("/",$this->_request->getPost('date_fin'));


         $data["date_end"] = $tmp[2]."-".$tmp[1]."-".$tmp[0];
         $data["description"] = $this->_request->getPost('description');
         $data["link"] = $this->_request->getPost('link');
         $data["name_contact"]  = $this->_request->getPost('contact');
         $data["path"] = $this->_request->getPost('path');
         $data["position"] = $this->_request->getPost('position');
         if($this->_request->getPost('active')==1)
          $data["status"] = 1;
         else
          $data["status"] = 0;
          
        $data["title"] = $this->_request->getPost('titre');
        $data["type"] = 1;
        
        $this->inst_publicity->insert($data);
       }
    }
    
}
?>