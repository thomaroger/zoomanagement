<?php

class FriendController extends Zend_Controller_Action {
	
	  public function init() {
      $user = new Model_DbTable_User();
      if($this->current_user = $user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      }
    }
    
    // Permet d'afficher la liste des amis en fonction de la recherche (Gestion Google Gtalk
    public function listAction(){
      $this->_helper->layout()->setLayout('layout.inclusion');
      if($this->getRequest()->getPost("type")=="search"){
        $inst_profile = new Model_DbTable_Profil();
        $query = $this->getRequest()->getPost("search");
        $tab_searches = $inst_profile->getSearch($query); 
        $this->view->query = $query;
        $this->view->tab_searches = $tab_searches;
        $this->view->type = "search";
      }else if($this->getRequest()->getPost("type")=="gmail"){
        require_once("../library/Zend/Service/Gmail.php");
        $this->view->query = "Listes des contacts";
        $contacts = get_contacts($this->getRequest()->getPost("login"),$this->getRequest()->getPost("password"));
        $logins = $contacts[0];
  	    $mails = $contacts[1];
        $tabs_searches = array();
        for($i=0;$i<count($logins);$i++){
          $tabs_searches[strtolower($mails[$i])] = $logins[$i];
        }
        $this->view->tabs_searches = $tabs_searches;
        $this->view->type = "gmail";
      }
    }
    
    public function searchAction(){
    }
    
