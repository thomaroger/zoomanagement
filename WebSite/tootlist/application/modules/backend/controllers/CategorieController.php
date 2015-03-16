<?php

class Backend_CategorieController extends Zend_Controller_Action {
	
	 
	 private $modelCategorie;
	 
	 
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
  	  
  	  $this->modelCategorie = new Model_DbTable_Categorie();
    }

    public function indexAction()
    {
      $this->_helper->layout->disableLayout(); 
      $this->view->cat = $this->modelCategorie->fetchAll();
		  
		}
  
    public function createAction()
    {
      
     if($this->_request->getPost('name_fr')!="")
     {
       $data["title_fr"] = $this->_request->getPost('name_fr');
       $data["title_en"] = $this->_request->getPost('name_en');
       $data["tags"]     = $this->_request->getPost('tags');
       
       $select = $this->_request->getPost('cat');
       
       if($select !="")
         $data["categorie_idcategories"] = $this->_request->getPost('cat');
         
         
        $this->modelCategorie->insert($data);
     
     
     }
     
     
      $arrayCat        = $this->modelCategorie->SupCategorie();
      $this->view->cat = $arrayCat;
    }
    
    public function deleteAction()
    {
      $this->_helper->layout->disableLayout(); 
      $this->_helper->viewRenderer->setNoRender(true);
     
       $idCat = $this->_request->getPost("idCat");
       
       $this->modelCategorie->find($idCat)->current()->delete();
       
    
    }
  
}