<?php

class Form_register extends Zend_Form
{

	
	public function __construct($options = null)
	{
		parent::__construct($options);
    
    // Login
    $login = new Zend_Form_Element_Text("login",array('class' => 'text'));
		$loginDoesntExist = new Zend_Validate_Db_NoRecordExists('user', 'login');
		$login->setLabel('Login *:')
		      ->addFilter('StripTags')
		      ->addFilter('StringTrim')
		      ->setRequired(true)
		      ->addValidator('NotEmpty')
		      ->addValidator($loginDoesntExist)
		      ->addValidator('StringLength', false, 3, 20)
		      ->setDescription("Login between 3 and 20 alphanumerics characters.");
		      
		// Email
		$emailDoesntExist = new Zend_Validate_Db_NoRecordExists('user', 'email');
    $email = new Zend_Form_Element_Text("email", array('class' => 'text'));
    $email->setLabel('Email address *:')
          ->addFilter('StripTags')
          ->addFilter('StringTrim')
          ->setRequired(true)
          ->addValidator('NotEmpty')
          ->addValidator($emailDoesntExist)
          ->addValidator('EmailAddress')
          ->setDescription("Require a valid email address.");      
    
    // Password
    $password = new Zend_Form_Element_Password("password", array('class' => 'passwordShark text'));
    $password->setLabel('Password *:')
             ->addFilter('StringTrim')
             ->setRequired(true)
             ->addValidator('NotEmpty');

    //Captcha
    $captcha_conf  = Zend_Registry::get('Captcha_config');  
    $pubKey = $captcha_conf['pubKey'];
    $privKey = $captcha_conf['privKey']; 
    $recaptcha = new Zend_Service_ReCaptcha($pubKey, $privKey);
    $adapter = new Zend_Captcha_ReCaptcha();
    $adapter->setService($recaptcha);
    $captcha = new Zend_Form_Element_Captcha('recaptcha', array( 'label' => "Captcha *:", 'captcha' => $adapter));
    $captcha->removeDecorator('label')->removeDecorator('errors');
    
    //$this->addElements(array($login,$email,$password));
    $this->addElements(array($login,$email,$password,$captcha));
    
    $this->setDecorators( array( array('ViewScript', array('viewScript' => 'user/newDesign.phtml'))));        
	}
}