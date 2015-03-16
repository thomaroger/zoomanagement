<?php

class Model_DbTable_Log extends Zend_Db_Table_Abstract{

  protected $_name = 'log';
  protected $_primary = 'idLog';
  public $Model_id = 3;
  
  
 public static $titre = array( 0 => 'EMERGENCY',
                               1 => 'ALERT',
                               2 => 'CRITICAL',
                               3 => 'ERROR',
                               4 => 'WARNING',
                               5 => 'NOTICE',
                               6 => 'INFORMATION',
                               7 => 'DEBUG');
  
  
  public function addLog($model_id, $record_id, $description, $title){
    // Permet d'ajout des logs
    // $model_id : correspond a l'id du model
    // $record_id : correspond ˆ l'id de l'enregistrement du model
    // $description : correspond ˆ une description du log
    // $title : int qui permet de donner une prŽcision sur le type de log
    // Retourne un tableau avec le model id de log et l'id du log crŽŽ
    $record = array('model_id' => $model_id,
                    'record_id' => $record_id,
                    'description' => $description,
                    'title' => self::$titre[$title]);
                    
    $idlog = $this->insert($record);
    return array('model_id' => $this->Model_id,'record_id' => $idlog);                
  }


} 