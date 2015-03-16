<?php

class MessageController extends Zend_Controller_Action {

  public function init() {
    $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      //$this->_redirect('/');
    }
  }
  
  // Ajout des messages 
  public function indexAction(){
    $this->view->headScript()->appendFile('/javascript/textBoxList.js');
    $this->view->headLink()->appendStylesheet('/style/textBoxList.css');
     $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
  }
  
  // Permet de retrouver les amis
  public function friendAction(){
    $this->_helper->layout->disableLayout(); 
	  $this->_helper->viewRenderer->setNoRender();
	  
    $inst_user = new Model_DbTable_User();
    
    if($this->current_user = $inst_user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
    
    
    $friends = $inst_user->getFriends();
  
    $search = $this->getRequest()->getPost("search");
  
    $response = array();
    foreach($friends as $friend){
      $photo = "";
      $name="";
      $firstname="";
      $profiles_associed = $inst_user->getProfile($friend->idUser);
      if($profiles_associed){
        foreach($profiles_associed as $profile_associed){
          if($profile_associed["property"]=="name") 
            $name = $profile_associed["value"];
          if($profile_associed["property"]=="firstname") 
            $firstname = $profile_associed["value"];
          if($profile_associed["property"]=="photo") 
            $photo = $profile_associed["value"];        
        }
      }
      $true_name = "";
      if($name != ""){
        $true_name = strtoupper($name)." ".ucfirst($firstname);
      }else{
        $true_name = $friend->login;
      }
      
      if (preg_match("/^$search/i", $friend->login)){
        $response[] = array($friend->idUser, $friend->login, null, '<img src="'.$photo.'"/> ' . $friend->login);
      }else if (preg_match("/^$search/i", $firstname) || preg_match("/^$search/i", $name) ){
        $response[] = array($friend->idUser, $true_name, null, '<img src="'.$photo.'"/> ' . $true_name);
      }else{
        continue;
      }
      
    }
  
    header('Content-type: application/json');
    echo json_encode($response);
    } 
    
    // Permet d'ajouter un message
    public function addAction(){
    
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      }
      
      $destinataire = $this->getRequest()->getPost("destinataire").",";
      $sujet = $this->getRequest()->getPost("subject");
      $description = $this->getRequest()->getPost("description");

      $inst_list = new Model_DbTable_List();
      $inst_message  = new Model_DbTable_Message();   
      $inst_item = new Model_DbTable_Item();    
      $dataList=array();
      $dataList["title"]  = $sujet;
      $dataList["categorie_idcategories"]  = $inst_message->Category_id;
      $list_id= $inst_list->addList($dataList,$inst_user->getUser());
      $data= array();
      $data["title"] = $sujet;
      $data["sender_id"] = $inst_user->getUser()->idUser;
      $data["recipients_id"] = $destinataire.$inst_user->getUser()->idUser.",";
      $data["description"] = $description;
      $data["state"] = $destinataire.$inst_user->getUser()->idUser.",";
      $inst_item->addItem(array("position"=>0),$data,$list_id,$inst_message->Model_id,$inst_message,$inst_user->getUser());
      
      // Ajouter une notification pour un message pour chaque destinataire 
      $destinataires = explode(',',$destinataire);
      foreach($destinataires as $destinataire_user){
        if($destinataire_user !=""){
          $user_dest = $inst_user->find($destinataire_user)->current();
           $data =array('click'=>0,
                     'title'=>"Un nouveau message",
                     'description' => "Vous avez un nouveau message de ".$this->current_user->login." <br /> Vous pouvez le lire en cliquant <a href='/message/index'>ici</a>.",
                     'lu'=>0);
          $notification = new Model_DbTable_Notification();
          $notification->addNotification($data,$user_dest);
        }
      }
      
      $this->_redirect('/message/index');
    }
    
    // Permet de lister les messages
    public function listAction(){   
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      }

      $inst_message = new Model_DbTable_Message();
      $inst_list = new Model_DbTable_List();
      $discussions_tmp =  $inst_message->getDiscussions();
      $discussions = array();
      foreach($discussions_tmp as $idList => $discussion ){
          $sender_msg = $inst_user->find($discussion["user"])->current(); 
          $infos_sender = $inst_user->getName($sender_msg->idUser);
          $discussions[$idList]["login"] = $sender_msg->login;
          $discussions[$idList]["sender_name"] = $sender_msg->login." (".strtoupper($infos_sender["name"])." ".ucfirst($infos_sender["firstname"]).")";
          $discussions[$idList]["photo"] = $infos_sender["photo"];
          $current_list = $inst_list->find($idList)->current();
          $discussions[$idList]["title"] = $current_list->title;
          $items = $inst_list->getItems($current_list,$inst_message->Model_id);
          foreach($items as $item){
            $discussions[$idList]["content"] = $item["description"];
            $recipients_id = trim($item["recipients_id"],','); 
          }
          $destinataires_msg = "";
          foreach(explode(',',$recipients_id) as $recipient_id){
            $infos_dest = $inst_user->getName($recipient_id);
            $infos_dest_obj = $inst_user->find($recipient_id)->current();
            $destinataires_msg .= " ".$infos_dest_obj->login." (".strtoupper($infos_dest["name"])." ".ucfirst($infos_dest["firstname"]).")".",";
          }
          $discussions[$idList]["destinataires_msg"] = trim($destinataires_msg);
          
      }
      
      $this->view->discussionsUnread = $inst_message->getDiscussionsUnread();
      $this->view->discussions = $discussions;
    }
    
    public function sendAction(){
      
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      }
    
       $inst_message = new Model_DbTable_Message();

      $inst_list = new Model_DbTable_List();
      $discussions_tmp =  $inst_message->getDiscussionsSend();
      $discussions = array();
      foreach($discussions_tmp as $idList => $discussion ){
          $sender_msg = $inst_user->find($discussion["user"])->current(); 
          $infos_sender = $inst_user->getName($sender_msg->idUser);
          $discussions[$idList]["login"] = $sender_msg->login;
          $discussions[$idList]["sender_name"] = $sender_msg->login." (".strtoupper($infos_sender["name"])." ".ucfirst($infos_sender["firstname"]).")";
          $discussions[$idList]["photo"] = $infos_sender["photo"];
          $current_list = $inst_list->find($idList)->current();
          $discussions[$idList]["title"] = $current_list->title;
          $items = $inst_list->getItems($current_list,$inst_message->Model_id);
          foreach($items as $item){
            $discussions[$idList]["content"] = $item["description"];
            $recipients_id = trim($item["recipients_id"],','); 
          }
          $destinataires_msg = "";
          foreach(explode(',',$recipients_id) as $recipient_id){
            $infos_dest = $inst_user->getName($recipient_id);
            $infos_dest_obj = $inst_user->find($recipient_id)->current();
            $destinataires_msg .= " ".$infos_dest_obj->login." (".strtoupper($infos_dest["name"])." ".ucfirst($infos_dest["firstname"]).")".",";
          }
          $discussions[$idList]["destinataires_msg"] = trim($destinataires_msg);
          
      }
      
      $this->view->discussions = $discussions;
    } 
    
    // Permet de voir les messages
    public function viewAction(){
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      }
    
      $id = $this->getRequest()->getParam('id');
      $inst_list = new Model_DbTable_List();
      $inst_user = new Model_DbTable_User();
      $inst_message = new Model_DbTable_Message();
      $current_list = $inst_list->find($id)->current();
      $items = $inst_list->getItems($current_list,$inst_message->Model_id);   
      $this->view->list = $current_list;  
      $this->view->items = $items;
    }
    
    // Permet d'ajouter un message
    public function addmessageAction(){
       $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      } 
       $inst_list = new Model_DbTable_List(); 
       $this->_helper->layout->disableLayout(); 
       $this->view->idList = $this->getRequest()->getParam('id');  
       $this->view->list = $inst_list->find($this->getRequest()->getParam('id'))->current();
    }
    
    // Permet d'ajouter un message via le profil
    public function addmessageprofilAction(){
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      } 
        
       $this->_helper->layout->disableLayout(); 
       $this->view->iddestinataire = $this->getRequest()->getParam('id');
    }
    
    // Permet de repondre ˆ un message
    public function responseAction(){
      $this->_helper->layout->disableLayout(); 
	    $this->_helper->viewRenderer->setNoRender();
	    $inst_list = new Model_DbTable_List();
      
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $this->view->current_user = $this->current_user;
      }else{
        $this->_redirect('/');
      }
      
      $inst_message = new Model_DbTable_Message();
      $inst_item = new Model_DbTable_Item();
      $idList = $this->getRequest()->getParam('idList');
      $description = $this->getRequest()->getParam('description_message');
      $current_list = $inst_list->find($idList)->current();
      $items = $inst_list->getItems($current_list,$inst_message->Model_id);
      $data2 = array();
      $data = array();
      $data2["sender_id"] = $inst_user->getUser()->idUser;
      $data2["recipients_id"] = $items[0]["recipients_id"];
      $data2["state"] = $items[0]["recipients_id"];
      $data2["description"] = $description;
      $data = array('position'=>count($items));
      $inst_item->addItem($data,$data2,$idList,$inst_message->Model_id,$inst_message,$inst_user->getUser());
      
      $destinataires = explode(',',$items[0]["recipients_id"]);
      foreach($destinataires as $destinataire_user){
        if($destinataire_user !=""){
          $user_dest = $inst_user->find($destinataire_user)->current();
           $data =array('click'=>0,
                     'title'=>"Un nouveau message",
                     'description' => "Vous avez un nouveau message de ".$this->current_user->login." pour la discussion ".$current_list->title." <br /> Vous pouvez le lire en cliquant <a href='/message/index'>ici</a>.",
                     'lu'=>0);
          $notification = new Model_DbTable_Notification();
          $notification->addNotification($data,$user_dest);
      }
    }
      
    $this->_redirect('/message/index');
    }
    
    // Permet de verifier si l'utilisateur a un message
    public function verifAction(){
      $this->_helper->layout->disableLayout(); 
      $inst_user = new Model_DbTable_User();
      if($this->current_user = $inst_user->getUser()) {
        $current_user = $inst_user->getUser();
        $inst_message = new Model_DbTable_Message();
        $this->view->nb = $inst_message->getNbMessageUnread();
      }
    }
}
