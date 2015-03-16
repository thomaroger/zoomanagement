<?php

class Model_DbTable_Notification extends Zend_Db_Table_Abstract
{

  protected $_name    = 'notification_p';
  protected $_primary = 'item_idItem';
  public $Model_id    = 20;
  


  public function addNotification($data,$user){
    //Permet d'ajout une notification pour un utilisateur
    // $data permet de personnalise la notification (Table notification)
    // $current_user correspond à l'utilisateur qui recevra la notification
    // retourne l'id de la notification
    $inst_user = new Model_DbTable_User();
    $listNotification = $inst_user->getListNotification($user->idUser);
    $item = new Model_DbTable_Item();
    $idNotification = $item->addItem(array('position'=>0),$data,$listNotification->idList,$this->Model_id,$this,$user);
    return $idNotification;
  }

}
