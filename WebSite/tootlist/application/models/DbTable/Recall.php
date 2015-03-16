<?php

class Model_DbTable_Recall extends Zend_Db_Table_Abstract
{

  protected $_name    = 'recall';
  protected $_primary = 'item_idItem';
  public $Model_id    = 14;
  
  
  const MAIL = 1;
  const NOTIFICATION = 2;
  
  const YEAR = 1;
  const MONTH =2;
  const DAY =3;
  const HOUR =4;
  const MINUTE =5;
  
  const ENCOURS = 0;
  const ENVOYE = 1;
  
  
  public static $type = array(self::MAIL => "Mail",
                              self::NOTIFICATION => "Notification");
                              
  
  public static $scale = array(self::YEAR => "Ann&eacute;e(s)",
                               self::MONTH=> "Mois",
                               self::DAY => "Jour(s)",
                               self::HOUR => "Heure(s)",
                               self::MINUTE => "Minute(s)");    
                                                            
  public static $scaleEn = array(self::YEAR => "year",
                               self::MONTH=> "month",
                               self::DAY => "day",
                               self::HOUR => "hour",
                               self::MINUTE => "minute");    
                                                            
                               
  
  public function getRecalls($current_list, $event_id){
    // Permet de recuperer les items recall d'une liste en fonction de l'event
    // $current_list : correpond a la liste
    // $event_id : correspond au l'id de l'event
    // Retourne les differents items de la liste
    $model = new Model_DbTable_Model();   
    $items = array(); 
    $current_model  = $model->getModel($this->Model_id);
    $current_items = $current_list->findDependentRowset('Model_DbTable_Item');
    foreach($current_items as $item){
      $db = Zend_Db_Table::getDefaultAdapter();
      $item_model = $db->query($db->select()->from($current_model->table_name)->where(" item_idItem = ?",$item->idItem)->where(" Event_idEvent = ?",$event_id))->fetchAll();
      $items[] = $item_model[0];
    }
    usort($items,"Model_DbTable_List::orderByPosition");
    return $items;
  }   
  
  
  public function deleteRecall($idEvent) {
    // Permet de supprimer tous les rappels d'un evenements
    // $idEvent : id de l'event concerne
    $itemModel = new Model_DbTable_Item();
    $type = new Model_DbTable_Type();

    
    $select = $this->select()->where('Event_idEvent',$idEvent);
    
    $query  = $select->query()->fetchAll();
    
    foreach($query as $recall)
    {
         $item     = $itemModel->find($recall["item_idItem"])->current();
         $idType   = $item->type_idtype;
         $idRecall = $item->idItem;

        $this->find($idRecall)->current()->delete();
        $item->delete();
        $type->find($idType)->current()->delete();
       
        
    }  
  }                                                  
}
