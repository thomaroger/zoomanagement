<?php

class IndexController extends Zend_Controller_Action {
	
	  public function init()
    {
        /* Initialize action controller here */
    }
    
    // Permet d'afficher la page d'accueil
    public function indexAction()
    {
      $this->view->headTitle('TOOTLIST : Accueil');
      $user = new Model_DbTable_User();
      $current_user = $user->getUser();
      $this->view->current_user = $current_user;
      $this->view->cookie ="";
      
      
      if($current_user){
        if($itemStructure = $user->getStructureHome()){
           $ins_struct = new Model_DbTable_StructureP();          
           $mstruct = $ins_struct->getStructure($itemStructure[0]['item_idItem']);
           if($mstruct->value){
            $this->view->cookie = $mstruct->value;
           }else{
             $admin_lists = $user->getAdminLists($current_user->idUser);
             $this->view->homeLists = $admin_lists;
           }
         }else{
          $admin_lists = $user->getAdminLists($current_user->idUser);
          if(count($admin_lists) > 0) {
            $this->view->homeLists = $admin_lists;
          }else{
            $admin_lists = $user->getAdminLists(1);
            $this->view->homeLists = $admin_lists;
          }
         }
      }else{
        $admin_lists = $user->getAdminLists(1);
        $this->view->homeLists = $admin_lists;
      
        if(!empty($_COOKIE["homePage"])){
          $this->view->cookie = $_COOKIE["homePage"];
        }
      }
            
      if($current_user && $current_user->first == 0) {
        $current_user->first = 1;
        $current_user->save();
        $this->view->aide = 1;
      }
      
      if($current_user) {
        $name="";
        $date_birthday ="";
        $profiles_associed = $user->getProfile();
        if($profiles_associed){
          foreach($profiles_associed as $profile_associed){
            if($profile_associed["property"]=="name") 
              $name = $profile_associed["value"];
              
           if($profile_associed["property"]=="dateBirthday") 
              $date_birthday = $profile_associed["value"];   
          }
        }
        if($name==""){
          $data =array('click'=>0,
                     'title'=>"Profil manquant",
                     'description' => "Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href='/user/profile'>ici</a>.",
                     'lu'=>0);
          $notification = new Model_DbTable_Notification();
          $notification->addNotification($data,$current_user);
        }
        if($date_birthday==date('d/m/Y')){
          $data =array('click'=>0,
                       'title'=>"JOYEUX ANNIVERSAIRE !!",
                       'description' => "Vous etes n&eacute; le ".$date_birthday.". <br /> L'&eacute;quipe de TOOTLIST vous souhaite un JOYEUX ANNIVERSAIRE !!" ,
                       'lu'=>0);
          $notification = new Model_DbTable_Notification();
          $notification->addNotification($data,$current_user);              
        }
      }   
    }
    
    // Page de test
    public function testAction(){
      $this->view->headTitle('TOOTLIST : Test');
      $locale = new Zend_Locale(Zend_Locale::BROWSER);
      $session = Zend_Registry::get('session');
      $this->view->session = $session->user;
      $this->view->locale = $locale;
      $this->view->lang = $session->lang;
      $this->view->headScript()->appendFile('/javascript/passShark.js');
      $this->view->headScript()->appendFile('/javascript/calendar.js');
      $this->view->headLink()->appendStylesheet('/style/calendar.css');
      $this->view->headTitle('TOOTLIST : Index');   
    }
    
    // Page qui affiche une google map 
    public function mapAction(){
      $this->_helper->layout()->setLayout('layout.modal');
      $this->view->adresse = $this->getRequest()->getParam('adresse');
    }
    
    // Permet de gerer la langue
    public function languageAction(){
		  $params = $this->getRequest()->getParams();
		  if(isset($params['lang']) && in_array($params['lang'], array('en','fr'))){
			 Zend_Registry::get('session')->lang = $params['lang'];
		  }
		  $user = new Model_DbTable_User();
		  if($current_user = $user->getUser()){
		    $current_user->language = $params['lang'];
		    $current_user->save();
		  }
		  $this->_redirect('/');
  	}
  	
  	// Permet dafficher l'aide
  	public function aideAction(){
  	  $this->_helper->layout()->setLayout('layout.modal');
  	  $session = Zend_Registry::get('session');
  	  if($session->lang ==""){
  	   $session->lang = 'fr';
  	  }
  	  $lang = $session->lang;
  	  $configuration = new Model_DbTable_Configuration();
      $row = $configuration->getConfiguration($lang);
      if($row){
        $this->view->aide = $row->help;
  	  }else{
        $this->view->aide = "no_result";
      }
      
  	}
  	
  	// Permet d'afficher la publicite
  	public function publicityAction(){
  	  $this->_helper->layout->disableLayout();
  	  $inst_publicity = new Model_DbTable_Publicity();
  	  $this->view->pubs = $inst_publicity->getPub($this->getRequest()->getParam('id_pub'));
  	}

  }