<?php

class ListController extends Zend_Controller_Action
{
  
    protected $current_user;
    
    public function init()
    {
      $user = new Model_DbTable_User();
      if($this->current_user = $user->getUser())
      {
        $this->view->current_user = $this->current_user;
  	  }
    }

    public function indexAction()
    {
    
    }
    
    
    //affichage de la première étape de création de liste
    public function createAction()
    {
       if(!$this->current_user)
         $this->_redirect("/");
         
       $this->view->headTitle('TOOTLIST : Ajout d\'une liste');
      $model = new Model_DbTable_Model();
      $cat   = new Model_DbTable_Categorie();

        $this->view->listModel = $model->all();
        $arrayCat      = $cat->SupCategorie();
        $this->view->cat = $arrayCat;
    }
    
    
    //deuxième étape de la création de la liste
    //cette étape permet d'ajouter des items à la liste 
    //utiliser aussi lors de la validation de la création d'item
    public function additemAction()
    {
    
      if(!$this->current_user)
        $this->_redirect("/");
        
      $this->view->headScript()->appendFile('/javascript/mooRainbow.js');
      $this->view->headScript()->appendFile('/javascript/calendar.js');
      $this->view->headLink()->appendStylesheet('/style/mooRainbow.css');
      $this->view->headLink()->appendStylesheet('/style/calendar.css');
     
      
      $this->view->headTitle('TOOTLIST : Ajout d\'objet à la liste');
      $model = new Model_DbTable_Model();
      $cat   = new Model_DbTable_Categorie();
      $list  = new Model_DbTable_List();
      
      $this->view->lang      = $this->current_user->language;
      
      //si on valide la création d'une liste
      if($this->_request->isPost() && $this->_request->getPost("name"))
      {
        $data = array();
        $nameCategorieSelected = "";
        
        $data["name"]        = $this->_request->getPost("name");
        $data["description"] =$this->_request->getPost("description");
        $data["model"]       = $this->_request->getPost("model");
        $data["categorie_idcategories"]   = $this->_request->getPost("categorie");
        if($this->_request->getPost("subCategorie") !="")
        {
           $data["categorie_idcategories"]= $this->_request->getPost("subCategorie");           
        }

        $data["tag"]        = $this->_request->getPost("tags");
      
        //mettre une trace !!!!!
        $dataList["title"]                  = $data["name"];
        $dataList["description"]            = $data["description"];
        $dataList["tag"]                    = $data["tag"]; 
        $dataList["categorie_idcategories"] = $data["categorie_idcategories"];
       

        $this->view->idList = $list->addList($dataList,$this->current_user);
        
        if($data["model"] != 0)
        {
          $dataModel = $model->getModel($data["model"]);
        
           if($this->current_user->language == "fr")
            $this->view->type = $dataModel["libelle_fr"];
          else
            $this->view->type = $dataModel["libelle_en"];
 
         if($dataModel["table_name"] !="pkmn_user")
        {
          $form = new Form_dynamicForm(null,$dataModel["table_name"],null);
          $this->view->form = $form;
        }
         elseif($dataModel["table_name"]=="pkmn_user")
        {
         $this->view->beginPkmn = rand(1,151);
        }
        

        $this->view->idModel = $data["model"];
        }
        else
        {
          $this->view->idModel = 0;
          $this->view->listModel = $model->allDynamic();
        
        }
        
        
        

      }
      elseif($this->_request->getPost('nbItem'))
      {
       
        $nbItem = $this->_request->getPost('nbItem');
        $idModel  = $this->_request->getPost('idModel');
        $idList = $this->_request->getPost('idList');
        $record = $this->_request->getPost('record');
        
        $dataModel = $model->getModel($idModel);
        $lblTable= "Model_DbTable_".ucfirst($dataModel["table_name"]);
        $item = new Model_DbTable_Item();
      
        $table   = new $lblTable();
        
        $describe= $table->info();
        
        $dataLabel = array();
        $dataType  = array();
        
       foreach($describe["metadata"] as $key=>$field)
        {

            if(( $field["DATA_TYPE"] == "varchar" ||  $field["DATA_TYPE"]=="int" || $field["DATA_TYPE"]=="text") && $field['COLUMN_NAME']!='item_idItem')
            {
                $dataLabel[] = $field["COLUMN_NAME"]; 
                $dataType[]  = $field["DATA_TYPE"];          
            }
            elseif(($field["DATA_TYPE"] == "date" || $field["DATA_TYPE"] == "datetime") && $field['COLUMN_NAME']!='item_idItem')
            {
            
                $dataLabel[] = $field["COLUMN_NAME"]; 
                $dataType[]  = $field["DATA_TYPE"];  
            
            }
            
        }
        

    
          $cptInput = 0;
          //$model => item  : dataItem
          //$model2=> model genre picture   data
          //$list_id  idList
          //model_id idModel
          //$model  table
          //$current_user
          $dataItem = array();
          foreach($record as $input)
          {
          
      
            if($dataType[$cptInput]=="date" || $dataType[$cptInput]=="datetime" )
            {
                $datetmp = explode("/",$input);
                $input   = $datetmp[2]."-".$datetmp[1]."-".$datetmp[0];
               
            }
            
             
             
            $data[$dataLabel[$cptInput]] = $input;  
            $cptInput++;
          
            if($cptInput >= (count($record)/$nbItem))
            {
         
              $dataItem["position"] = $cptInput;
              $cptInput =0;

              $item->addItem($dataItem,$data,$idList,$idModel,$table,$this->current_user);
            }
             
             
          
          }
       
       if($this->_request->getPost('updateListeItem'))
        $this->_redirect("/list/updatelist/id/".$idList);
      else
          $this->_redirect('/');
        
      }

      
    }
    