    // Permet d'inviter un ami par mail
    public function mailAction(){
      $this->_helper->layout->disableLayout();
      $mail_conf = Zend_Registry::get('Mail_Config'); 
      $smtpConnection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mail_conf['config']);
      $contentHTML = "Dear ".$this->getRequest()->getPost("mail")." <br/> You are invited by ".$this->current_user->email." on Tootlist <br />";
      $contentHTML .= "Please visit this url to register on Tootlist :<br /><br /> http://".$_SERVER['SERVER_NAME'].'/user/new/parent/'.$this->current_user->password;
      $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team"; 
      $mail = new Zend_Mail('utf-8');
      $mail->addTo($this->getRequest()->getPost("mail"))
           ->setFrom('tootlist@gmail.com', 'Tootlist Support')
           ->setSubject('You are invited on Tootlist')
           ->setBodyHtml($contentHTML);
      $mail->send($smtpConnection);
      $log = new Model_DbTable_Log();
      $metadata = new Model_DbTable_Metadata();
      $parent_user = new Model_DbTable_User();
      $array_log = $log->addLog($parent_user->Model_id,$this->current_user->idUser,"Invitation envoye a ".$this->getRequest()->getPost("mail"), Zend_Log::INFO);
	    $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
      echo "Une invitation a &eacute;t&eacute; envoy&eacute;e";
    }
    
    // Permet d'ajouter un utilisateur comme ami
    public function addAction(){
      $this->_helper->layout->disableLayout();
      $mail_conf = Zend_Registry::get('Mail_Config');
      $user_friend = new Model_DbTable_User();
      $user_friend_current = $user_friend->find($this->getRequest()->getPost("idFriend"))->current(); 
      $smtpConnection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mail_conf['config']);
      $contentHTML = "Dear ".$user_friend_current->login." <br/>";
      $contentHTML .= $this->current_user->email." you asked a friend.";
      $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team"; 
      $mail = new Zend_Mail('utf-8');
      $mail->addTo($user_friend_current->email)
           ->setFrom('tootlist@gmail.com', 'Tootlist Support')
           ->setSubject('A new Friend on Tootlist')
           ->setBodyHtml($contentHTML);
      $mail->send($smtpConnection);
      $log = new Model_DbTable_Log();
      $metadata = new Model_DbTable_Metadata();
      $parent_user = new Model_DbTable_User();
      $array_log = $log->addLog($parent_user->Model_id,$this->current_user->idUser,"Demande d'ajout d'ami a ".$user_friend_current->email, Zend_Log::INFO);
	    $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
	    $listNotification = $user_friend->getListNotification($user_friend_current->idUser);
	    $item = new Model_DbTable_Item();
	    $notification = new Model_DbTable_Notification();
	    
	    $listFriend = $user_friend->getListFriend($user_friend_current->idUser);
	    $item = new Model_DbTable_Item();
	    $friend = new Model_DbTable_Friend();
	    $data =array('id_user'=>$this->current_user->idUser,'status'=>$friend->Nactive);
	    $idItem = $item->addItem(array('position'=>0),$data,$listFriend->idList,$friend->Model_id,$friend,$user_friend_current);
	    
	    $data =array('click'=>1,
	                 'title'=>"Demande d'ajout d'ami",
	                 'lu'=>0);
	    $idNotification = $item->addItem(array('position'=>0),$data,$listNotification->idList,$notification->Model_id,$notification,$user_friend_current);
	    $current_notification = $notification->find($idNotification)->current();
	    $current_notification->description = "Vous avez recu une demande d'ajout d'ami de la part de <a href='/view/".$this->current_user->login."'>".$this->current_user->login."</a>.<br /> <a href='javascript:void(0)' onclick='Tootlist.friend.actionFriend(".$idNotification.",".$idItem.",".$friend->Accept.");'>Accepter</a> ou <a href='javascript:void(0)' onclick='Tootlist.friend.actionFriend(".$idNotification.",".$idItem.",".$friend->Refuse.");'>Refuser</a>.<span style='display:none;' id='notification_".$idNotification."'>&nbsp;</span>";
	    $current_notification->save();
	   
	    $listFriend = $user_friend->getListFriend();
	    $item = new Model_DbTable_Item();
	    $friend = new Model_DbTable_Friend();
	    $data =array('id_user'=>$user_friend_current->idUser,'status'=>$friend->Nactive);
	    $item->addItem(array('position'=>0),$data,$listFriend->idList,$friend->Model_id,$friend,$this->current_user);
	   	    
	    echo "Une demande d'ami a &eacute;t&eacute; envoy&eacute;e";  
    }
    
    // Permet d'accepter une demande d'ami
    public function acceptAction(){
     $this->_helper->layout->disableLayout();
     $friend = new Model_DbTable_Friend();
     $item = new Model_DbTable_Item();
     $current_item= $item->find($this->getRequest()->getPost("idItemF"))->current(); 
     $notification = new Model_DbTable_Notification();
     $current_notification = $notification->find($this->getRequest()->getPost("idNotif"))->current();
     $current_notification->lu = 1;
     $current_notification->save();
     $user = new Model_DbTable_User();
     $current_user = $user->getUser();
     $current_item_friend = $friend->find($current_item->idItem)->current(); 
     $user_friend= $user->find($current_item_friend->id_user)->current();
     $friend->acceptDemand($current_user,$user_friend,$current_item_friend); 
     
     $log = new Model_DbTable_Log();
	   $metadata = new Model_DbTable_Metadata();
     $parent_user = new Model_DbTable_User();
     $array_log = $log->addLog($parent_user->Model_id,$current_user->idUser,$current_user->login." et ".$user_friend->login." sont maintenant amis", Zend_Log::INFO);
	   $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
    }
    
    // Permet de refuser une demande d'ami
    public function refuseAction(){
     $this->_helper->layout->disableLayout();
     $friend = new Model_DbTable_Friend();
     $item = new Model_DbTable_Item();
     $current_item= $item->find($this->getRequest()->getPost("idItemF"))->current(); 
     $notification = new Model_DbTable_Notification();
     $current_notification = $notification->find($this->getRequest()->getPost("idNotif"))->current();
     $current_notification->lu = 1;
     $current_notification->save();
     $user = new Model_DbTable_User();
     $current_user = $user->getUser();
     $current_item_friend = $friend->find($current_item->idItem)->current(); 
     $user_friend= $user->find($current_item_friend->id_user)->current();
     $friend->refuseDemand($current_user,$user_friend,$current_item_friend); 
     
     $log = new Model_DbTable_Log();
	   $metadata = new Model_DbTable_Metadata();
     $parent_user = new Model_DbTable_User();
     $array_log = $log->addLog($parent_user->Model_id,$current_user->idUser,$current_user->login." et ".$user_friend->login." ne sont pas amis", Zend_Log::INFO);
	   $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
	   
    }
}