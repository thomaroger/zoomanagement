<?php

class Form_signin extends Zend_Form
{

	
	public function __construct($options = null,$in_backoffice = null)
	{
		parent::__construct($options);
    
    // Login
    $email = new Zend_Form_Element_Text("email_log", array('class' => 'text'));
    $email->setLabel('Email :')
          ->addFilter('StripTags')
          ->addFilter('StringTrim')
          ->setRequired(true)
          ->addValidator('NotEmpty')
          ->addValidator('EmailAddress');
          		          
    // Password
    $password = new Zend_Form_Element_Password("password_log", array('class' => 'passwordShark text'));
    $password->setLabel('Password :')
             ->addFilter('StringTrim')
             ->setRequired(true)
             ->addValidator('NotEmpty');

    
    $this->addElements(array($email,$password));
    if($in_backoffice == 1)
     $this->setDecorators( array( array('ViewScript', array('viewScript' => 'index/newDesign_Register.phtml')))); 
    else
       $this->setDecorators( array( array('ViewScript', array('viewScript' => 'user/newDesign_Register.phtml')))); 
           
	}
}