    //action appeler pour créer des items d'une liste dynamique
    public function additemdynamicAction()
    {
      $model = new Model_DbTable_Model();
      $cat   = new Model_DbTable_Categorie();
      $list  = new Model_DbTable_List();
      $item = new Model_DbTable_Item();
      
      
      $nbItem = $this->_request->getPost('nbItem');
      $idList = $this->_request->getPost('idList');
      $record = $this->_request->getPost('record');
      
      
      
      $cptObject =0;
      foreach($record as $key=>$object)
      {
        $infoTable = array();
        $flag      = false;
        $dataLabel = array();
        $dataType  = array();
        $dataObject= array();
        $cptLine   = 0;
        foreach($object as $key=>$line)
        {
           if($flag ==false)
           {
            
             $dataModel = $model->getModel($line);
             $lblTable  = "Model_DbTable_".ucfirst($dataModel["table_name"]); 
              $table    = new $lblTable();
        
              $describe= $table->info(); 
              $cptMetadata = 0;
              //foreach pour r�cup le nom des champs de la base
            foreach($describe["metadata"] as $key=>$field)
            {

              if(( $field["DATA_TYPE"] == "varchar" ||  $field["DATA_TYPE"]=="int" || $field["DATA_TYPE"]=="text") && $field['COLUMN_NAME']!='item_idItem')
              {
                $dataLabel[$cptMetadata] = $field["COLUMN_NAME"]; 
                $dataType[$cptMetadata]  = $field["DATA_TYPE"]; 
                $cptMetadata++;          
              }
              elseif(($field["DATA_TYPE"] == "date" || $field["DATA_TYPE"] == "datetime")&& $field['COLUMN_NAME']!='item_idItem')
              {
         
                $dataLabel[$cptMetadata] = $field["COLUMN_NAME"]; 
                $dataType[$cptMetadata]  = $field["DATA_TYPE"]; 
                $cptMetadata++;
            
              }
              
            
            }//fin foreach champs de la table

           
           
           }//fin if select
           else
           {
                
                    
            if($dataType[$cptLine]=="date" || $dataType[$cptLine]=="datetime" )
            {
                $datetmp = explode("/",$line);
                $line   = $datetmp[2]."-".$datetmp[1]."-".$datetmp[0];
               
            }
            
              $dataObject[$dataLabel[$cptLine]] = $line;  
              $cptLine++;
            }
           $flag = true;
        }//fin foreach line
        $data["position"] = $cptObject;

       $item->addItem($data,$dataObject,$idList,$dataModel["idModel"],$table,$this->current_user);
        $cptObject++;
      }//fin foreach object
      

      $this->_redirect("/");

    }
    
