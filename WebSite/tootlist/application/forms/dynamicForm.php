<?php

class Form_dynamicForm extends Zend_Form
{

	
	public function __construct($options = null,$model, $record=null, $profile = false)
	{
	  $errors ="";
		parent::__construct($options);
    if($model instanceof Model_DbTable_Configuration) {
        
      $dom = new DOMDocument('1.0', 'iso-8859-1');
      
      if (!$dom->loadXML(utf8_encode($record->profile))) {
        $errors  = "Impossible to load the XML";
      }
      
      $forms  = $dom->getElementsByTagName('form');
      if($forms->length !=1){
        $errors  = "Pas d'arborescence pour le type Form";
      }
      
      $elem = $dom->documentElement;
      $compteur = 0;
      $curent_profile = array();
      
      
      if($profile!=false){ 
        foreach($profile as $k => $profil){
          $curent_profile[$profil["property"]] =utf8_encode($profil["value"]);
        }          
      }
          
      $elements_form = array();
      
      if(count($curent_profile) > 0){
        //var_dump($profile[0]["item_idItem"]);
        $item = new Model_DbTable_Item();
        $current_item  = $item->find($profile[0]["item_idItem"])->current();
        $list = $current_item->findParentRow("Model_DbTable_List");
        $elements_form[$compteur] = new Zend_Form_Element_Hidden('idList',array('class' => 'text', 'value'=>$list->idList));   
        $elements_form[$compteur]->setLabel('id');  
        $compteur ++;
      }
      
      foreach ($elem->childNodes as $node){
        $values=array();
        $name="";
        $type ="";
        $required = false;
        $description = "";
        if($node->nodeName =="elem"){
          if($node->hasAttribute ('name')){
            $name =  $node->getAttribute('name'); 
            $name_tuple = $name;
           
            if(!(array_key_exists($name,$curent_profile)) && $curent_profile[$name] !=""){
              $curent_profile[$name] = "";
            }
          }
          if($node->hasAttribute('type')){
            $type = $node->getAttribute('type');
          }
          
          if($node->hasAttribute('value')){
            $values_tmp = $node->getAttribute('value');
            $values_array = explode (',',$values_tmp);
            foreach($values_array as $value_array){
              $values[$value_array] = $value_array;
            }
          }
          
          if($node->hasAttribute('required')){
            $required = true;
            $name .=" *";
          }
          
          if($node->hasAttribute('description')){
            $description = $node->getAttribute('description');
          }
        }
        
        if($type=="Text"){
          $elements_form[$compteur] = new Zend_Form_Element_Text($name,array('class' => 'text', 'value'=>$curent_profile[$name_tuple]));
          $elements_form[$compteur]->addFilter('StripTags')
                                   ->addFilter('StringTrim');
          $elements_form[$compteur]->setLabel($name.' :');
        }else if($type=="Select"){
          $elements_form[$compteur] = new Zend_Form_Element_Select($name, array('multiOptions'=>$values, 'value'=>$curent_profile[$name_tuple]));
          $elements_form[$compteur]->setLabel($name.' :');
        }else if($type=="Date"){
          $elements_form[$compteur] = new Zend_Form_Element_Text($name,array('class' => 'text calendar', 'value'=>$curent_profile[$name_tuple]));
          $elements_form[$compteur]->setLabel($name.' :');     
        }else if($type=="Checkbox"){
          $elements_form[$compteur] = new Zend_Form_Element_MultiCheckbox($name,array('multiOptions'=> $values,'class'=>'checkbox'));
          $elements_form[$compteur]->setLabel($name.' :');       
        }else if($type=="Wysiwyg"){
          $elements_form[$compteur] = new Zend_Form_Element_Textarea($name,array('class' => 'text_wysiwyg', 'value'=>$curent_profile[$name_tuple]));
          $elements_form[$compteur]->setLabel($name.' :'); 
        }else if($type=="Countries"){
          $lang = 'fr_FR';
          $session = Zend_Registry::get('session');
          if($session->lang == "en"){
            $lang = 'en_US';
          }
          $locale = new Zend_Locale($lang);
          $countries = ($locale->getTranslationList('Territory', 'fr', 2));
          asort($countries, SORT_LOCALE_STRING);
          $elements_form[$compteur] = new Zend_Form_Element_Select('country_member',array('value'=>$curent_profile[$name_tuple]));
          $elements_form[$compteur]->setLabel('Country')
                                   ->addMultiOptions($countries)
                                   ->addValidator('NotEmpty');
        }
      
        if($required){
          $elements_form[$compteur]->setRequired(true);
        }                      
  		  if($description !=""){
  		    $elements_form[$compteur]->setDescription($description);
  		  }
  		      
  
        $compteur ++;
      }
      
      $elements_form[$compteur] = new Zend_Form_Element_Hidden("form_dynamique");
      $elements_form[$compteur]->setLabel("")
                               ->setValue('1');
      
            
      if($errors !=""){
        echo $errors;
      }else{
        $this->addElements($elements_form);
      }
      
      $this->setDecorators( array( array('ViewScript', array('viewScript' => 'user/newDesign_FormDyn.phtml'))));   
    }else{
        $array = explode("_",$model);
        $compteur = 0;
        $nameModel="";
        foreach($array as $value)
        {
          $nameModel .= ucfirst(strtolower($value));
         }
      
    
        $instance = "Model_DbTable_".$nameModel;
    
        $model    = new $instance();
        $describe = $model->info();
       
        foreach($describe["metadata"] as $key=>$field)
        {
      

            if(( $field["DATA_TYPE"] == "varchar" ||  $field["DATA_TYPE"]=="int") && $field['COLUMN_NAME']!='item_idItem')
            {
            
                $elements_form[$compteur] = new Zend_Form_Element_Text( $field['COLUMN_NAME'],array('class' => 'text'));
                $elements_form[$compteur]->addFilter('StripTags')
                                         ->addFilter('StringTrim');
                $elements_form[$compteur]->setLabel($field['COLUMN_NAME'].' :');
                $compteur++;
            
            }
            elseif(($field["DATA_TYPE"] == "date" || $field["DATA_TYPE"] == "datetime")&& $field['COLUMN_NAME']!='item_idItem')
            {
         
              $elements_form[$compteur] = new Zend_Form_Element_Text($field['COLUMN_NAME'],array('class' => 'text calendar', 'value'=>date('d/m/Y')));
              $elements_form[$compteur]->setLabel($field['COLUMN_NAME'].' :');
               $compteur++;
            
            }
            
            elseif($field["DATA_TYPE"] == "text" && $field['COLUMN_NAME']!='item_idItem')
            {
               $elements_form[$compteur] = new Zend_Form_Element_Textarea($field['COLUMN_NAME'],array('class' => 'text_wysiwyg', 'value'=>""));
               $elements_form[$compteur]->setLabel($field['COLUMN_NAME'].' :');

               $compteur++;
            
            }          
            
        }
  
         $this->addElements($elements_form);
        
      }  
  }
}