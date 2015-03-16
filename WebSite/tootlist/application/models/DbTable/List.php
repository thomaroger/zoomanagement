<?php

class Model_DbTable_List extends Zend_Db_Table_Abstract
{

  protected $_name = 'list';
  protected $_primary = 'idList';
  
  public $Model_id = 6;
  
  protected $_referenceMap = array(
    'List' => array(
      'columns'           => array('list_idList'),
      'refTableClass'     => 'Model_DbTable_List',
      'refColumns'        => array('idList')
    ));
    
    
  const PUBLIQUE = 0;
  const PRIVEE = 1;
  const PROTEGE = 2;
  
  public static $type = array(self::PUBLIQUE => "Publique",
                              self::PRIVEE => "Privee",
                              self::PROTEGE => "Protegee");  

    
  public function addList($data,$current_user) {
    // Permet d'ajout une liste 
    // $data : Tableau qui contient toutes les valeur de la table list
    // $user : correpond a l'instance de l'utilisateur
    // Return $idList : correspond � l'id de la liste cr��e
    
    $profil = new Model_DbTable_Profil();
    $message = new Model_DbTable_Message();
    $chat = new Model_DbTable_Chat();
    
    if($current_user->quota_list <=0 && $data["categorie_idcategories"] !=$profil->Category_id  && $data["categorie_idcategories"] !=$message->Category_id  && $data["categorie_idcategories"] !=$chat->Category_id ){
      $inst_notif = new Model_DbTable_Notification();
      $notif =array('click'=>0,
                 'title'=>"Quota de liste atteint !",
                 'description' => "Vous avez atteint votre quota de liste. Vous pouvez augmenter votre quota en invitant des personnes.",
                 'lu'=>0);  
      $inst_notif->addNotification($notif,$current_user);
      $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
      $redirector->gotoSimple('index','index');
    }
    
    $session = Zend_Registry::get('session');
	  if($session->lang ==""){
	   $session->lang = 'fr';
	  }
	  $lang = $session->lang;
	  $configuration = new Model_DbTable_Configuration();
    $row = $configuration->getConfiguration($lang);
    $data_pred ="";
    $bool = false;
    foreach($data as $k=>$v){
      if($k =="title" || $k =="description" || $k =="tag")
      foreach(explode(',',trim($row->forbidden_word,',')) as $word){
        $data_pred = $v;
        $pattern = "/\s($word)\s/";
        $v = preg_replace($pattern," ".str_repeat('*',strlen($word)),$v);
        if($data_pred != $v){
          $data[$k]= $v;
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
    
    $data["permission"] = self::PRIVEE;
    $idList = $this->insert($data);
    $metadata = new Model_DbTable_Metadata();
	  $metadata->addMeta($this->Model_id, $idList, null, null);
    $log = new Model_DbTable_Log();
    $user = new Model_DbTable_User();
    $array_log = $log->addLog($user->Model_id, $current_user->idUser,$current_user->email." a cree une liste : ".$data["title"], Zend_Log::INFO);
    $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
    $userHasList = new Model_DbTable_UserHasList();
    $userHasList->add($idList,$current_user->idUser);
    $current_user->quota_list = $current_user->quota_list - 1;
    $current_user->save();
    return $idList;
  }
  
  public function getItems($current_list, $model_id, $trie = "position ASC" ){
    // Permet de recuperer les items d'une liste en fonction du type
    // $current_list : correpond a la liste
    // $model_id : correspond au type de l'item
    // Return les differents items de la liste
    $model = new Model_DbTable_Model();   
    $items = array(); 
    $current_model  = $model->getModel($model_id);
    $inst_item = new Model_DbTable_Item();
    $select = $inst_item->select()->order($trie);
    $current_items = $current_list->findDependentRowset('Model_DbTable_Item',null,$select);
    foreach($current_items as $item){
      $db = Zend_Db_Table::getDefaultAdapter();
      $item_model = $db->query($db->select()->from($current_model->table_name)->where(" item_idItem = ?",$item->idItem))->fetchAll();
      $item_tmp = $item_model[0];
      $item_tmp["position"] = $item->position;
      $items[] =$item_tmp;
    }
    return $items;
  }
  
  
  public function getItemsNoModel($current_list, $trie = "position ASC" ){
    // Permet de recuperer les items d'une liste
    // $current_list : correpond a la liste
    // $model_id : correspond au type de l'item
    // Return les differents items de la liste
    $model = new Model_DbTable_Model();   
    $items = array(); 
    $inst_item = new Model_DbTable_Item();
    $select = $inst_item->select()->order($trie);
    $current_items = $current_list->findDependentRowset('Model_DbTable_Item');
    foreach($current_items as $item){
      $db = Zend_Db_Table::getDefaultAdapter();
      $ins_type = new Model_DbTable_Type();
      $type = $ins_type->getType($item->type_idtype);
      $current_model  = $model->getModel($type->model_id);
      $item_model = $db->query($db->select()->from($current_model->table_name)->where(" item_idItem = ?",$item->idItem))->fetchAll();
      $item_tmp = $item_model[0];
      $item_tmp["position"] = $item->position;
      $items[] =$item_tmp;
    }
    return $items;
  }
  
  public function getLastRecent($limit = 5){
    // permet de recuperer les derniere liste crees
    // $limit : permet de recuperer un nombre definis de liste (par defaut 5)
    // retourne un tableau de listes
    $profil = new Model_DbTable_Profil();
    $message = new Model_DbTable_Message();
    $chat = new Model_DbTable_Chat();
    $db = Zend_Db_Table::getDefaultAdapter();
    $model = new Model_DbTable_Model();   
    $current_model  = $model->getModel($this->Model_id);
    return $db->query($db->select()->from($current_model->table_name)->where("categorie_idcategories != ?",$profil->Category_id)->Where("categorie_idcategories != ?",$message->Category_id)->where("categorie_idcategories != ?",$chat->Category_id)->order("idList DESC")->limit($limit))->fetchAll();
 
  }
  
  public function getLastDuplication($limit = 5){
   // permet de recuperer les listes les plus dupliques
    // $limit : permet de recuperer un nombre definis de liste (par defaut 5)
    // retourne un tableau de listes
    $profil = new Model_DbTable_Profil();
    $message = new Model_DbTable_Message();
    $chat = new Model_DbTable_Chat();
    $db = Zend_Db_Table::getDefaultAdapter();
    $model = new Model_DbTable_Model();   
    $current_model  = $model->getModel($this->Model_id);
    return $db->query($db->select()->from($current_model->table_name)->where("categorie_idcategories != ?",$profil->Category_id)->Where("categorie_idcategories != ?",$message->Category_id)->where("categorie_idcategories != ?",$chat->Category_id)->order("nb_duplication DESC")->limit($limit))->fetchAll();
 
  }
  
  public function getLastView($limit = 5){
   // permet de recuperer les listes les plus vues
    // $limit : permet de recuperer un nombre definis de liste (par defaut 5)
    // retourne un tableau de listes
    
    $profil = new Model_DbTable_Profil();
    $message = new Model_DbTable_Message();
    $chat = new Model_DbTable_Chat();
    $db = Zend_Db_Table::getDefaultAdapter();
    $model = new Model_DbTable_Model();   
    $current_model  = $model->getModel($this->Model_id);
    return $db->query($db->select()->from($current_model->table_name)->where("categorie_idcategories != ?",$profil->Category_id)->Where("categorie_idcategories != ?",$message->Category_id)->where("categorie_idcategories != ?",$chat->Category_id)->order("nb_view DESC")->limit($limit))->fetchAll();

  }  
  
  public function getTypes($current_list,$recup_id = null){
    // Permet de recuperer le type d'une liste
    // $current_list : permet de savoir dans quelle liste on est
    // $recup_id : bool
    // retourne soit le type de la liste, soit dynamique
    $type_name = "";
    $current_items = $current_list->findDependentRowset('Model_DbTable_Item');
    foreach($current_items as $item){
      $ins_type = new Model_DbTable_Type();
      $model = new Model_DbTable_Model();
      $type = $ins_type->getType($item->type_idtype);
      $current_model  = $model->getModel($type->model_id);
      if($type_name == ""){
        $type_name = $current_model->table_name;
      }else{
        if($type_name != $current_model->table_name){
          $type_name = "dynamique";
        }
      }
    }
    if($recup_id == null)
    return $type_name;
    else
    {
     if($type_name=="dynamique")
       return 0;
     else
      return $type->model_id;
    }
  }
  
  
  public function getCountItem($idList) {
   // Recupere le nombre d'item d'une liste
   // $idList:  id de la liste concerne
   // return un tableau d'item
   $db = Zend_Db_Table::getDefaultAdapter();
   return  $db->query($db->select()->from("item")->where("list_idList = ?",$idList))->fetchAll();
  
  }
  
 
  public function getListSortable($current_user,$criteria = 0) {
    // Fonction qui permet de trier une liste
    // $current_user : utilisateur courant
    // $criteria : permet de trier la liste
    // return un tableau d'item
    $inst_profil = new Model_DbTable_Profil();
    $inst_message = new Model_DbTable_Message();
    $inst_chat = new Model_DbTable_Chat();
    $db = Zend_Db_Table::getDefaultAdapter();
    $item = new Model_DbTable_Item();

    $query =  $db->select()
                ->from("list")
                ->join("item","item.list_idList = list.idList",array("COUNT(item.idItem) as nbItem"))
                ->join("user_has_list","user_has_list.list_idList = list.idList",array())
                ->join("categorie","list.categorie_idCategories = categorie.idCategories",array("categorie.title_fr as cfr","categorie.title_en as cen"))
               ->joinLeft(array("sc"=>"categorie"),"sc.categorie_idCategories =  categorie.idCategories",array("sc.title_fr as scfr","sc.title_en as scen"))
                ->where("user_has_list.user_idUser = ?",$current_user)
                ->where("list.categorie_idcategories != ?",$inst_profil->Category_id)
                ->where("list.categorie_idcategories != ?",$inst_message->Category_id)
                ->where("list.categorie_idcategories != ?",$inst_chat->Category_id)
                ->where("list.status = ?",1)
                ->group("list.idList");
                
    switch($criteria)
    {
     // les plus vues
     case 1:

       $query->order("list.nb_view DESC");
     break;
     
     // les plus populaires
     case 2:
      $query->order("list.nb_duplication DESC");
     break;

     //par categorie
     case 4:
     $query->order("categorie.title_fr");
     break;
  
     // par date
     case 5:
      $query->order("list.idList DESC");
     break;
     
     default:
        $query->order("list.title");
     break;
    
    }
    
    $select = $db->query($query)->fetchAll();

     
    return $select;
  
  }
  
  public static function orderByPosition($a,$b){
    // Fonction de comparaison pour le trie dune liste
    // Retourne un boolean
    if(!(isset($a["position"]) && isset($b["position"])) || ($b["position"] == 0 && $a["position"] == 0) ){
      if ($a["position"] == $b["position"]) {
          return 0;
      }
      return ($a["position"] > $b["position"]) ? 1 : -1;
    }
    else{
      return ($a["item_idItem"] > $b["item_idItem"]) ? 1 : -1;
    }
  }
  
  
  public function getInfoList($idList) {
    //Permet de recuperer les informations d'une liste
    //$idList : id de la liste
    // Retourne un tableau des information de la liste
    
    $inst_profil = new Model_DbTable_Profil();
    $db = Zend_Db_Table::getDefaultAdapter();
    $item = new Model_DbTable_Item();

    $query = $db->select()
                ->from("list")
                ->join("item","item.list_idList = list.idList",array("COUNT(item.idItem) as nbItem"))
                ->join("user_has_list","user_has_list.list_idList = list.idList",array())
                ->join("categorie","list.categorie_idCategories = categorie.idCategories",array("categorie.title_fr as cfr","categorie.title_en as cen"))
               ->joinLeft(array("sc"=>"categorie"),"sc.categorie_idCategories =  categorie.idCategories",array("sc.title_fr as scfr","sc.title_en as scen"))
                ->where("list.user_idUser = ?",$idList);

    
    $select = $db->query()->fetchRow($query);

     
    return $select;
    
  }
  
  
  public function getModelItem($idItem) {
    // Permet de recuperer le model d'item
    // $idItem : permet de recuperer le model d'un item
    // Retourne un tableau de model
      
    $db = Zend_Db_Table::getDefaultAdapter();
    $item = new Model_DbTable_Item();  
    
    $query = $db->select()->from("item")
                ->join(array("t"=>"type"),"item.type_idtype = t.idtype")
                ->join(array("m"=>"model"),"m.idModel = t.model_id",array("m.table_name"))
                ->where('item.idItem = ?',$idItem);
                
      return $db->query($query)->fetchAll();
  }
  
  
  public function getListsSearch($search){
    // Permet de recuperer toutes les listes en fonction de la recherche
    // $search : Ce qui est recherche
    // Retourne un tableau de listes
    $lists_search = array();
    $db = Zend_Db_Table::getDefaultAdapter();
    $model = new Model_DbTable_Model();
    $inst_user = new Model_DbTable_User();
    $current_model  = $model->getModel($this->Model_id);
    $lists = $db->query($db->select()->from($current_model->table_name))->fetchAll();
    krsort($lists);
    foreach($lists as $list){
      $id_list = $list["idList"];
      $current_list = $this->find($list["idList"])->current();
      $list_user = $current_list->findModel_DbTable_UserViaModel_DbTable_UserHasListByListAndUser()->current();    
      $infos_sender = $inst_user->getName($list_user->idUser);
      $lists_search[$id_list]["id"] = $list_user->idUser;
      $lists_search[$id_list]["login"] = $list_user->login;
      $lists_search[$id_list]["name"] = $list_user->login." (".strtoupper($infos_sender["name"])." ".ucfirst($infos_sender["firstname"]).")";
      $lists_search[$id_list]["photo"] = $infos_sender["photo"];   
    }
    foreach($lists_search as $k => $v){
      $current_list = $this->find($k)->current();
      $type_list = $this->getTypes($current_list); 
      if($v['id'] == 1 || $type_list == "notification_p" || $type_list == "friend" || $type_list == "structure_p" || $type_list == "profil" || $type_list=="private_message" ||  $type_list==""){
        unset($lists_search[$k]);
        continue;
      }
      if($search!="" || $search=="*"){
        if(strpos($current_list->title, $search) === false && strpos($current_list->description, $search) === false && strpos($current_list->tag, $search) === false ){
          $items = $this->getItemsNoModel($current_list);
          $bool = false;
          foreach($items as $item){
            foreach($item as $key=>$v){
              if(strpos(strtolower($v), strtolower($search))!==false){
                $bool = true;
              }
            }
          }
          if(!$bool){
            unset($lists_search[$k]);
          }
        }
      }
    }
    return $lists_search;
  }

}