    //fonction pour liste les listes de l'utilisateur
    public function mylistAction()
    {
      if(!$this->current_user)
        $this->_redirect("/");
        
      $this->view->headTitle('TOOTLIST : Accueil');
      $list = new Model_DbTable_List();
      $this->view->lang = $this->current_user->language;
      $this->view->myLists = $list->getListSortable($this->current_user->idUser);
      $this->view->inst_user = new Model_DbTable_User();
      if($this->_request->getPost('permission')!='')
      {
        $idList = $this->_request->getPost('idList');
        
      
       $data = array('permission'=>$this->_request->getPost('permission'));
       
       $where = $list->getAdapter()->quoteInto('idList = ?', $idList);
       $list->update($data,$where);  
        
      
      }
      
    }
    
    /*
    * permet d'afficher les champs d'un item selon le type sélectionner
    * pour lajout d'item lors de la création de liste dynamique
    * Aussi utiliser pour l'ajout d'item pour la modification d'une liste
    */
    public function ajaxitemdynamicAction()
    {


      $this->_helper->layout->disableLayout(); 
      $model = new Model_DbTable_Model();
 
      $idModel = $this->_request->getPost('model');

     
      $dataModel = $model->getModel($idModel);           

      $form = new Form_dynamicForm(null,$dataModel["table_name"],null);
      $this->view->form2 = $form;
      
      
      if($this->_request->getPost('id')!="")
        $this->view->id    = $this->_request->getPost('id');
      
      if( $this->_request->getPost("nbItem"))
      {
        $this->view->nbItem  = $this->_request->getPost("nbItem");
        $this->view->label   = $this->_request->getPost("label");     
      }
      

        
    }


    //récupère info d'un pokémon
    public function ajaxinfopokemonAction()
    {
      $src = $this->_request->getPost('img');
      $this->_helper->layout->disableLayout(); 
      
      $tmp = explode("/",$src);
        
      $id = $tmp[count($tmp)-1];
      
      $modelPokemon = new Model_DbTable_PokemonAll();
      $this->view->language = $this->current_user->language;
      $this->view->pokemon = $modelPokemon->find($id);
      
    }
    
    
    //fonction ajax permettant d'afficher le select de sous catégorie
    public function ajaxsubcateogriesAction()
    {
      $categorie = new Model_DbTable_Categorie();
      $this->_helper->layout->disableLayout();                     
      $idCat = $this->_request->getPost("id");
      $this->view->lang = $this->current_user->language;
      if($idCat !="")
       $this->view->subCat = $categorie->SubCategorie($idCat); 
    }
    
    public function menuAction(){
      $this->_helper->layout()->setLayout('layout.inclusion');
      $list = new Model_DbTable_List();
      $this->view->recentList = $list->getLastRecent(5);
      $this->view->duplicationList = $list->getLastDuplication(5);
      $this->view->viewList = $list->getLastView(5);
    }
    
    public function savehomeAction(){
       $this->_helper->layout->disableLayout(); 
       $arrayList = $this->_request->getPost("tab");
       if($this->current_user){
         setcookie("homePage",serialize($arrayList), false, "/", false);
         $user = new Model_DbTable_User();
         if($itemStructure = $user->getStructureHome()){
            $ins_struct = new Model_DbTable_StructureP();
            $mstruct = $ins_struct->getStructure($itemStructure[0]['item_idItem']);
            $mstruct->value = serialize($arrayList); 
            $mstruct->save();
         }else{
           $profil = new Model_DbTable_Profil();
           $datalist = array();
           $datalist['categorie_idcategories'] =$profil->Model_id; 
           $datalist['title'] = "StructureDeProfil";
           $list = new Model_DbTable_List();
           $listid = $list->addList($datalist,$this->current_user);
           $structureP = new Model_DbTable_StructureP();
           $dataProfil = array();
           $dataItem = array();
           $dataItem['position'] = 0; 
           $dataProfil['name'] ='home'; 
           $dataProfil['value'] = serialize($arrayList); 
           $item = new Model_DbTable_Item();
           $item->addItem($dataItem,$dataProfil,$listid,$structureP->Model_id,$structureP,$this->current_user);
         }
       }else{
         setcookie("homePage",serialize($arrayList), false, "/", false);
       }
    }
  
