<?php

class Model_DbTable_User extends Zend_Db_Table_Abstract
{

  protected $_name = 'user';
  protected $_primary = 'idUser';
  
  public $Model_id = 2;
  
  public $Category_id = 7;
  
  
  const membre = 0;
  const moderateur = 1;
  const administrateur =2;
  
  const Nactive = 0;
  const Active = 1;
      
  public static $privilege = array(0=>'membre',
                                   1=>'moderateur',
                                   2=>'administrateur');
  
  

  public function addUser($data){		
    // Permet d'ajout un user
    // $data : Tableau qui contient les valeurs que l'on veut mettre dans la table user
    // Return un tableau avec le model_id, l'id de l'utilisateur, et son token 
    $session = Zend_Registry::get('session');
	  if($session->lang ==""){
	   $session->lang = 'fr';
	  }
	  $lang = $session->lang;
	  $configuration = new Model_DbTable_Configuration();
    $row = $configuration->getConfiguration($lang);
    $quota_list = 0;
    if($row){
      $quota_list = $row->quota_list_user;
    } 
      
		$record = array('email'=>$data['email'],
		                'ip'=>$_SERVER['REMOTE_ADDR'],
		                'login'=>$data['login'],
		                'password'=>md5($data['password']),
		                'language' => $lang,
		                'status'=>self::Nactive,
		                'quota_list' => $quota_list,
		                'privilege'=>self::$privilege[self::membre],
		                'token'=> md5($data['email'].$_SERVER['REMOTE_ADDR'].$data['password']));
		$iduser = $this->insert($record);
    
    $list = new Model_DbTable_List();
    $profil = new Model_DbTable_Profil();
    $arrayList = array("title"=>"NotificationProfil","categorie_idcategories"=>$profil->Category_id);
    $list->addList($arrayList,$this->find($iduser)->current());
    $arrayList = array("title"=>"FriendProfil","categorie_idcategories"=>$profil->Category_id);
    $list->addList($arrayList,$this->find($iduser)->current());
    $arrayList = array("title"=>"RecallProfil","categorie_idcategories"=>$profil->Category_id);
    $list->addList($arrayList,$this->find($iduser)->current());
		return array('model_id' => $this->Model_id,'record_id' => $iduser,'token' => $record['token']);
	}
	
	public function validateUserByToken($token) {
	  // Permet de valider un utilisateur (pour se connecter) ˆ partir du token
	  // $token : jeton qui permet de s'activer
	  $where = array('token = ?' => $token);
	  $this->update(array('status' => self::Active), $where);
	  $rows = $this->fetchAll($this->select()->where('token = ?', $token));
    if(count($rows) == 1) {
      foreach($rows as $row){
        self::updateMeta($row->idUser,"Validation du compte de ".$row->email,Zend_Log::INFO);
	      $row->token="";
	      $row->save();
      }
    }
  }

  public function userSignin($data){
    // Permet ˆ un utilisateur de se connecter
    // $data : Tableau qui contient les informations pour se connecter
    // Return un tableau avec le statut de l'identification  
    $db = Zend_Db_Table::getDefaultAdapter();
    $authAdapter = new Zend_Auth_Adapter_DbTable($db);
    $authAdapter->setTableName('user')
                ->setIdentityColumn('email')
                ->setCredentialColumn('password');
                
    $select = $authAdapter->getDbSelect();
    $select->where('status = '.self::Active);       
    
    $authAdapter->setIdentity($data['email_log'])->setCredential(md5($data['password_log']));
    
    if($authAdapter->authenticate()->isValid()){
      self::updateMeta($authAdapter->getResultRowObject()->idUser,"Connexion du compte de ".$authAdapter->authenticate()->getIdentity(),Zend_Log::INFO);
    }
    return array('bool'=>$authAdapter->authenticate(),'result'=>$authAdapter->getResultRowObject());                                   
  }	
  
  public function updateMeta($record_id, $msg, $priority){
    // Permet de mettre a jour la metadonnŽe d'un utilisateur et de crŽe un log associŽ ˆ cet utilisateur
    // $record_id : correpond a l'id de l'utilisateur
    // $msg : correspond au message (decription) du log
    // $priority : correspond au niveau de log
    $metadata = new Model_DbTable_Metadata();
	  $metadata->updateMeta($this->Model_id,$record_id);
	  $log = new Model_DbTable_Log();
	  $array_log = $log->addLog($this->Model_id, $record_id,$msg,$priority);
	  $metadata->addMeta($array_log['model_id'], $array_log['record_id'], null, null);
  }
  
