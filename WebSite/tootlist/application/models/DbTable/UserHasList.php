<?php

class Model_DbTable_UserHasList extends Zend_Db_Table_Abstract
{

  protected $_name = 'user_has_list';
  protected $_primary = array('user_idUser','list_idList');
  
  protected $_referenceMap = array(
    'User' => array(
      'columns'           => array('user_idUser'),
      'refTableClass'     => 'Model_DbTable_User',
      'refColumns'        => array('idUser')
    ),
    'List' => array(
      'columns'           => array('list_idList'),
      'refTableClass'     => 'Model_DbTable_List',
      'refColumns'        => array('idList')
    )
  ); 
  
  
  public function add($idList,$idUser) {
    // Permet de faire la liaison entre une liste et un utilisateur
    // $idList : correspond ˆ l'id de la liste
    // $idUser : correspond ˆ l'id de l'utilisateur
    $data = array('user_idUser' => $idUser,
                  'list_idList' => $idList);
    $this->insert($data);
  
  } 
}
