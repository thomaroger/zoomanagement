<?php

class Model_DbTable_Item extends Zend_Db_Table_Abstract {

  protected $_name = 'item';
  protected $_primary = 'idItem';
  
  public $Model_id = 7;
  
  protected $_referenceMap    = array(
    'List' => array (
      'columns' => array('list_idList'),
      'refTableClass' => 'Model_DbTable_List',
      'refColumns' => array('idList')
    ),
    'Type' => array(
      'columns'           => array('type_idtype'),
      'refTableClass'     => 'Model_DbTable_Type',
      'refColumns'        => array('idtype')
    ),
    'Profil' => array(
      'columns'           => array('idItem'),
      'refTableClass'     => 'Model_DbTable_Profil',
      'refColumns'        => array('item_idItem')
  ));
   
    
  public function addItem($data,$data2,$list_id,$model_id,$model,$current_user){
    // Ajout d'un item 
    // $data : Tableau qui contient toutes les valeurs ˆ insŽrer dans la table item
    // $data2 : Tableau qui contient toutes les valeurs ˆ insŽrer dans la table du model qui correspond au type de l'item
    // $list_id : correspond ˆ l'id de la liste auquelle l'item appartient
    // $model_id : correspond ˆ l'id du model qui correspond au type de l'item
    // $model : Instance du model qui correspond au type de l'item
    // $user : Instance de l'utilisateur courant
    // Return l'id de l'item ajoute
    
    $session = Zend_Registry::get('session');
	  if($session->lang ==""){
	   $session->lang = 'fr';
	  }
	  $lang = $session->lang;
	  $configuration = new Model_DbTable_Configuration();
    $row = $configuration->getConfiguration($lang);
    $data_pred ="";
    $bool = false;
    foreach($data2 as $k=>$v){
      foreach(explode(',',trim($row->forbidden_word,',')) as $word){
        $data_pred = $v;
        $pattern = "/\s($word)\s/";
        $v = preg_replace($pattern," ".str_repeat('*',strlen($word)),$v);
        if($data_pred != $v){
          $data2[$k]= $v;
          $bool = true;
        }
      }
    }
    
    if($bool){
       $data_notif=array();
       $data_notif =array('click'=>0,
                 'title'=>"Mot interdit",
                 'description' => "Vous avez utilis&eacute; un mot inderdit. Afin de respecter les conditions d'utilisation du site, nous l'avons remplac&eacute; par des *",
                 'lu'=>0);
       $notification = new Model_DbTable_Notification();
       $notification->addNotification($data_notif,$current_user);
    }
    
    $type = new Model_DbTable_Type();
    $typedata["model_id"] = $model_id;
    $type_id=$type->insert($typedata);
    $data["list_idList"] = $list_id;
    $data["type_idtype"] = $type_id;
    $item_id = $this->insert($data);
    $metadata = new Model_DbTable_Metadata();
    $metadata->addMeta($this->Model_id, $item_id, null, null);
    $log = new Model_DbTable_Log();
    $user = new Model_DbTable_User();
    $model_type  = new Model_DbTable_Model();
    $array_log = $log->addLog($user->Model_id, $current_user->idUser,$current_user->email." a cree une item de type ".$model_type->getModel($model_id)->libelle_fr."(".$model_id.")", Zend_Log::INFO);
    $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
    $data2["item_idItem"] = $item_id;
    $model->insert($data2);
    return $item_id;
  } 
  
  
  public function getType($current_item){  
   // Permet de recuperer le model d'un item
   $inst_type = new Model_DbTable_Type();
   $inst_model = new Model_DbTable_Model();
   $current_type = $inst_type->getType($current_item->type_idtype);
   $current_model = $inst_model->getModel($current_type->model_id);
   return $current_model->table_name;
  }
    
}
