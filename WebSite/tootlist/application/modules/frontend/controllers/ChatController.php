<?php

class ChatController extends Zend_Controller_Action {

  public $inst_user;
  public $inst_message;
  public $inst_list;
  public $inst_item;
  public $inst_chat;
  public $inst_notification;
  public $current_user;
  
  public function init() {
    $this->inst_user = new Model_DbTable_User();
    $this->inst_message = new Model_DbTable_Message();
    $this->inst_list = new Model_DbTable_List();
    $this->inst_item = new Model_DbTable_Item();
    $this->inst_chat = new Model_DbTable_Chat();
    $this->inst_notification = new Model_DbTable_Notification();
    if($this->current_user = $this->inst_user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      //$this->_redirect('/');
    }
  }
  
  public function indexAction(){
    if(! $this->current_user){
      $this->_redirect('/');
    }
    $this->view->onlineFriends = $this->inst_user->getOnlineFriend();
  }
  
  // Permet de recuperer les discussions et les friends connectes
  public function updateAction(){
    $this->_helper->layout->disableLayout(); 
    $this->view->onlineFriends = $this->inst_user->getOnlineFriend();
    $discussions = array();
    foreach($this->view->onlineFriends as $id => $friend){
      $discussions[$id] = $this->inst_chat->getChat($this->current_user, $this->inst_user->find($id)->current());
    }
    $this->view->discussions = $discussions;
  }
  
  // Permet d'ajouter un item dans la discussion
  public function addAction(){
    $this->_helper->layout->disableLayout(); 
	  $this->_helper->viewRenderer->setNoRender();
	  $description = $this->getRequest()->getPost("description");
	  $user_id = $this->getRequest()->getPost("user_id");

	  $select = $this->inst_list->select()->where('categorie_idcategories = ?',$this->inst_message->Category_id)->where('title = ?', 'chat_'.$user_id);
    $list = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select);
	  if(count($list)==0){
	     $select2 = $this->inst_list->select()->where('categorie_idcategories = ?',$this->inst_message->Category_id)->where('title = ?', 'chat_'.$this->current_user->idUser);
       $list2 = $this->inst_user->find($user_id)->current()->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select2);
	     if(count($list2) == 0){
  	     $data = array("title"=>'chat_'.$user_id,"categorie_idcategories"=>$this->inst_message->Category_id);
  	     $idList = $this->inst_list->addList($data,$this->current_user);
	     }else {
	       $idList = $list2[0]['idList'];
	     }
	  }else{
	     $idList = $list[0]['idList'];
	  }
	  $data = array('position'=>0);
	  $data2 = array('description'=>$description,'user_id'=>$user_id,'status'=>Model_DbTable_Chat::NOUVEAU);
	  
    $this->inst_item->addItem($data,$data2,$idList,$this->inst_chat->Model_id,$this->inst_chat,$this->current_user);  
    
    $notif =array('click'=>0,
                 'title'=>"Nouveau message instantan&eacute; !",
                 'description' => "Vous avez un nouveau message de la part de ".$this->current_user->login." <br /> Vous pouvez le voir en cliquant <a href='/chat/index' target='_blank'>ici</a>.",
                 'lu'=>0);             
    $this->inst_notification->addNotification($notif,$this->inst_user->find($user_id)->current());  
  }

}
