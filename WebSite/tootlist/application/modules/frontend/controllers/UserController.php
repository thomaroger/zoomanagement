<?php

class UserController extends Zend_Controller_Action
{

  public function init() {
    $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }
  }
    
   // Permet de creer un user 
	function newAction() {
	  $form = new Form_register();
		$this->view->form = $form;
	
    $this->view->headScript()->appendFile('/javascript/mooRainbow.js');
    $this->view->headScript()->appendFile('/javascript/calendar.js');
    $this->view->headLink()->appendStylesheet('/style/mooRainbow.css');
    $this->view->headLink()->appendStylesheet('/style/calendar.css');
    $this->view->headTitle('TOOTLIST : Inscription');	
		
		if($post = $this->_request->isPost() && isset ($_POST["email"])){
		
			$formData = $this->getRequest()->getPost();
			if($form->isValid($formData)){
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try{
	        $user = new Model_DbTable_User();
	        $array = $user->addUser($formData); 
	        $db->commit();
	        
	        $metadata = new Model_DbTable_Metadata();
	        $metadata->addMeta($array['model_id'], $array['record_id'], null, null);
	        
	        $log = new Model_DbTable_Log();
	        $array_log = $log->addLog($array['model_id'], $array['record_id'],"Inscription de ".$formData['email'], Zend_Log::INFO);
	        $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
	        
	        $mail_conf = Zend_Registry::get('Mail_Config'); 
	        $smtpConnection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mail_conf['config']);
	        $contentHTML = "Dear ".$formData['email']." <br/> Welcome to Tootlist !! <br />";
	        $contentHTML .= "Please visit this url to activate your account :<br /><br /> http://".$_SERVER['SERVER_NAME'].'/user/activate/token/'.$array['token'];
	        $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team"; 
          $mail = new Zend_Mail('utf-8');
          $mail->addTo($formData['email'])
               ->setFrom('tootlist@gmail.com', 'Tootlist Support')
               ->setSubject('Welcome to Tootlist')
               ->setBodyHtml($contentHTML);
          $mail->send($smtpConnection);
	        
	        Zend_Session::regenerateId();
        }catch (Exception $e){
	        $db->rollBack();
	        throw $e;
        }
        $parent_password = $this->getRequest()->getParam('parent');
        if($parent_password!=""){
          $user_parent = new Model_DbTable_User(); 
    	    $rows = $user_parent->fetchAll($user_parent->select()->where('password = ?',$parent_password));
    	    if(count($rows) != 0){
      	    $session = Zend_Registry::get('session');
        	  if($session->lang ==""){
          	  $session->lang = 'fr';
        	  }
    	      $current_parent = $user_parent->find($rows[0]['idUser'])->current();
    	      $configuration = new Model_DbTable_Configuration();
            $row_conf = $configuration->getConfiguration($session->lang);
            if($row_conf){
              $current_parent->quota_list = $current_parent->quota_list + $row_conf->quota_list_user_parent;
              $current_parent->save();
            }
            $array_log = $log->addLog($user_parent->Model_id, $rows[0]['idUser'],"Parrainage reussi avec ".$formData['email'], Zend_Log::INFO);
  	        $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
             
    	    }
  	    }
        $this->_redirect('/');
			}else{
				$form->populate($formData);
			}
		} 
  }
  
  // Permet d'activer un compte
  public function activateAction() {
	  $token = $this->getRequest()->getParam('token');
	  if($token !=""){
		  $user = new Model_DbTable_User();
		  $user->validateUserByToken($token);
	  }
	 $this->_redirect('/');
  }
  
  // Permet de se connecter
  public function signinAction(){
    $this->_helper->layout()->setLayout('layout.inclusion');
    $form = new Form_signin();
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
           $this->_redirect('/');
        }else{
          $this->view->error = "Echec de l'identification";
        }
      }else{
				$form->populate($formData);
			}
		}
  }
  
  // Permet de se deconnecter
  public function signoutAction(){
  $user = new Model_DbTable_User();
    if($user->getUser()){
      $authNamespace = new Zend_Session_Namespace('Zend_Auth');
      $current_user = $user->getUser();
      $current_user->online = 0;
      $current_user->save();
      $user->updateMeta($current_user->idUser,"Deconnexion du compte de ".$current_user->email,Zend_Log::INFO);
      unset($authNamespace->user);
      Zend_Auth::getInstance()->clearIdentity();
      $this->_redirect('/');
    }
  }
  
  // Permet de recuperer un nouveau mot de passe
  public function resendpasswordAction(){
    //$this->_helper->layout()->setLayout('layout.modal');
    $this->view->headTitle('TOOTLIST : Generation de votre mot de passe');
    $form_password = new Form_resendPassword();
		$this->view->form_password = $form_password;
		if($post =$this->_request->isPost() && isset ($_POST["email_password"])){
			$formData_password = $this->getRequest()->getPost();
			if($form_password->isValid($formData_password)){
        $user = new Model_DbTable_User();
        $rows = $user->fetchAll($user->select()->where('email = ?', $formData_password["email_password"]));
        if(count($rows) == 1){
          $new_password = $user->regenPassword();
          foreach($rows as $row){
            $user->updateMeta($row->idUser,"Generation (Service mot de passe oublie) du mot de passe de ".$row->email,Zend_Log::INFO);
	          $row->password=md5($new_password);
	          $row->save();
	          $mail_conf = Zend_Registry::get('Mail_Config'); 
	          $smtpConnection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mail_conf['config']);
	          $contentHTML = "Dear ".$row->login." <br/> Your password was generating !! <br />";
	          $contentHTML .= "Your new password is : ".$new_password;
	          $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team"; 
            $mail = new Zend_Mail('utf-8');
            $mail->addTo($row->email)
               ->setFrom('tootlist@gmail.com', 'Tootlist Support')
               ->setSubject('Generating your password')
               ->setBodyHtml($contentHTML);
            $mail->send($smtpConnection);
          }
        }else{
          $this->view->error_password = "Echec de l'identification";
        }
        $this->_redirect('/');
      }else{
				$form_password->populate($formData_password);
			}
		}
  }
  
  // Permet de gerer le profile
  public function profileAction(){
    $this->view->headScript()->appendFile('/javascript/calendar.js');
    $this->view->headLink()->appendStylesheet('/style/calendar.css');
    

    $user = new Model_DbTable_User();
    if($current_user = $user->getUser()){
      $this->view->current_user = $current_user;
      $session = Zend_Registry::get('session');
  	  if($session->lang ==""){
  	   $session->lang = 'fr';
  	  }
  	  
  	  $profile = $user->getProfile();
  	
  	  $lang = $session->lang;
      $configuration = new Model_DbTable_Configuration();
      $row = $configuration->getConfiguration($lang);
      $dynamic_form  = new Form_dynamicForm(null,$configuration, $row, $profile);
		  
		  $this->view->dynamic_form = $dynamic_form;		  
		  if($post =$this->_request->isPost() && isset ($_POST["form_dynamique"])){
  			$formData_profil = $this->getRequest()->getPost();
  			if($dynamic_form->isValid($formData_profil)){
  			  if($formData_profil['idList'] > 0){
  			    $dataItems = array();
  			    foreach($formData_profil as $k => $v){
  			      if(!is_array($v)){
                $dataItems[$k] = utf8_decode($v);
              }else{
                $value_tab = "";
                foreach($v as $value_array){
                  $value_tab .=$value_array.",";
                }
                $dataItems[$k] = utf8_decode($value_tab);
              }
  			    }
  			    $list = new Model_DbTable_List();
  			    $profil = new Model_DbTable_Profil();
  			    $current_list = $list->find($formData_profil['idList'])->current();
  			    $items = $list->getItems($current_list,$profil->Model_id);
  			    $metadata = new Model_DbTable_Metadata();
  			    foreach($items as $item){
  			      $current_item_profil = $profil->find($item["item_idItem"])->current();
  			      if($current_item_profil->value != $dataItems[$current_item_profil->property]){
  			        $current_item_profil->value =  $dataItems[$current_item_profil->property];
  			        $current_item_profil->save(); 
  			        $item_model = new Model_DbTable_Item();
  			        $metadata->updateMeta($item_model->Model_id, $current_item_profil->item_idItem);
  			      }
  			    }
  			    $log = new Model_DbTable_Log();
            $user = new Model_DbTable_User();
            $array_log = $log->addLog($user->Model_id, $current_user->idUser,$current_user->email." a modifie la liste : ".$current_list->title, Zend_Log::INFO);
            $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
  			  }else{
  			    $list = new Model_DbTable_List();
            $profil = new Model_DbTable_Profil();
            $datalist = array();
            $datalist["title"] = "Profil";
            $datalist["categorie_idcategories"] = $profil->Category_id;
            $listid = $list->addList($datalist,$this->current_user);
            $compteur = 0;
            foreach($formData_profil as $k => $v){
            $item = new Model_DbTable_Item();
            $dataItem = array();
            $dataItem["position"] = $compteur;
            $dataProfil = array();
            $dataProfil["property"] = $k;
            if(!is_array($v)){
              $dataProfil["value"] = utf8_decode($v);
            }else{
              $dataProfil["value"] = "";
              foreach($v as $value){
                $dataProfil["value"] .= utf8_decode($value).',';
              }
            }
            $item->addItem($dataItem,$dataProfil,$listid,$profil->Model_id,$profil,$this->current_user);
            $compteur ++;
            }
            
  			  }
  			  $metadata = new Model_DbTable_Metadata();
  			  $metadata->updateMeta($user->Model_id, $current_user->idUser);
        }else{
  				$dynamic_form->populate($formData_profil);
  			}
  		}  
    }else{
      $this->_redirect('/');
    }
  }
  
  // Permet de gerer un skin
  public function skinsAction(){
    $this->_helper->layout->disableLayout(); 
    if($this->_request->isPost()){
      $arrayList = $this->getRequest()->getPost();
      if($this->current_user){
         $user = new Model_DbTable_User();
         if($itemStructure = $user->getSkins()){
            $ins_struct = new Model_DbTable_StructureP();
            $mstruct = $ins_struct->getStructure($itemStructure[0]['item_idItem']);
            $mstruct->value = serialize($arrayList); 
            $mstruct->save();
         }else{
           $profil = new Model_DbTable_Profil();
           $datalist = array();
           $datalist['categorie_idcategories'] =$profil->Model_id; 
           $datalist['title'] = "SkinsDeProfil";
           $list = new Model_DbTable_List();
           $listid = $list->addList($datalist,$this->current_user);
           $structureP = new Model_DbTable_StructureP();
           $dataProfil = array();
           $dataItem = array();
           $dataItem['position'] = 0; 
           $dataProfil['name'] ='home'; 
           $dataProfil['value'] = serialize($arrayList); 
           $item = new Model_DbTable_Item();
           $item->addItem($dataItem,$dataProfil,$listid,$structureP->Model_id,$structureP,$this->current_user);
         }
       }
    }
    $this->_redirect('/');
  }
  
  // Permet de recupere le skin de l'utilisateur
  public function skinAction(){
    $this->_helper->layout->disableLayout();
   if($this->current_user){
      $user = new Model_DbTable_User();
      if($itemStructure = $user->getSkins()){
        $this->view->skins = $itemStructure;
      }else{
        $this->view->skins = false;
      }
    }else{
      $this->view->skins = false;
    }
  }
  
  // Permet de recuperer le JS
  public function skinjsAction(){
    $this->_helper->layout->disableLayout();
   if($this->current_user){
      $user = new Model_DbTable_User();
      if($itemStructure = $user->getSkins()){
        $this->view->skins = $itemStructure;
      }else{
        $this->view->skins = false;
      }
    }else{
      $this->view->skins = false;
    }
  }
  
  // Permet de recuperer les notifications
  public function notificationAction(){
    $this->_helper->layout->disableLayout();
    if($this->current_user){
      $user = new Model_DbTable_User();
      if($list_notifications = $user->getListNotification()){
        $notification = new Model_DbTable_Notification();
        $list= new Model_DbTable_List();
        $this->view->notifications = $list->getItems($list_notifications,$notification->Model_id);
      }else{
        $this->view->notifications = array();
      }
    }
  }
  
  // Permet de recuperer les informations d'un utilisateur (profil + liste + amis) 
  public function infoAction(){
    $inst_user = new Model_DbTable_User();  
    $this->view->login = urlencode($this->getRequest()->username);
    $rows = $inst_user->fetchAll($inst_user->select()->where('login = ?', $this->getRequest()->username));
    if(count($rows) == 1){
      $view_user = $inst_user->find($rows[0]['idUser'])->current(); 
      $this->view->view_user = $view_user;
      $this->view->profile = $inst_user->getProfile($view_user->idUser);
      $this->view->bool_connecte = $inst_user->getUser();
      if($inst_user->getUser()){
        if($lists_user = $inst_user->getLists($view_user->idUser)){
          $this->view->lists = $lists_user;
        }
        if($friends_user = $inst_user->getFriends($view_user->idUser)){
          $this->view->friends = $friends_user;
        }
      }
    }
  }
}