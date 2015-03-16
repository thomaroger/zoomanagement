<?php

class Form_updateList extends Zend_Form
{

	
	public function __construct($options = null,$data = null,$type = null)
	{
		parent::__construct($options);
    
    if($type =="list")
    {
      
      // title
      $title = new Zend_Form_Element_Text("title",array('class' => 'text'));
		  $title->setLabel('Login *:')
		        ->addFilter('StripTags')
		        ->addFilter('StringTrim')
		        ->setValue($data["title"]);
		      
		  // description
      $description = new Zend_Form_Element_Textarea("description", array('class' => 'text_wysiwyg'));
      $description->setLabel('Description :')
            ->setValue($data["description"]);      
    
      // tag
      $tag = new Zend_Form_Element_Text("tag", array('class' => 'text'));
      $tag->setLabel('Tag :')
               ->addFilter('StringTrim')
               ->setValue($data["tag"]);

      $cat = new Zend_Form_Element_Select("categorie",array(''))
      //$this->addElements(array($login,$email,$password));
      $this->addElements(array($title,$description,$tag));
    }
	}
}