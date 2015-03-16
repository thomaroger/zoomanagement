<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function run()
    {
        Zend_Registry::set('config', new Zend_Config($this->getOptions()));
        parent::run();
    }
    
    protected function _initAutoload()
    {
        $loader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));
        return $loader;
    }
    
    protected function _initSession()
    {
      $session = new Zend_Session_Namespace('tootlist', true);
      Zend_Registry::set('session', $session);
		  return $session;
    }
    
    protected function _initView()
    {
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        return $view;
    }
   
    protected function _initTranslate() {
		  $session = Zend_Registry::get('session');
		  $locale = new Zend_Locale('fr');
		  Zend_Registry::set('Zend_Locale', $locale);
		  $langLocale = isset($session->lang) ? $session->lang : $locale;
		  $translate = new Zend_Translate('array',APPLICATION_PATH.'/languages/fr_FR.php','fr');
		  $translate->addTranslation(APPLICATION_PATH.'/languages/en_US.php','en');
		  $translate->setLocale($langLocale);
		  Zend_Registry::set('Zend_Translate', $translate);
	  }
	  
  protected function _initMails(){
	  $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'mail');
	  $mailConfig = $config->toArray();
	  Zend_Registry::set('Mail_Config', $mailConfig['mail']);
  }
  
  protected function _initCaptcha(){
	  $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'captcha');
	  $captchaConfig = $config->toArray();
	  Zend_Registry::set('Captcha_config', $captchaConfig['captcha']);
  }
  
  protected function _initRoutes() {
	$routeur = Zend_Controller_Front::getInstance()->getRouter();
	$routeur->addRoute('viewUser',
	                  new Zend_Controller_Router_Route('view/:username',
                    array('module' => 'frontend',
                          'controller' => 'user',
                          'action' => 'info')));
                          
  $routeur->addRoute('signup',
                    new Zend_Controller_Router_Route_Static('signup', 
                    array('module' => 'frontend',
		                      'controller' => 'user',
		                      'action' =>'new')));
	return $routeur;
  }  
}