  public function getUser(){
    // Permet de savoir si un utilisateur est connectŽ
    // Return l'objet de l'utilisateur
    $authNamespace = new Zend_Session_Namespace('Zend_Auth'); 
    if (!isset($authNamespace->user)){
      return false;
    }
    return $this->find(unserialize($authNamespace->user)->idUser)->current();
  }
  
  public function regenPassword($length = 8){
    // Permet de regenerer une chaine de caractere
    // $longeur (par defaut 8) : permet de definir la longeur de la chaine gŽnŽrŽe
    // Return la chaine gŽnŽrŽe
    $seed = 'aqwzsxedcrfvtgbyhnujikolpm'.'1029384756';
    $ret  = '';
    for ($i = 1; $i <= $length; $i++) {
      $ret .= $seed[mt_rand(0, strlen($seed) - 1)];
    }
    return $ret;
  }
  
  public function getProfile($id = null){
    // Permet de recuperer le profil d'un utilisateur
    // Return soit le profil soit false
    if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $profil = new Model_DbTable_Profil();
    $select = $this->select()->where('title = ?','Profil')->where('categorie_idcategories = ?',$profil->Category_id)->order('idList DESC')->limit(1);
    if($profil_list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)->current()){
      $list = new Model_DbTable_List();
      return $list->getItems($profil_list,$profil->Model_id);
    }else{
      return false;
    }
  }
  
  public function getListNotification($id = null){
    // Permet de recuperer la liste des notifications d'un utilisateur
    // Return soit la liste soit false
    if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $profil = new Model_DbTable_Profil();
    $select = $this->select()->where('title = ?','NotificationProfil')->where('categorie_idcategories = ?',$profil->Category_id)->order('idList DESC')->limit(1);
    if($profil_list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)->current()){
      return $profil_list;
    }else{
      return false;
    }
  }
  
  public function getListFriend($id = null){
    // Permet de recuperer la liste des friends d'un utilisateur
    // Return soit la liste soit false
    if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $profil = new Model_DbTable_Profil();
    $select = $this->select()->where('title = ?','FriendProfil')->where('categorie_idcategories = ?',$profil->Category_id)->order('idList DESC')->limit(1);
    if($profil_list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)->current()){
      return $profil_list;
    }else{
      return false;
    }
  }
  
  public function hasFriend($id_user,$id_user_current = null){
    // Permet de savoir si un utilisateur est ami avec l'utilisateur courant
    // $id_user est l'utilisateur quelconque
    // Return 1 si c'est un ami, 0 si c'est pas un ami, -1 si il y a une demande en cours  
    $return = -2;
    $list_friends = self::getListFriend($id_user_current);
    $inst_friend = new Model_DbTable_Friend(); 
    $list = new Model_DbTable_List();
    $items_list = $list->getItems($list_friends,$inst_friend->Model_id);
    foreach($items_list as $item_list){
      $current_item_friend = $inst_friend->find($item_list["item_idItem"])->current();
      if($current_item_friend->id_user == $id_user){
        $return = $current_item_friend->status;
      }
    }
    $inst_friend = new Model_DbTable_Friend();
    if($return == $inst_friend->Nactive){
      return -1;
    }
    
    if($return == $inst_friend->Active){
      return 1;
    }
    
    return 0;    
  }
  
  public function getAdminLists($id){
     // Permet de recuperer les lists
     // $id : id de l'utilisateur
     // Return les listes
    $profil = new Model_DbTable_Profil();
    $chat = new Model_DbTable_Chat();
    $message = new Model_DbTable_Message();
    $select = $this->select()->where('categorie_idcategories != ?',$profil->Category_id)->where('categorie_idcategories != ?',$message->Category_id)->where('categorie_idcategories != ?',$chat->Category_id)->limit(9);
    $admin =  $this->find($id)->current();
    return $admin->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select);
  }
  

  
  public function getStructureHome(){
    // Permet de recuperer les items qui correspondent au structure du profil
    // return les items des structures du profil
    $current_user = self::getUser();
    $profil = new Model_DbTable_Profil();
    $structureP = new Model_DbTable_StructureP();
    $select = $this->select()->where('title = ?','StructureDeProfil')->where('categorie_idcategories = ?',$profil->Category_id)->order('idList DESC')->limit(1);
    if($profil_list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)->current()){
      $list = new Model_DbTable_List();
      $structureP = new Model_DbTable_StructureP();
      return $list->getItems($profil_list,$structureP->Model_id);
    }else{
      return false;
    }
  }
  
  public function getSkins(){
    // Permet de recuperer les items qui correspondent au skin du profil
    // return les items des skins du profil
    $current_user = self::getUser();
    $profil = new Model_DbTable_Profil();
    $structureP = new Model_DbTable_StructureP();
    $select = $this->select()->where('title = ?','SkinsDeProfil')->where('categorie_idcategories = ?',$profil->Category_id)->order('idList DESC')->limit(1);
    if($profil_list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)->current()){
      $list = new Model_DbTable_List();
      $structureP = new Model_DbTable_StructureP();
      return $list->getItems($profil_list,$structureP->Model_id);
    }else{
      return false;
    }
  }
  
  public function getListRecall($id = 0){
    if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $profil = new Model_DbTable_Profil();
    $select = $this->select()->where('title = ?','RecallProfil')->where('categorie_idcategories = ?',$profil->Category_id)->order('idList DESC')->limit(1);
    if($profil_list = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)->current()){
      return $profil_list;
    }else{
      return false;
    }
  }
  
  public function isHome($idlist){
    // Permet de savoir si une liste est sur la home page de l'utilisateur
    // Return true si oui, sinon false
    $itemStructure = self::getStructureHome();
    $ins_struct = new Model_DbTable_StructureP();          
    $mstruct = $ins_struct->getStructure($itemStructure[0]['item_idItem']);

    if(isset($mstruct->value)){
      foreach(unserialize($mstruct->value) as $listes){ 
        foreach ($listes as $list){
          if(str_replace("list_","",$list) == $idlist){
            return true;
          }
        }
      }
    }
    return false;
  }
  
  public function addHome($idList){
    // Permet de rajouter une liste sur la HomePage
    // $idList correspond a l'id de la liste
    $itemStructure = self::getStructureHome();
    $ins_struct = new Model_DbTable_StructureP();          
    $mstruct = $ins_struct->getStructure($itemStructure[0]['item_idItem']);
    if($mstruct->value){
      $listes =unserialize($mstruct->value);
      $listes[0][] = "list_".$idList;
      $mstruct->value = serialize($listes);
      $mstruct->save();
    }
  }
  
  public function getFriends($id = null){
    // Permet de recuperer les amis d'un personnes
    // l'Id correspond a l'id de l'utilisateur courant
    // retourne un tableau avec les l'id des amis en index et l'objet en valeur
    $items = array();
    if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $list_friend = self::getListFriend($current_user->idUser);
    $inst_friend = new Model_DbTable_Friend();
    $inst_list = new Model_DbTable_List();
    $items[] = $inst_list->getItems($list_friend,$inst_friend->Model_id);
    $friends = array();
    foreach($items[0] as $item){
      if($this->hasFriend($item["id_user"],$current_user->idUser) == 1)
        $friends[$item["id_user"]] = $this->find($item["id_user"])->current();
    }
    return $friends;
  }
  
  public function getName($id = 0){
    // Permet de recuperer les informations concernant un utilisateur
    // l'id correspond a l'id de l'utilisateur courant
    // retourne un tableau avec les informations (photos, nom, prenom) de l'utilisateur
     if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $profiles_associed = $this->getProfile($current_user->idUser);
    $name="";
    $firstname="";
    $photo="";          
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
    return array("photo"=>$photo, "name"=>$name,"firstname"=>$firstname);
  }
 
  public function getOnlineFriend($id=null){
    // Permet de recuperer les amis connecte au site
    // l'id correspond a l'id de l'utilisateur courant
    // retourne un tableau avec les l'id des amis en index et l'objet en valeur
    $items = array();
    $list_friend = self::getListFriend($id);
    $inst_friend = new Model_DbTable_Friend();
    $inst_list = new Model_DbTable_List();
    $items[] = $inst_list->getItems($list_friend,$inst_friend->Model_id);
    $friends = array();
    foreach($items[0] as $item){
      if($this->hasFriend($item["id_user"]) == 1){
         $tmp_friend =$this->find($item["id_user"])->current();
         if($tmp_friend->online == 1){
          $friends[$item["id_user"]]=$item["id_user"];
         }
      }
    }
    return $friends;
  }
  
  public function getLists($id=null){
    // Recuperer toutes les listes d'un utilisateurs
    // $id : id de l'utilisateur (par defaut null : utilisateur courant )
    // Retourne un tableau de listes
    if($id > 0){
      $current_user = $this->find($id)->current();
    }else{
      $current_user = self::getUser();
    }
    $profil = new Model_DbTable_Profil();
    $message = new Model_DbTable_Message();
    $chat = new Model_DbTable_Chat();
    $list = new Model_DbTable_List();

    $select = $this->select()->where("categorie_idcategories != ?",$profil->Category_id)->where("categorie_idcategories != ?",$message->Category_id)->where("categorie_idcategories != ?",$chat->Category_id)->order('idList ASC');
    
    if($lists = $current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select)){
      return $lists;
    }else{
      return false;
    }
  }
}
  
