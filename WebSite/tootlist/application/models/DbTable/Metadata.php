<?php

class Model_DbTable_Metadata extends Zend_Db_Table_Abstract{

  protected $_name = 'metadata';
  protected $_primary = 'idMetadata';
  public $Model_id = 4;
  
  
  public function addMeta($model_id, $record_id, $created_at = null, $updated_at = null){
    // permet d'ajouter des metadonn�es
    // $model_id : correspond a l'id du model
    // $record_id : correspond � l'id de l'enregistrement du model
    // $created_at (date actuelle par defaut) : permet de donner une date de create
    // $updated_at (date actuelle par defaut) : permet de donner une date d'update
    if($created_at == null)
      $created_at = date('Y-m-d H:i:s');
    if($updated_at == null)
      $updated_at = date('Y-m-d H:i:s');
      
    $record = array('model_id' => $model_id,
                    'record_id' => $record_id,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at);
    $this->insert($record);                     
  }

  public function updateMeta($model_id, $record_id){
    // Permet de mettre a jour les metadonn�es d'un enregistrement d'un model defini
    // $model_id : correspond a l'id du model
    // $record_id : correspond � l'id de l'enregistrement du model
    $where = array('model_id = ?' => (int) $model_id, 'record_id = ?' => (int) $record_id);
    $this->update(array('updated_at' => date('Y-m-d H:i:s')), $where);
  }
  
  public function getMeta($model_id,$record_id){
    // Permet de recuperer les metadonn�es d'un enregistrement d'un model defini
    // $model_id : correspond a l'id du model
    // $record_id : correspond � l'id de l'enregistrement du model
    // retourne l'instance de la metadonnees
    return $this->fetchRow($this->select()->where('model_id = ?',(int)$model_id)->where('record_id = ?',(int) $record_id));
  }
  
} 