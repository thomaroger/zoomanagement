<?php

class Form_resendPassword extends Zend_Form
{

	
	public function __construct($options = null)
	{
		parent::__construct($options);
    
    // Login
    $email = new Zend_Form_Element_Text("email_password", array('class' => 'text'));
    $email->setLabel('Email *:')
          ->addFilter('StripTags')
          ->addFilter('StringTrim')
          ->setRequired(true)
          ->addValidator('NotEmpty')
          ->addValidator('EmailAddress');
          
    $captcha_conf  = Zend_Registry::get('Captcha_config');  
    $pubKey = $captcha_conf['pubKey'];
    $privKey = $captcha_conf['privKey']; 
    $recaptcha = new Zend_Service_ReCaptcha($pubKey, $privKey);
    $adapter = new Zend_Captcha_ReCaptcha();
    $adapter->setService($recaptcha);
    $captcha = new Zend_Form_Element_Captcha('recaptcha', array( 'label' => "Captcha *:", 'captcha' => $adapter));
    $captcha->removeDecorator('label')->removeDecorator('errors');      
    
    //$this->addElements(array($email));
    $this->addElements(array($email,$captcha));
    
    $this->setDecorators( array( array('ViewScript', array('viewScript' => 'user/newDesign_resendPassword.phtml'))));        
	}
}