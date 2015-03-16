<?php

class WeatherController extends Zend_Controller_Action {
  
  public $inst_user;
  public $inst_weather;
  public $inst_list;
  public $inst_item;
  public $inst_profile;
  public $current_user;
  
  
  public function init() {
    $this->inst_user = new Model_DbTable_User();
    $this->inst_weather = new Model_DbTable_Weather();
    $this->inst_list = new Model_DbTable_List();
    $this->inst_item = new Model_DbTable_Item();
    $this->inst_profile = new Model_DbTable_Profil();
    
    if($this->current_user = $this->inst_user->getUser()) {
      $this->view->current_user = $this->current_user;
    }else{
      $this->_redirect('/');
    }
  }
  
  public function indexAction(){
  
  }
  
  // Permet d'ajouter une ville pour la meteo
  public function addAction(){
    $lang = 'fr_FR';
    $session = Zend_Registry::get('session');
    if($session->lang == "en"){
      $lang = 'en_US';
    }
    $locale = new Zend_Locale($lang);
    $countries = ($locale->getTranslationList('Territory', 'fr', 2));
    asort($countries, SORT_LOCALE_STRING);
    $this->view->countries = $countries;
  }
  
  // Permet de recuperer toutes les villes d'une liste meteo
  public function listAction(){
    $countries = array();
    $select = $this->inst_list->select()->where('categorie_idcategories = ?',$this->inst_weather->Category_id)->where('title = ?', 'meteo');
    $list = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select); 
    if($list[0]->idList>0){
      $weather_list = $this->inst_list->find($list[0]->idList)->current();
      $items = $this->inst_list->getItems($weather_list,$this->inst_weather->Model_id);
      
      $cities = array();
      $yw_forecast = array();
      foreach($items as $item){
        $cities[$item["item_idItem"]] =array();
        $output ="";
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "weather.yahooapis.com/forecastrss?w=".$item["woeid"]."&u=c"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
        
        $weather = simplexml_load_string($output);
        if($weather){
          $copyright = $weather->channel->copyright;
          
          $channel_yweather = $weather->channel->children("http://xml.weather.yahoo.com/ns/rss/1.0");
          
          foreach($channel_yweather as $x => $channel_item) 
          	foreach($channel_item->attributes() as $k => $attr) 
          		$yw_channel[$x][$k] = $attr;
          
          $item_yweather = $weather->channel->item->children("http://xml.weather.yahoo.com/ns/rss/1.0");
          
          foreach($item_yweather as $x => $yw_item) {
          	foreach($yw_item->attributes() as $k => $attr) {
          		if($k == 'day') $day = $attr;
          		if($x == 'forecast') { $yw_forecast[$x][$day . ''][$k] = $attr;	} 
          		else { $yw_forecast[$x][$k] = $attr; }
          	}
          }
        }
       
        $cities[$item["item_idItem"]] = array("name"=>$item["city"] , "country"=> $item["country"], "weather" =>$yw_forecast);    
        $this->view->cities = $cities;
        
      $lang = 'fr_FR';
      $session = Zend_Registry::get('session');
      if($session->lang == "en"){
        $lang = 'en_US';
      }
      $locale = new Zend_Locale($lang);
      $countries = ($locale->getTranslationList('Territory', 'fr', 2));
      asort($countries, SORT_LOCALE_STRING);
    }
    $this->view->countries = $countries;
    
    }
  }
  
  // Permet de chercher une ville
  public function searchAction(){
    $woeid = 0;
    $this->_helper->layout->disableLayout(); 
	  $this->_helper->viewRenderer->setNoRender();
    $country = $this->getRequest()->getPost("country"); 
    $city = $this->getRequest()->getPost("city");
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "query.yahooapis.com/v1/public/yql?q=select%20woeid%20from%20geo.places%20where%20text%3D%22".$city."%22%20and%20country.code%20%3D%20%22".$country."%22&diagnostics=true"); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    curl_close($ch);
    
    
    $dom = new DOMDocument('1.0', 'iso-8859-1');   
    if (!$dom->loadXML(utf8_encode($output))) {
      $errors  = "Impossible to load the XML";
    }
    
    $elems_woeid = $dom->getElementsByTagName("woeid");  
    foreach($elems_woeid as $elem){
      $woeid =  $elem->nodeValue;
    } 
    
    if($woeid > 0){
      $select = $this->inst_list->select()->where('categorie_idcategories = ?',$this->inst_weather->Category_id)->where('title = ?', 'meteo');
      $list = $this->current_user->findModel_DbTable_ListViaModel_DbTable_UserHasListByUserAndList($select);
  	  if(count($list)==0){
  	    $data = array("title"=>"meteo", "categorie_idcategories"=>$this->inst_weather->Category_id);
  	    $idList = $this->inst_list->addList($data,$this->current_user);
  	  }else{
  	   $idList = $list[0]['idList'];
  	  }
  	  $data = array('position'=>0);
	    $data2 = array('city'=>$city,'country'=>$country,'woeid'=>$woeid);
      $this->inst_item->addItem($data,$data2,$idList,$this->inst_weather->Model_id,$this->inst_weather,$this->current_user);
    }
    echo $woeid;
  }
  
}