  //fonction ajax pour lister les listes pour "mes listes"
  public function ajaxlisttrieAction()
  {
    $criteria = $this->_request->getPost("criteria");
    $list = new Model_DbTable_List();
    $user = new Model_DbTable_User();
    $this->_helper->layout->disableLayout(); 
            
    $this->view->lang = $this->current_user->language;
    
    $mylist = $list->getListSortable($this->current_user->idUser,$criteria);
    if($criteria == 3)
    {
       usort($mylist, array($this, 'cmpNbItem'));
    }
      
    $this->view->myLists = $mylist;
     
  }
  
  private function cmpNbItem($a, $b)
  {
    if ($a["nbItem"] == $b["nbItem"]) {
        return 0;
    }
    return ($a["nbItem"] > $b["nbItem"]) ? -1 : 1;
  }
  
  
  public function addhomeAction(){
    $this->_helper->layout->disableLayout(); 
    $this->_helper->viewRenderer->setNoRender();
    $user = new Model_DbTable_User();
    $user->addHome($this->_request->getPost("idList"));
  }
  
  //fonction qui supprime une liste
  public function dellistAction(){
    $this->_helper->layout->disableLayout(); 
    $this->_helper->viewRenderer->setNoRender();
    
    $idList = $this->_request->getPost("idList");

    $list = new Model_DbTable_List();
    $data = array('status'=>0);
    $where = $list->getAdapter()->quoteInto('idList = ?', $idList);
    $list->update($data,$where);  
    
     //$this->current_user->quota_list = $this->current_user->quota_list + 1;
     //$this->current_user->save();
  }
  
  public function addlistAction(){
     if(!$this->current_user)
        $this->_redirect("/");
        
    $this->_helper->layout->disableLayout(); 
    $this->_helper->viewRenderer->setNoRender();
    
    $idList = $this->_request->getPost("idList");

    $list = new Model_DbTable_List();
    $data = array('status'=>1);
    $where = $list->getAdapter()->quoteInto('idList = ?', $idList);
    $list->update($data,$where);  
    
     //$this->current_user->quota_list = $this->current_user->quota_list - 1;
     //$this->current_user->save();
  }
  
  
  //fonction affichant la page de modification d'une liste
  public function updatelistAction()
  {
    if(!$this->current_user)
        $this->_redirect("/");
        
    $list   = new Model_DbTable_List();
    
    $this->view->headScript()->appendFile('/javascript/mooRainbow.js');
    $this->view->headScript()->appendFile('/javascript/calendar.js');
    $this->view->headLink()->appendStylesheet('/style/mooRainbow.css');
    $this->view->headLink()->appendStylesheet('/style/calendar.css');
      
    
    if($this->_request->getPost('idList'))
      $this->view->idListDetail = $this->_request->getPost("idList");
    elseif($this->_request->getParam('id'))
      $this->view->idListDetail = $this->_request->getParam('id');
  
    //update de la list uniquement
    if($this->_request->getPost('formList')==1)
    {
      $data["title"]       = $this->_request->getPost("title");
      $data["description"] = $this->_request->getPost("description");
      $data["tag"]         = $this->_request->getPost("tags");
      
      if( $this->_request->getPost("subCateorie")=="")
        $data["categorie_idcategories"]       = $this->_request->getPost("categorie");
      else
        $data["categorie_idcategories"]       = $this->_request->getPost("subCategorie");
   

      $where = array("idList = ?" =>$this->_request->getPost("idList"));
 
      $list->update($data,$where);      
    
    }
    
    $myList = $list->find($this->view->idListDetail)->current();
    $this->view->idModelList = $list->getTypes($myList,1);
    
  }
  
