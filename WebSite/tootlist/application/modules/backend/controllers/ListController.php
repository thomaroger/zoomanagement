<?php

class Backend_ListController extends Zend_Controller_Action {
	
	public $inst_list;
	public $inst_category;
	public $inst_model;
	
	    public function init()
    {
        /* Initialize action controller here */
      $this->_helper->layout()->setLayout('layout.backoffice');
      $this->inst_list = new Model_DbTable_List();
      $this->inst_category = new Model_DbTable_Categorie(); 
      $this->inst_model = new Model_DbTable_Model();     
      $user = new Model_DbTable_User();
      if($this->current_user = $user->getUser())
      {
        $this->view->current_user = $this->current_user;
  	  }
    }

    public function indexAction()
    {
        // action body
    }
    
    public function createtypeAction()
    {
    
    
      $model = new Model_DbTable_Model();
      $type = new Model_DbTable_Type();

      
      
      $this->view->nbModel = count($model->fetchAll());
      
      if($this->_request->getPost('numberModel'))
      {
        
        $data["isbase"]      = 0;
        $data["islist"]      = 1;
        $data["libelle_fr"]  = $this->_request->getPost('nameType');
        $data["libelle_en"]  = $this->_request->getPost('nameTypeEn');
        $data["model_id"]    =  $this->_request->getPost('numberModel');
        $data["table_name"]  =  $this->formatage($data["libelle_en"]);
        
        

        $table  = strtolower($data["table_name"]);
        
        //insertion dans la table model
        $model->insert($data);
        
        
        //script pour créer la table
       $scriptCreate = "CREATE TABLE IF NOT EXISTS `".$table."` (
                        `item_idItem` int(11) NOT NULL,";

      $fields = $this->_request->getPost('field');
      $select = $this->_request->getPost('select');
      
      foreach($fields as $key=>$field)
      {
         

         $scriptCreate .= "`".$this->formatage($field)."` ".$select[$key]."  NULL,";
      
      }
 
       $scriptCreate.="PRIMARY KEY (`item_idItem`),
                       KEY `fk_".$table."_item1` (`item_idItem`)
                       ) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci COMMENT='Gestion ".$table."';";
      
      
 
      $type->createType($scriptCreate);
      ////////////////////////////////////
      
      //création du fichier model
      $fp=fopen("../application/models/DbTable/".ucfirst(strtolower($table)).".php","a");

      fwrite($fp,"<?php  
      class Model_DbTable_".ucfirst(strtolower($table))." extends Zend_Db_Table_Abstract
      {

        protected \$_name    = '".$table."';
        protected \$_primary = 'item_idItem';
        public \$Model_id    = ".$data["model_id"] .";
  
    }
    ?>");
      ////////////////////////////////

      }
      
      
    }
    
    
    
    public function viewAction(){
      $this->_helper->layout->disableLayout(); 
      $db = Zend_Db_Table::getDefaultAdapter();
      $lists = $db->query($db->select()->from("list")->order("idList DESC"))->fetchAll();
      $this->view->lists = $lists;
      $this->view->model = $model;
    }
    
    public function detailAction(){
      $this->_helper->layout->disableLayout(); 
      $this->view->current_list = $this->inst_list->find($this->getRequest()->getParam('idList'))->current();
      $this->view->items = $this->inst_list->getItemsNoModel($this->view->current_list);
      $this->view->inst_category = $this->inst_category;
      $this->view->inst_list = $this->inst_list;
    }
    
    
    private function formatage($string) {
      $str = htmlentities( $string, ENT_NOQUOTES, 'utf-8');
      
      $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
      $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
      $str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
      
      $str = str_replace("'","",$str);
      $str = str_replace("@","",$str);
      $str = str_replace('"','',$str);
      $str = str_replace(" ","_",$str);      	
  	  return $str;
    }
    
    public function typeAction()
    {
      $this->_helper->layout->disableLayout(); 
      
      $this->view->model = $this->inst_model->fetchAll();
    
    
    }
    
    

    
}
?>