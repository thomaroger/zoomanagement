<?php

class AgendaController extends Zend_Controller_Action {

  public function init() {
    $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      //$this->_redirect('/');
    }
  }
  
  // Affichage de l'agenda avec tous les evenements (Par Mois)
  public function indexAction(){
    $user = new Model_DbTable_User();
    if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
    if(!$this->getRequest()->getParam('referer')){
      $this->_helper->layout->disableLayout(); 
    }
    $this->view->month = $this->getRequest()->getParam('month');
    $this->view->year = $this->getRequest()->getParam('year');
    $this->view->view = $this->getRequest()->getParam('view');
    $this->view->week = 0;
    if($this->view->view == "week"){
      $this->view->week = $this->getRequest()->getParam('week');
    }
    
    $lists = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList();
    $items = array();
    $event = new Model_DbTable_Event();
    $inst_list = new Model_DbTable_List();
    foreach($lists as $list){
      $items[] = $inst_list->getItems($list,$event->Model_id);
    }
    
    $events = array();
    foreach ($items as $item_tmp){
      foreach($item_tmp as $item){
        if(is_array($item)){
          $events[] = $item;
        }
      }
    }
    $this->view->events = $events;
  }  
	
	// Permet de voir les informations d'un evenements
	public function recallAction(){
	  $user = new Model_DbTable_User();
	  if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
	  
	  $this->_helper->layout->disableLayout(); 
	  $inst_event = new Model_DbTable_Event();
	  $event = $inst_event->find($this->getRequest()->getParam('id'))->current();
	  $this->view->event = $event;
	}
		
  // Permet de voir les rappels
	public function viewrecallAction(){
	  $user = new Model_DbTable_User();
	  if($this->current_user = $user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      //$this->_redirect('/');
    }
    
	  $this->_helper->layout->disableLayout(); 
	  $inst_event = new Model_DbTable_Event();
	  $event = $inst_event->find($this->getRequest()->getParam('idEvent'))->current();
	  $this->view->event = $event;
	  $inst_user = new Model_DbTable_User();
    $listrecall = $inst_user->getListRecall();
    $inst_recall = new Model_DbTable_Recall();
    $this->view->recalls = $inst_recall->getRecalls($listrecall,$this->getRequest()->getParam('idEvent'));
	}
	
	// Permet d'ajouter un rappel pour un evenements
	public function addrecallAction(){
	 $this->_helper->layout->disableLayout(); 
	 $this->_helper->viewRenderer->setNoRender();
	 $tmp_recall = $this->getRequest()->getPost();
	 $dataRecall = $tmp_recall["recall"];
	 $inst_recall = new Model_DbTable_Recall();
	 $inst_item = new Model_DbTable_Item();
	 $dataRecall["status"] = Model_DbTable_Recall::ENCOURS;
	 $dataItem = array();
   $dataItem["position"] = 0;
   $inst_user = new Model_DbTable_User();
   $listrecall = $inst_user->getListRecall();
	 $inst_item->addItem($dataItem,$dataRecall,$listrecall['idList'],$inst_recall->Model_id,$inst_recall,$this->current_user);
	}
	
  // Permet de supprimer un rappel pour un evenement
	public function deleterecallAction(){
	 $this->_helper->layout->disableLayout(); 
	 $this->_helper->viewRenderer->setNoRender();
	 $inst_item = new Model_DbTable_Item();
	 $inst_recall = new Model_DbTable_Recall();
	 $inst_type = new Model_DbTable_Type();
	 $item = $inst_item->find($this->getRequest()->getParam('idItem'))->current();
	 $recall = $inst_recall->find($this->getRequest()->getParam('idItem'))->current();
	 $type = $inst_type->find($item->type_idtype)->current();
	 
	 $recall->delete();
	 $item->delete();
	 $type->delete();
	}
	
	
  // Permet d'ajouter une notification pour un rappel d'un evenement
	public function notificationAction(){
	  $this->_helper->layout->disableLayout(); 
	  $this->_helper->viewRenderer->setNoRender();
	  
	  $inst_recall = new Model_DbTable_Recall();
	  $recalls = $inst_recall->fetchAll($inst_recall->select()->where('status = ?',Model_DbTable_Recall::ENCOURS));
	  foreach($recalls as $recall){
 	    $inst_item = new Model_DbTable_Item();
 	    $inst_event = new Model_DbTable_Event();
      $item_recall = $inst_recall->find($recall->item_idItem)->current();
	    $item_item = $inst_item->find($recall->Event_idEvent)->current();
	    $item_event = $inst_event->find($recall->Event_idEvent)->current();
	    $tmp_date = explode(" ",$item_event['date_begin']);
	    $tmp_date = explode("-",$tmp_date[0]);
	    $timestamp_event_begin = mktime('0','0','0',$tmp_date[1],$tmp_date[2],$tmp_date[0]);
	    $timestamp_rappel = strtotime ("- ".$item_recall["number"]." ".Model_DbTable_Recall::$scaleEn[$recall["timescale"]], $timestamp_event_begin);
	    if($timestamp_rappel - time() < 0){
	       if($item_recall["type"]==Model_DbTable_Recall::MAIL){
           $tab_list = $item_item->findParentRow(Model_DbTable_List);
           $list = new Model_DbTable_List();
           $current_list = $list->find($tab_list['idList'])->current();
           $list_user = $current_list->findModel_DbTable_UserViaModel_DbTable_UserHasListByListAndUser()->current();
           $inst_user = new Model_DbTable_User();
           $user_friend_current = $inst_user->find($list_user->idUser)->current();
           $mail_conf = Zend_Registry::get('Mail_Config'); 
           $smtpConnection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mail_conf['config']);
           $contentHTML = "Dear ".$user_friend_current->login.", <br /><br />";
           $contentHTML .= "Titre : ".$item_event->title."<br />";
    	     $contentHTML .="Debut  : ".$item_event->date_begin."<br />";
           $contentHTML .="Fin  : ".$item_event->date_begin."<br />";
           $contentHTML .="Description  : ".$item_event->description."<br />";
           $contentHTML .="Localisation  : ".$item_event->location."<br />";
           $contentHTML .="Rappel  : ".$item_recall->number." ".Model_DbTable_Recall::$scale[$item_recall->timescale]." avant ";
           $contentHTML .= "<br /><br /> See you later, <br /> Tootlist team";
           $mail = new Zend_Mail('utf-8');
           $mail->addTo($user_friend_current->email)
                ->setFrom('tootlist@gmail.com', 'Tootlist Support')
                ->setSubject('Rappel : '.$item_event->title)
                ->setBodyHtml($contentHTML);
           $mail->send($smtpConnection);
           $log = new Model_DbTable_Log();
           $metadata = new Model_DbTable_Metadata();
           $parent_user = new Model_DbTable_User();
           $array_log = $log->addLog($parent_user->Model_id,$user_friend_current->idUser,"Rappel d'evenement ".$item_event->title." envoye a ".$user_friend_current->email, Zend_Log::INFO);
           $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
           $item_recall->status = 1;
    	     $item_recall->save();
  	     }else{
	         $notification = new Model_DbTable_Notification();
           $tab_list = $item_item->findParentRow(Model_DbTable_List);
           $list = new Model_DbTable_List();
           $current_list = $list->find($tab_list['idList'])->current();
           $list_user = $current_list->findModel_DbTable_UserViaModel_DbTable_UserHasListByListAndUser()->current();
           $inst_user = new Model_DbTable_User();
           $listNotification = $inst_user->getListNotification($list_user->idUser);
           $user_friend_current = $inst_user->find($list_user->idUser)->current();
           $data =array('click'=>0,
	                 'title'=>"Rappel d'&eacute;v&eacute;nement",
	                 'lu'=>0);
    	    $idNotification = $inst_item->addItem(array('position'=>0),$data,$listNotification->idList,$notification->Model_id,$notification,$user_friend_current);
    	    $current_notification = $notification->find($idNotification)->current();
    	    $description = "Titre : ".$item_event->title."<br />";
    	    $description .="Debut  : ".$item_event->date_begin."<br />";
          $description .="Fin  : ".$item_event->date_begin."<br />";
          $description .="Description  : ".$item_event->description."<br />";
          $description .="Localisation  : ".$item_event->location."<br />";
          $description .="Rappel  : ".$item_recall->number." ".Model_DbTable_Recall::$scale[$item_recall->timescale]." avant ";
          $current_notification->description = $description;
    	    $current_notification->save();
    	    $item_recall->status = 1;
    	    $item_recall->save();
	       }
	    }
	  }
	}
	
  // Permet de synchroniser avec Google Agenda
	public function createeventAction(){
    $this->_helper->layout->disableLayout(); 
    $lists = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList();
    $items = array();
    $event = new Model_DbTable_Event();
    $inst_list = new Model_DbTable_List();
    foreach($lists as $list){
      $items[] = $inst_list->getItems($list,$event->Model_id);
    }
    
    $events = array();
    foreach ($items as $item_tmp){
      foreach($item_tmp as $item){
        if(is_array($item)){
          $events[] = $item;
        }
      }
    }
    $this->view->events = $events;
	}
}