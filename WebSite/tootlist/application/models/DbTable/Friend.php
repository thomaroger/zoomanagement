<?php

class Model_DbTable_Friend extends Zend_Db_Table_Abstract {

  protected $_name    = 'friend';
  protected $_primary = 'item_idItem';
  public $Model_id    = 21;
  
  public $Nactive     = 0;
  public $Active      = 1;
  public $Rejete      = 2;
  
  
  public $Accept     = 1;
  public $Refuse     = 0;

  
  public function acceptDemand($current_user,$friend,$current_item_friend) {
    // Methode qui permet d'accepter une demande d'ami
    // $current_user : correspond à l'utilisateur courant
    // $friend : correspond à  un utilisateur quelconque qui va etre ami avec l'utilisateur ami
    // $current_item_friend : correspond a l'item de la demande d'ami de l'utisateur en cours
    
    $user = new Model_DbTable_User();
    
    $current_user_friends_list = $user->getListFriend();
    $list= new Model_DbTable_List();
    $friends= $list->getItems($current_user_friends_list,$this->Model_id);
    foreach($friends as $friend_user){
      $current_item_friend = $this->find($friend_user["item_idItem"])->current();
      if($current_item_friend->status == $this->Nactive && $current_item_friend->item_idItem == $current_item_friend->item_idItem){
          $current_item_friend->status = $this->Active;
          $current_item_friend->save();
      }
    }
    
    $listNotification = $user->getListNotification();
	  $item = new Model_DbTable_Item();
	  $notification = new Model_DbTable_Notification();
	  $item = new Model_DbTable_Item();
	  $data =array('click'=>0,
	               'title'=>"Demande d'ajout d'ami",
	               'description' => $friend->login." est maintenant votre ami !!",
	               'lu'=>0);
	  $idNotification = $item->addItem(array('position'=>0),$data,$listNotification->idList,$notification->Model_id,$notification,$current_user);
    
    $friend_friends_list = $user->getListFriend($friend->idUser);
    $list= new Model_DbTable_List();
    $friends= $list->getItems($friend_friends_list,$this->Model_id);
    foreach($friends as $friend_user){
      $current_item_friend = $this->find($friend_user["item_idItem"])->current();
      if($current_item_friend->status == $this->Nactive && $current_item_friend->id_user == $current_user->idUser){
        $current_item_friend->status = $this->Active;
        $current_item_friend->save();
      }
    }
    
    $user = new Model_DbTable_User(); 
    $listNotification = $user->getListNotification($friend->idUser);
	  $item = new Model_DbTable_Item();
	  $notification = new Model_DbTable_Notification();
	  $item = new Model_DbTable_Item();
	  $data =array('click'=>0,
	               'title'=>"Demande d'ajout d'ami",
	               'description' => $current_user->login." est maintenant votre ami !!",
	               'lu'=>0);
	  $idNotification = $item->addItem(array('position'=>0),$data,$listNotification->idList,$notification->Model_id,$notification,$friend);
	  
	  $mail_conf = Zend_Registry::get('Mail_Config'); 
    $smtpConnection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mail_conf['config']);
    
    $contentHTML = "Dear ".$current_user->login.",<br /> <br/>".$friend->login." is now your friend<br />";
    $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team"; 
    $mail = new Zend_Mail('utf-8');
    $mail->addTo($current_user->email)
         ->setFrom('tootlist@gmail.com', 'Tootlist Support')
         ->setSubject('A new friend on Tootlist')
         ->setBodyHtml($contentHTML);
    $mail->send($smtpConnection);
    
    $contentHTML = "Dear ".$friend->login.",<br /> <br/>".$current_user->login." is now your friend<br />";
    $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team"; 
    $mail = new Zend_Mail('utf-8');
    $mail->addTo($friend->email)
         ->setFrom('tootlist@gmail.com', 'Tootlist Support')
         ->setSubject('A new friend on Tootlist')
         ->setBodyHtml($contentHTML);
    $mail->send($smtpConnection);    
  }
  
  public function refuseDemand($current_user,$friend) {
    // Methode qui permet de refuser une demande d'ami
    // $current_user : correspond à l'utilisateur courant
    // $friend : correspond à  un utilisateur quelconque qui va etre ami avec l'utilisateur ami
        
    $user = new Model_DbTable_User();
    
    $current_user_friends_list = $user->getListFriend();
    $list= new Model_DbTable_List();
    $friends= $list->getItems($current_user_friends_list,$this->Model_id);
    foreach($friends as $friend_user){
      $current_item_friend = $this->find($friend_user["item_idItem"])->current();
      if($current_item_friend->status == $this->Nactive && $current_item_friend->item_idItem == $current_item_friend->item_idItem){
          $current_item_friend->status = $this->Rejete;
          $current_item_friend->save();
      }
    }
     
    $listNotification = $user->getListNotification();
	  $item = new Model_DbTable_Item();
	  $notification = new Model_DbTable_Notification();
	  $item = new Model_DbTable_Item();
	  $data =array('click'=>0,
	               'title'=>"Demande d'ajout d'ami",
	               'description' => "Vous avez rejet&eacute; la demande d'ami de ".$friend->login,
	               'lu'=>0);
	  $idNotification = $item->addItem(array('position'=>0),$data,$listNotification->idList,$notification->Model_id,$notification,$user_friend_current);
    
    $friend_friends_list = $user->getListFriend($friend->idUser);
    $list= new Model_DbTable_List();
    $friends= $list->getItems($friend_friends_list,$this->Model_id);
    foreach($friends as $friend_user){
      $current_item_friend = $this->find($friend_user["item_idItem"])->current();
      if($current_item_friend->status == $this->Nactive && $current_item_friend->id_user == $current_user->idUser){
        $current_item_friend->status = $this->Rejete;
        $current_item_friend->save();
      }
    }
    
    $user = new Model_DbTable_User(); 
    $listNotification = $user->getListNotification($friend->idUser);
	  $item = new Model_DbTable_Item();
	  $notification = new Model_DbTable_Notification();
	  $item = new Model_DbTable_Item();
	  $data =array('click'=>0,
	               'title'=>"Demande d'ajout d'ami",
	               'description' => $current_user->login." a rejet&eacute; votre amit&eacute; !!",
	               'lu'=>0);
	  $idNotification = $item->addItem(array('position'=>0),$data,$listNotification->idList,$notification->Model_id,$notification,$user_friend_current);
  }

}