  //detail d'une liste (sans le détail des items) pour la modification d'une liste
  public function ajaxdetaillistAction()
  {
    
    $this->_helper->layout->disableLayout(); 
    $list   = new Model_DbTable_List();
    $categ  = new Model_DbTable_Categorie();
    $model  = new Model_DbTable_Model();
    
    
    $idList = $this->_request->getPost("idList");
    if($idList =="")
     $this->_redirect("/list/mylist");
     

    $this->view->lang       = $this->current_user->language;
    
    $this->view->infoList   = $list->find($idList)->current();

    $cat  = $categ->getCategorie($this->view->infoList->categorie_idcategories);
    $this->view->cat = $cat[0];
    

  }
  
  
  //afficher les items d'une liste pour la modification d'une liste
  public function ajaxitemlistAction()
  {
  
    $this->_helper->layout->disableLayout(); 
  
    $list   = new Model_DbTable_List();
    $model  = new Model_DbTable_Model();
    $allModel = $model->all();
    $this->view->allModel = $allModel;
    //suppression d'un item
    if($this->_request->getPost('del')==1)
    {
      
       $infoItem = $list->getModelItem($this->_request->getPost('idItem'));
       
       $newModel = "Model_DbTable_".ucfirst(strtolower(str_replace("_","",$infoItem[0]["table_name"])));
      
       $instance = new $newModel();
       
       $itemModel = new Model_DbTable_Item();
       $typeItem  = new Model_DbTable_Type();
     
       if($newModel == "Model_DbTable_Event")
       {
         $recall = new Model_DbTable_Recall();
         
         $recall->deleteRecall($this->_request->getPost('idItem'));
        
       
       }
       
      $instance->find($this->_request->getPost('idItem'))->current()->delete();

       
        $itemModel->find($this->_request->getPost('idItem'))->current()->delete();

            
       $typeItem->find($infoItem[0]["idtype"])->current()->delete();

    
    
    }

    $this->view->idListDetail = $this->_request->getPost("idList");
    
    
    $myList   = $list->find($this->view->idListDetail)->current();
    
    
  
    
    $this->view->itemList = $list->getItemsNoModel($myList); 
    
  }
  
  //formulaire de modfi d'une liste (uniquement)
  public function ajaxformupdatelistAction()
  {
    $this->_helper->layout->disableLayout(); 
    
    $list   = new Model_DbTable_List();
    $categ  = new Model_DbTable_Categorie();
    $model  = new Model_DbTable_Model();
    
    
    $idList = $this->_request->getPost("idList");

     
    $this->view->lang       = $this->current_user->language;
    
    $this->view->infoList   = $list->find($idList)->current();
    
    $this->view->typeList               = $list->getTypes($this->view->infoList);

    $cat  = $categ->getCategorie($this->view->infoList->categorie_idcategories);
    $this->view->cat = $cat[0];


    $this->view->listModel = $model->all();
    
    $arrayCat              = $categ->SupCategorie();
    $this->view->cat2      = $arrayCat;

   if($cat[0]["categorie_idcategories"]!="")
   {
    $arrayCat              = $categ->SubCategorie($cat[0]["categorie_idcategories"]);
    $this->view->cat3      = $arrayCat;
   }
    $items = $list->getCountItem($idList);  
  
  
  
  }
  
