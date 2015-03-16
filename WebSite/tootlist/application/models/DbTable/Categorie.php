<?php

class Model_DbTable_Categorie extends Zend_Db_Table_Abstract
{

  protected $_name = 'categorie';
  protected $_primary = 'idcategories';
  public $Model_id = 5;
  
  
  protected $_referenceMap = array(
    'SubCategory' => array(
      'columns'           => array('categorie_idcategories'),
      'refTableClass'     => 'Model_DbTable_Categorie',
      'refColumns'        => array('idcategories')
    ));


  public function  SupCategorie(){
    // Recuperation de toutes les categories parentes
    // Retourne un tableau de categories		
    $user = new Model_DbTable_User();
		$select = $this->select()->where('categorie_idcategories IS NULL')->where('idcategories != ?',$user->Category_id);
		return $select->query()->fetchAll();
	}
	
	public function SubCategorie($idCategorie){
	  // Recuperation de toutes les sous categories 
	  // $idCategorie : id de la categorie parente 
	  // Retourne toutes les sous categories
	  if($idCategorie > 0){
	    $user = new Model_DbTable_User();
	    $select = $this->select()->where('categorie_idcategories != ?',$user->Category_id);
	    $category_mere = $this->find($idCategorie)->current();
	    return $category_mere->findModel_DbTable_CategorieBySubCategory($select);
	  }
	 }
  
  public function getCategorie($idCat) {
   // Recuperation d'une categorie
   // $idCat  : id de la categorie qu'on veut recuperer
   // retourne la categorie
      $select =  $this->select()
            ->from("categorie")
            ->joinLeft(array('c'=>'categorie'),'c.categorie_idcategories = categorie.idcategories',array('c.title_fr as subfr','c.title_en as suben'))
           ->where('categorie.idcategories =?',$idCat);

        return $select->query()->fetchAll();
    }
	
}
