<?php

class Model_DbTable_Weather extends Zend_Db_Table_Abstract
{

  protected $_name    = 'city';
  protected $_primary = 'item_idItem';
  public $Model_id    = 25;
  
  public $Category_id = 11;
  
}