  // fonction pour pouvoir changer les permissions
  public function permissionAction()
  {
    $this->_helper->layout->disableLayout();    
    $idList = $this->_request->getParam('id');
    
    $list = new Model_DbTable_List();
    
    $this->view->listPerm = $list->find($idList)->current();
    $this->view->idList = $idList;  
  }
  
  
  //fonction pour la vue d'une liste
  public function viewAction()
  {
    if(!$this->current_user){
      $this->_redirect('/');
    }
    
    $idList = $this->_request->getParam('id');
    $list   = new Model_DbTable_List();
    $inst_user = new Model_DbTable_User();
    $this->view->infoList = $list->find($idList)->current();
    $list_user =  $this->view->infoList->findModel_DbTable_UserViaModel_DbTable_UserHasListByListAndUser()->current();
    $this->view->user_list = $inst_user->find($list_user['idUser'])->current();    
    $this->view->modelList= $list->getTypes($this->view->infoList);
    $this->view->listItem = $list->getItemsNoModel($this->view->infoList);     
  }
  
  
  //action pour dupliquer une liste
  public function ajaxduplicateAction()
  {
    $this->_helper->layout->disableLayout();
    $this->_helper->viewRenderer->setNoRender(); 
    
    $id = $this->_request->getPost("idList");
    
    $list = new Model_DbTable_List();
    $modelItem = new Model_DbTable_Item();
    $model= new Model_DbTable_Model();
    
    $basicList     = $list->find($id)->current();
    $basicList->nb_duplication = $basicList->nb_duplication +1;
    $basicList->save();
    $nbDuplication = $basicList->nb_duplication + 1;
    
    $dataList["title"]                  = $basicList->title."- duplication";
    $dataList["description"]            = $basicList->description;
    $dataList["tag"]                    = $basicList->tag; 
    $dataList["categorie_idcategories"] = $basicList->categorie_idcategories;
    $dataList["nb_duplication"]         = 0;
    $dataList["list_idList"]            = $id;
    
  
    $idList = $list->addList($dataList,$this->current_user);
    
     $basicListItem = $list->getItemsNoModel($basicList);
    $cpt = 0;
    foreach($basicListItem as $object)
    {
       $dataObject = array();
     
      $itemModel = $model->getModelItem($object["item_idItem"]);
      $lblTable     = "Model_DbTable_".ucfirst(strtolower($itemModel[0]["table_name"]));
      $table     = new $lblTable();
      $idModel   = $itemModel[0]["idModel"];
      
      $dataItem["position"] = $cpt;
      $dataItem["list_idList"] = $id;
      foreach($object as $key=>$item)
      {
        
        if($key !="item_idItem" && $key!="position")
          $dataObject[$key] = $item;

      }
      $cpt++;


      $modelItem->addItem($dataItem,$dataObject,$idList,$idModel,$table,$this->current_user);
     
    }
    

  
  }
  
  
  //fonction pour éditer un item
  public function ajaxupdateitemAction()
  {
    $this->_helper->layout->disableLayout();
    
    $model  = new Model_DbTable_Model();
    $idItem = $this->_request->getPost("idItem");
          
    if($idItem!="")
    {
      $myitem = $model->getModelItem($idItem);

      $form = new Form_dynamicForm(null,$myitem[0]["table_name"],null);
      $this->view->form2 = $form;
      $this->view->idItem = $idItem;
      $this->view->idList = $this->_request->getPost("idList");
    }
    else
    {
      $this->_helper->viewRenderer->setNoRender();      
      $postModel = $this->_request->getPost("model");
      
      $myitem = $model->getModelItem($postModel[0]);
       
      $lblTable= "Model_DbTable_".ucfirst($myitem[0]["table_name"]);
      
      $item = new Model_DbTable_Item();
      
      $table   = new $lblTable();
        
      $describe= $table->info();
      
      foreach($describe["cols"] as $key=>$col)
      {
        if($col !="item_idItem")
         $data[$col] = $postModel[$key];
        else
         $where =$col." = ?";
      }
      
      
      $table->update($data,array($where=>$postModel[0]));
      
      $idList = $this->_request->getPost("idList");
      
      $this->_redirect("/list/updatelist/id/".$idList);
      
    }
  
  }
  
  public function exportrssAction(){
    //Permet un export RSS d'une liste 
    
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
    $inst_list = new Model_DbTable_List();
    $inst_item = new Model_DbTable_Item();
    
    $current_list = $inst_list->find($this->getRequest()->getParam('id'))->current();
    $meta = new Model_DbTable_Metadata();
    $updated_at= new Zend_Date($meta->getMeta($inst_list->Model_id,$current_list->idList)->updated_at);
      
    $feedArray = array(
          'title' => $current_list->title,
          'link' => '/list/view/id/'.$current_list->title,
          'charset' => 'utf-8', 
          'description' => $current_list->description, 
          'author' =>  $this->current_user->login,
          'email' =>  $this->current_user->email,
          'copyright' => 'Tootlist Copyright',
          'generator' => 'Tootlist Zend Framework Feed',
          'language' => $this->current_user->language,
          'lastBuildDate'=>$updated_at->get(Zend_Date::RSS)
      );
      

      
      foreach($inst_list->getItemsNoModel($current_list) as $item){
        $current_item = $inst_item->find($item['item_idItem'])->current();
        $type_item = $inst_item->getType($current_item);
        if( $type_item == "city"){
         $title = ($item['city']);
         $description = ($item["woeid"]);
        }elseif($type_item  == "directory"){
          $title = ($item['lastname']." ".$item['firstname']);
          $description = $item['lastname']." ".$item['firstname']." ".$item['address']." ".$item['postal_code']." ".$item['city']; 
        }else{
          $title =  ($item['title']); 
          $description = strip_tags($item['description']); 
        }
        
        
        $feedArray['entries'][] = array(
                'title' => $title, 
                'link' => '/list/view/id/'.$current_list->idList,
                'description' => $description,
                'content' => $description,
                'pubdate' => $updated_at->get(Zend_Date::RSS)
            );
      }
      $feed = Zend_Feed::importArray($feedArray,'rss');
      $feed->send(); 
  }
  
  public function exportxmlAction(){
    // Permet d'exporter une liste en xml 
        
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
    $inst_list = new Model_DbTable_List();
    $inst_item = new Model_DbTable_Item();
    
    $current_list = $inst_list->find($this->getRequest()->getParam('id'))->current();
    $meta = new Model_DbTable_Metadata();
    $updated_at= new Zend_Date($meta->getMeta($inst_list->Model_id,$current_list->idList)->updated_at);
    
    $inst_category = new Model_DbTable_Categorie();
    $current_category = $inst_category->find($current_list->categorie_idcategories)->current();
        
    $xml = "";  
    $xml .='<?xml version="1.0" encoding="UTF-8" ?>\n';
    $xml .='<root>\n';
    $xml .= '<liste>\n';
    $xml .= '<nombre_duplication>'.$current_list->nb_duplication.'</nombre_duplication>';
    $xml .= '<nombre_vues>'.$current_list->nb_view.'</nombre_vues>';
    $xml .= '<titre>'.$current_list->title.'</titre>';
    $xml .= '<description>'.$current_list->description.'</description>';
    $xml .= '<tag>'.$current_list->tag.'</tag>';    
    $xml .= '<categorie>'.$current_category->title_fr.'</categorie>';
    $xml .= '<permission>'.Model_DbTable_List::$type[$current_list->permission].'</permission>';
    $xml .= '<date>'.$updated_at->get(Zend_Date::DATE_FULL).', '.$updated_at->get(Zend_Date::TIME_SHORT).'</date>';
    $xml .='</liste>';
      
    foreach($inst_list->getItemsNoModel($current_list) as $item){
      $current_item = $inst_item->find($item['item_idItem'])->current();
      $type_item = $inst_item->getType($current_item);
      $xml .="<".$type_item.">";
        foreach($item as $k=>$v){
          $xml .="<".$k.">".$v."</".$k.">";
        }
      $xml .="</".$type_item.">";
    }
    $xml .='</root>';
    $date = gmdate('D, d M Y H:i:s');
 
    header("Content-Type: text/xml"); //Ici par exemple c'est pour un fichier XML, a changer en fonction du type mime du fichier voulu.
    header('Content-Disposition: attachment; filename='.$current_list->title.'.xml');
    header('Last-Modified: '. $date . ' GMT');
    header('Expires: ' . $date);
    //header specifique IE :s parce que sinon il aime pas
    if(preg_match('/msie|(microsoft internet explorer)/i', $_SERVER['HTTP_USER_AGENT'])){
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
    }else{
      header('Pragma: no-cache');
    }

    echo ($xml);
  }

  
  public function ajaxchoicepokemonAction()
  {
  
   $this->_helper->layout->disableLayout();
   $this->_helper->viewRenderer->setNoRender(true);
   $idList = $this->_request->getPost('idList');
   $idModel= $this->_request->getPost('idModel');
   $data["pokemon_idPokemon"] = $this->_request->getPost("idPokemon");
   if($this->_request->getPost('first')!=0)
   $data["first"] = 1;
   else
    $data["first"] = 0;
   
   $model = new Model_DbTable_PkmnUser();
   $item  = new Model_DbTable_Item();
   
   $dataItem["position"] = 1;
   $item->addItem($dataItem,$data,$idList,$idModel,$model,$this->current_user);
   
 
  }
  
  

}

?>