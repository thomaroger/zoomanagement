var Tootlist = {};

Tootlist.init = {
  "start" : function(){
    Tootlist.list.initSortable();
    Tootlist.list.initList();
    Tootlist.list.detail();
    Tootlist.notimoo.init();
    Tootlist.passShark.init();
    Tootlist.mooEditable.init();
    Tootlist.lienTips.init();
    Tootlist.calendar.init();    
    Tootlist.connexion.init();
    Tootlist.lang.init();
    Tootlist.createList.init();
    Tootlist.dialog.init();
    Tootlist.createItem.init();
    Tootlist.createItem.addItem();
    Tootlist.capturePokemon.init();
    Tootlist.style.mooRainbow();
    Tootlist.tabs.init();
    Tootlist.publicity.init();
    Tootlist.friend.init();
    Tootlist.index.init();
    Tootlist.addThis.init();
    Tootlist.notification.init();
    Tootlist.autocompletion.init();
    Tootlist.Message.init();
    Tootlist.Movie.init();
    Tootlist.Chat.init();
  }

}

Tootlist.style = {
        "mooRainbow" : function(){ 
          if($$('.pick').length > 0){       
            var sphere = new UvumiSphere('.pick',{
      			onChange:function(input,hex){
      				switch(input.get('id')){
      					case 'demoRainBowInput':
      					  if(input.get('target')=='body'){
      					   $(document.body).setStyle('background-color',hex);
      					  }else{
      					     $(document.body).getElements(input.get('target')).each(function(element,index){
      					       if(element.hasClass('modifiable')){
      					         element.setStyle('background-color',hex);
      					       }
      					   });
      					  }
      						break;
      					case 'demoRainBowInputC':
      					if(input.get('target')=='div'){
      					  $(document.body).getElements(input.get('target')).each(function(element,index){
      					    element.getChildren('p').each(function(element2,index2){
      					      element2.setStyle('color',hex);
      					      element2.getChildren('a').each(function(element3,index3){
      					       element3.setStyle('color',hex);
      					      });
      					    });
      					    
      					    element.getChildren('ul').each(function(element2,index2){
      					      element2.setStyle('color',hex);
      					      element2.getChildren('li').each(function(element3,index3){
      					       element3.setStyle('color',hex);
      					       element3.getChildren('a').each(function(element4,index4){
      					         element4.setStyle('color',hex);
      					       });
      					      });
      					    });
      					    
      					  });
      				  }else{
      					  $(document.body).getElements(input.get('target')).each(function(element,index){
      					    if(element.hasClass('modifiable')){
      					      element.setStyle('color',hex);
      					     }
      					   });
      				  }
      					 break;	
      				}
      			}
      		});
      		}
        }
}

Tootlist.cat = {
  "idCat" : null,
  
  "deleteCatBO": function(idcat,title){
    Tootlist.cat.idCat = idcat;
  
    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'une categorie", "Etes vous sur de vouloir supprimer la categorie ("+title+") ?", "Tootlist.cat.delCatBO"); 
  
  },
  "delCatBO":function(){
    var donnee = {"idCat":Tootlist.cat.idCat};
    Tootlist.Ajax.request('/backend/categorie/delete',donnee);
    Tootlist.Ajax.updateBO('/backend/categorie/',null,'center');
  }
}

Tootlist.list = {
  "mySlide" : null,
  "idList" : null,
  "idItem" : null,
  "idPokemonChoice":null,
  
  "initSortable" : function(){

    var uls = $$('.sortables');
    
    new Sortables(uls, {
      revert: { duration: 500, transition: 'back:in' },
      clone : true,
      opacity : 0.5,
      initialize: function() { 
      },
      onComplete: function(el) {
        var donnee = {tab : this.serialize() };
		    Tootlist.Ajax.request("/list/savehome",donnee);  
      }
    });
          
          
    $$('.sortable').each(function(element,index) { 
      new Sortables(element,{
        revert: { duration: 500, transition: 'back:in' },
        clone : true,
        opacity : 0.5
       });
    });
  },
  
  "initList" : function(){
    
    $$('.slide_agrandir').each(function(element,index){
      element.addEvent('click', function(e){
        mySlide = element.getParent('div').getNext().getNext();
        e.stop();
		    mySlide.show();
		    element.getParent('div').getParent().set('styles',{'height':'150px'});
	   });
    });
    
    $$('.slide_reduire').each(function(element,index){
      element.addEvent('click', function(e){
		    mySlide = element.getParent('div').getNext().getNext();
        e.stop();
		    mySlide.hide();
		    element.getParent('div').getParent().set('styles',{'height':'30px'});
	   });
    });
    $$('.slide_close').each(function(element,index){
      element.addEvent('click', function(e){
		    Tootlist.list.mySlide = element.getParent('div').getParent();
		    var title_list = element.getParent('div').getNext().getNext().getElement('a').get('text');
		    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'une liste", "Etes vous sur de vouloir supprimer la liste ("+title_list+") de votre page d'accueil ?", "Tootlist.list.destroyList"); 
	   });
    });

  },
  
  "destroyList" : function(elt){
    Tootlist.list.mySlide.fade(0);
      var destroy = function(){ 
        Tootlist.list.mySlide.getParent('li').destroy();
        var donnee = {tab : Tootlist.list.serialize($$('.sortables')) };
        Tootlist.Ajax.request("/list/savehome",donnee);
      };
      destroy.delay(1000);
  },
  
  "serialize": function(elm){
    var tab_tmp = new Array();
    var compteur = 0;
    elm.each(function(element,index){
      var tab_tmp2 = new Array;
      compteur2 = 0;
      element.getChildren('li').each(function(element2,index){
        tab_tmp2[compteur2] = element2.get('id');
        compteur2 ++;
      });
      tab_tmp[compteur] = tab_tmp2
      compteur ++;
    });
    return tab_tmp;
  },
  
  "addHome" : function(idlist,title){
    Tootlist.list.idList = idlist;
    var bool = Tootlist.dialog.confirm("Tootlist : Ajout d'une liste", "Etes vous sur de vouloir ajouter la liste ("+title+") de votre page d'accueil ?", "Tootlist.list.addListHome"); 
  },
  
  "addListHome" : function(){
    var donnee = {"idList":Tootlist.list.idList};
    Tootlist.dialog.info("Tootlist : Ajout d'un liste","Votre liste a ete rajoute sur votre page d'accueil");
    Tootlist.Ajax.request('/list/addHome',donnee);
    Tootlist.list.trie();
  },
  
  "deleteMyList":function(idlist,title){
         Tootlist.list.idList = idlist;
    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'une liste", "Etes vous sur de vouloir supprimer la liste ("+title+") ?", "Tootlist.list.delList");
    
  
  },
  
  "deleteMyListBO":function(idlist,title){
         Tootlist.list.idList = idlist;
    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'une liste", "Etes vous sur de vouloir supprimer la liste ("+title+") ?", "Tootlist.list.delListBO"); 
  },
  
  "addMyListBO":function(idlist,title){
         Tootlist.list.idList = idlist;
    var bool = Tootlist.dialog.confirm("Tootlist : Activation d'une liste", "Etes vous sur de vouloir activer la liste ("+title+") ?", "Tootlist.list.addListBO"); 
  },
  
  
  "delList": function(){
    var donnee = {"idList":Tootlist.list.idList};
    Tootlist.Ajax.request('/list/dellist',donnee);
    Tootlist.list.trie();
  },
  
  "delListBO": function(){
    var donnee = {"idList":Tootlist.list.idList};
    Tootlist.Ajax.request('/list/dellist',donnee);
    Tootlist.Ajax.updateBO('/backend/list/view',donnee,'center');
  },
  
  "addListBO": function(){
    var donnee = {"idList":Tootlist.list.idList};
    Tootlist.Ajax.request('/list/addlist',donnee);
    Tootlist.Ajax.updateBO('/backend/list/view',donnee,'center');
  },
  
  
  "trie":function(){
   var criteria = $("trie").value;
   var donnee = {criteria:criteria };
   Tootlist.Ajax.update('/list/ajaxlisttrie/',donnee,'mylistid');
   
  },
  
  "displayFormUpdate" : function(id)
  {
    
    var donnee = {"idList":id};
   
     $("divListUpdate").set('text',''); 
     
     Tootlist.Ajax.update('/list/ajaxformupdatelist',donnee,"divDetailList");
  
  },
  "detail" : function(){
     if($("idListDetail"))
     {
      
      var donnee = {"idList":$("idListDetail").value};
      
      Tootlist.Ajax.update('/list/ajaxdetaillist',donnee,"divListUpdate");  
      Tootlist.Ajax.update("/list/ajaxitemlist",donnee,"divListItem");
      
      }   
  },
  "duplicate":function(id,title){
    Tootlist.list.idList = id;
    var bool = Tootlist.dialog.confirm("Tootlist : duplication d'une liste", "Etes vous sur de vouloir dupliquer la liste ("+title+") ?", "Tootlist.list.duplicationList");
    
  },
  "duplicateList":function(){
  
     id = Tootlist.list.idList;
     
     var donnee = {"idList":id}
     Tootlist.Ajax.request('/list/ajaxduplicate',donnee);
     Tootlist.list.trie();
  },
  "choicePokemon" : function(){
     
     if($("choicePokemon1").checked==true)
      Tootlist.list.idPokemonChoice = 1;
    else if($("choicePokemon2").checked==true)
      Tootlist.list.idPokemonChoice = 4;
    else if($("choicePokemon3").checked==true)
      Tootlist.list.idPokemonChoice =7;
      

      
      var donnee = {"idPokemon":Tootlist.list.idPokemonChoice,"idList":$("idList").value,"idModel":$("idModel").value,"first":1};
      Tootlist.Ajax.request("/list/ajaxchoicepokemon",donnee);
            
     
      $("content_firstpok").destroy();
      $("content_formpok").set('style',{'display':'block'});
      
       
      
  
  }
}


Tootlist.notimoo = {
  "notimooManager" : null ,
  
  "init" : function(){
    Tootlist.notimoo.notimooManager = new Notimoo({
      visibleTime : 3000,
      notificationOpacity : 0.7
    });
  },
  
  "show" : function(titre,msg,click){
    Tootlist.notimoo.notimooManager .show({
            title: titre,
      message: msg,
      sticky: click
   });
  } 
}

Tootlist.notification = {
  "init" : function (){
    function tmp() {
      Tootlist.notification.routine();
    };
    
    function tmp_rappel() {
      Tootlist.notification.rappel();
    };
    
    Tootlist.notification.routine();
    Tootlist.notification.rappel();
    tmp.periodical(10000);
    tmp_rappel.periodical(60000);
  
  },
  
  "routine" : function(){
    var donnee = {};
    Tootlist.Ajax.updateJS("/user/notification",donnee);
  },
  
  "rappel" : function(){
    var donnee = {};
    Tootlist.Ajax.request("/agenda/notification",donnee);
  }
}

Tootlist.passShark = {
  "init" : function(){
    $each($$('.passwordShark'), function(elt){
      Tootlist.passShark.run(elt);
    });
  },
  
  "run" : function(elt){
    new PassShark(elt.id,{
                  interval: 1,
                  duration: 1,
                  replacement: '%u25CF',
                  debug: false
    });
  }
}

Tootlist.modale = {
  "open" : function(title,url,dim){
    TB_show(title,url+"?&"+dim)
  }
}


Tootlist.GoogleMap = {
  "map" : null ,
  "geocoder" : null ,
  
  "initialize" : function(){
    if(document.getElementById("map_canvas")){
      Tootlist.GoogleMap.map = new GMap2(document.getElementById("map_canvas"));
      Tootlist.GoogleMap.map.setCenter(new GLatLng(48.85667, 2.35099), 10);
      Tootlist.GoogleMap.map.addControl(new GSmallMapControl());
      Tootlist.GoogleMap.map.addControl(new GMapTypeControl());
      Tootlist.GoogleMap.geocoder = new GClientGeocoder();
    }
  },
  
  "showAddress" : function(address){
    if (Tootlist.GoogleMap.geocoder) {
      Tootlist.GoogleMap.geocoder.getLatLng(
        address,
        function(point) {
          if (!point) {
            alert(address + " non trouve");
          } else {
            var blueIcon = new GIcon(G_DEFAULT_ICON);
            blueIcon.image = "http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png";
            blueIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
            blueIcon.iconSize = new GSize(20, 34);
            blueIcon.shadowSize = new GSize(37, 34);
            blueIcon.iconAnchor = new GPoint(9, 34);
            blueIcon.infoWindowAnchor = new GPoint(9, 2);
            Tootlist.GoogleMap.map.setCenter(point, 13);
            markerOptions = {icon:blueIcon};
            var marker = new GMarker(point, markerOptions);
            Tootlist.GoogleMap.map.addOverlay(marker);
            address = "<h1>"+address.replace(',','</h1><br />')
            GEvent.addListener(marker, "mouseover", function() {
              marker.openInfoWindowHtml(address);
            });
          }
        }
      );
    }
  }
}

Tootlist.Movie = {
   "init" : function() {
    $$('.quickie').each(function(elt,index){
      elt.hide();
    });
  },
  
  "play" : function(container2){
    $$('.quickie').each(function(elt,index){
      elt.hide();
    });
    $(container2).show();
  }
}

Tootlist.mooEditable = {
  "instance" : null,
  "compteur" : 0,
  
  "init" : function(){

    Tootlist.mooEditable.instance = new Array();
     $$('.text_wysiwyg').each(function(element,index) { 
      Tootlist.mooEditable.instance[Tootlist.mooEditable.compteur] = new Array();
      Tootlist.mooEditable.instance[Tootlist.mooEditable.compteur]["instance"]= element.mooEditable();

      Tootlist.mooEditable.instance[Tootlist.mooEditable.compteur]["element"]= element;
      Tootlist.mooEditable.compteur ++;
      element.removeClass('text_wysiwyg');
    });
    
  },
  
  "submitFormulaire" : function(){
    for (i=(Tootlist.mooEditable.compteur-1); i>=0; i--) {  
      var instance = Tootlist.mooEditable.instance[i]["instance"];
      Tootlist.mooEditable.instance[i]["element"].get('value',instance.getContent());
    }     

  }
}


Tootlist.lienTips = {
  "box" : null,
  
  "init" : function(){
    Tootlist.lienTips.box = new Tips('.tips',{
      className: 'tips_tootlist',
      fixed: true,
      hideDelay: 50,
      showDelay: 50
    });
    
    $$('.tips').each(function(element,index) { 
      Tootlist.lienTips.show(element);
    });
  
  },
  
  "show" : function(element){
    var content = element.get('alt').split('::');
    element.store('tip:title', content[0]);
    element.store('tip:text', content[1]);
  }
}

Tootlist.calendar = {
  "init" : function(){
    $$('.calendar').each(function(element,index) { 
      Tootlist.calendar.show(element);
    });
  },
  
  "show" : function(element){
    new vlaDatePicker(element, { style: 'apple_widget', offset: { x: 3, y: 1 } });
  }
}

Tootlist.connexion = {
  "slide" : null,
  
  "init" : function(){
    if(!$('connexion_form')) return;
    Tootlist.connexion.slide = new Fx.Slide('connexion_form');
    if($$('.error_signin').length == 0 && $$('.entete_errors_signin').length == 0){
      Tootlist.connexion.slide.hide(); 
    }
    $('connexion_link').addEvent('click', function(e){
                  e.stop();
                  Tootlist.connexion.slide.toggle();
                  var tmp = new Fx.Slide('langage_menu');
                  tmp.hide();
         });
  }
}

Tootlist.lang = {
  "slide" : null,
  
  "init" : function(){
    if(!$('langage_menu')) return;
    Tootlist.lang.slide = new Fx.Slide('langage_menu');
    
    Tootlist.lang.slide.hide(); 
    
    $('langue_link').addEvent('click', function(e){
                  e.stop();
                  Tootlist.lang.slide.toggle();
                  var tmp = new Fx.Slide('connexion_form');
                  tmp.hide();
         });
  }
}


Tootlist.createList = {
  "init" : function(){
  
    if($("categorie")){
      $('categorie').addEvent('change',function(){ 
        var donnee = {id : $("categorie").value };
        Tootlist.Ajax.update('/list/ajaxsubcateogries/',donnee,'divSubCategorie');
      });
      
    } 

  } ,
  "submit":function(){
    var erreur = "";
    
    if($("name").value =="")
    {
     erreur += " - Le champs name ne peut pas etre libre\n";
     }
    
  
    if($("categorie").value=="")
    {
       erreur += " - Le champs categorie ne peut pas etre libre\n";
       
    } 
    
    if(erreur =="")
     $("create_form").submit();
    else
    {
     alert(erreur); 
    }
  } 
}


Tootlist.createItem = {
 "init" : function(){
  if($("addItem"))
  {
    $("addItem").addEvent('click',function(){
    
       var nbItem =$("nbItem").value.toInt();
       nbItem +=1;
       
       var label = $("type").value;
  
             
      var p = new Element('p');
      p.set('text',label+' '+nbItem);
       
 
       $("nbItem").value = nbItem;
       
       
       
      var div = new Element("div",{'id':'item_'+nbItem,'class':'item'});
      div.inject($("before"),"before");
      
      var donnee = {model : $("idModel").value,label:label,nbItem:nbItem};
      Tootlist.Ajax.update('/list/ajaxitemdynamic/',donnee,div);
      
      if(nbItem == 2)
      {
       
        var p1 = new Element('p');
        p1.set('text',label+' 1');
        p1.inject($("item_1"),'before');
      }
   
     $("nbItem").value = nbItem;
     

    });
    
  }
  
  if($("addItemDynamic"))
  {
    $$("select").addEvent('change',function(){
    
     var select = this.get("id");

     var tmp   = String.split(select,"_");
     var id    = tmp[1];
 
     var div   = $("field_"+id);
    
     var donnee = {model : $("select_"+id).value ,id:id};
    Tootlist.Ajax.update('/list/ajaxitemdynamic/',donnee,div);

    });
  
  }
 },
 
 "addItem": function()
 {
  if($("addItemDynamic"))
  {
    
    $("addItemDynamic").addEvent('click',function(){
      var nbItem =$("nbItem").value.toInt();
      
       
          var itemSelect = $("select_1").cloneNode(true);
          nbItem +=1;
          
          var div = new Element("div",{'id':'item_'+nbItem,'class':'item'});

          
          var divField = new Element("div",{'id':'field_'+nbItem,'class':'field'});
          
          itemSelect.set("id","select_"+nbItem);
          itemSelect.set("name","record["+nbItem+"][]")
          itemSelect.inject(div,"top");
          divField.inject(div,"bottom");
          div.inject($("before"),"before");
         
         
     $("nbItem").value = nbItem;
     Tootlist.createItem.init();
     
    });
   
  }
 },
 
 "addItemUpdateList" : function(displayForm)
 {
  
   var idModel = $("idModelList").value;
   var nbItem  = $("countItemList").value;
   
   $("buttonAddItem").set('style',{'color':'red'});
   nbItem = parseInt(nbItem)+1;
   
   if($("item_update"))
   {
     $("item_update").destroy();
   }
   
   //si c'est une liste de base
   if(idModel !=0 || displayForm == 1)
   {
   
    if(displayForm == 1)
     idModel = $("selectModel").value;
    // on construit le HTML  nécessaire
    var div        = new Element("div",{'id':'item_update'});
    
    var form       = new Element("form",{"id":'formAddItem',
                                         "action":"/list/additem",
                                         "method":"post"});
                                         
    var contenaire = new Element("div",{"id":"contenaire"});
    
    var input      = new Element("input",{"type":"submit",
                                          "value":"valider",
                                          "id":"submitAddItem"});
                                          
    var inputList  = new Element("input",{"type":"hidden",
                                          "value":$("idListDetail").value,
                                          "name":"idList",
                                          "id":"inputList"});
                                          
    var inputNbItem = new Element("input",{"type":"hidden",
                                          "value":1,
                                          "name":"nbItem"});
                                          
    var inputUpdateListeItem = new Element("input",{"type":"hidden",
                                          "value":1,
                                          "name":"updateListeItem",
                                          "id":"updateListItem"})
                                          
   var inputModel = new Element("input",{"type":"hidden",
                                          "value":idModel,
                                          "name":"idModel"})
    
    div.inject($("before"),"before");
    form.inject($("item_update"));
    contenaire.inject($("formAddItem"));
    
    var donnee = {model :idModel,label:"item",nbItem:nbItem};
  
    //récupération des champs nécessaires selon le type de liste
    Tootlist.Ajax.update('/list/ajaxitemdynamic/',donnee,$("contenaire"));
    
    
    inputList.inject($("contenaire"),"before");
    inputNbItem.inject($("inputList"),"before");
    input.inject($("contenaire"),"after");
    inputUpdateListeItem.inject($("submitAddItem"),"before");
    inputModel.inject($("updateListItem"),"before")
    
    $("submitAddItem").addEvent("click",function(){
     Tootlist.mooEditable.submitFormulaire();
     
     
    });
    
    
    
    
   }
   else
   {
     $("selectItemDynamique").set('style',{'display':'block'});
   
   }
 
 }
}


Tootlist.capturePokemon = {
  "init" : function(){
    if($("btnChange")){
    $("btnChange").addEvent('click',function(){
         var rand = $random(1, 151);  
          $('imgPokemon').src = "/image/pokemon/"+rand+".png";
          $('info').set('html','');
          $('thisPok').value = rand;
          
    });
    
    $("btnInfo").addEvent('click',function(){
       var donnee = {img : $("imgPokemon").src };
        Tootlist.Ajax.update('/list/ajaxinfopokemon/',donnee,'info');
    });
    
    $("btnCapture").addEvent('click',function(){
      
      var cpt = $('nbItem').value;
      
       cpt++;

      // $("nbPokemonCapture").set('html',cpt);
       
     var donnee = {"idPokemon":$('thisPok').value,"idList":$("idList").value,"idModel":$("idModel").value,"first":0};
      Tootlist.Ajax.request("/list/ajaxchoicepokemon",donnee);
      
         
      var rand = $random(1, 151);  
      $('imgPokemon').src = "/image/pokemon/"+rand+".png";
      $('info').set('html','');
       $('thisPok').value = rand;

    
    });
    }
  }

}

Tootlist.Ajax = {
  "update" : function(p_url,donnee,update,highlight){
     var myRequest = new Request({url: p_url,
                                 method: 'post',
                                 data: donnee,
                                 onComplete: function(response) { 
                                   $(update).set('html',response);
                                   if(highlight == 1){
                                     $(update).highlight('#DC4F4D');
                                   }
                                    Tootlist.mooEditable.init();
                                    Tootlist.calendar.init(); 
                                    Tootlist.passShark.init();
                                    Tootlist.skin.reload();
                                    Tootlist.lienTips.init();
                                    Tootlist.createList.init(); 
                                 }
                                }).send();
  },
  
  "updateBO" : function(p_url,donnee,update,highlight){
     var myRequest = new Request({url: p_url,
                                 method: 'post',
                                 data: donnee,
                                 onComplete: function(response) { 
                                   $(update).set('html',response);
                                   if(highlight == 1){
                                     $(update).highlight('#DC4F4D');
                                   }
                                    Tootlist.mooEditable.init();
                                    Tootlist.calendar.init(); 
                                    Tootlist.passShark.init();
                                    Tootlist.lienTips.init();
                                    Tootlist.createList.init();
                                    TB_init(); 
                                 }
                                }).send();
  },
  
  
  "updateJS" : function(p_url,donnee,update,highlight){
     var myRequest = new Request({url: p_url,
                                 method: 'post',
                                 data: donnee,
                                 onComplete: function(response) { 
                                  eval(response);
                                 }
                                }).send();
  },
  
  "request" : function(p_url,donnee){
    var myRequest = new Request({url: p_url,
                                 method: 'post',
                                 data: donnee
                                }).send();
  }
}



Tootlist.dialog = {
  "instance" : null,
  
  "init" : function(){
    Tootlist.dialog.instance =  new SexyAlertBox();
  },
  
  "confirm" : function(title,message,fonction){
      Tootlist.dialog.instance.confirm('<h1>'+title+'</h1> <p>'+message+'</p>', 
                                        {onComplete:  function(returnvalue) {
                                           if(returnvalue){
                                            Tootlist.dialog.callback(fonction);
                                           }
                                          }});      
  },
  
  "info" : function(title,message){
    Tootlist.dialog.instance.info('<h1>'+title+'</h1> <p>'+message+'</p>');
  },
  
  "error" : function(title,message){
    Tootlist.dialog.instance.alert('<h1>'+title+'</h1> <p>'+message+'</p>');
  },
  
  "callback" : function(funct){
    if(funct=="Tootlist.list.destroyList"){
      Tootlist.list.destroyList();
    }
    if(funct=="Tootlist.list.addListHome"){
      Tootlist.list.addListHome();
    }
    if(funct=="Tootlist.list.delList"){
      Tootlist.list.delList();
    }
    if(funct=="Tootlist.list.delListBO"){
      Tootlist.list.delListBO();
    }
    if(funct=="Tootlist.list.addListBO"){
      Tootlist.list.addListBO();
    }
    if(funct=="Tootlist.calendrier.destroyRecall"){
      Tootlist.calendrier.destroyRecall();
    }
    if(funct == "Tootlist.item.itemDel"){
      Tootlist.item.itemDel();
    }
    if(funct == "Tootlist.list.duplicationList"){
      Tootlist.list.duplicateList();
    }
    if(funct == "Tootlist.user.delUserBO"){
      Tootlist.user.delUserBO();
    }
    if(funct == "Tootlist.user.addUserBO"){
      Tootlist.user.addUserBO();
    }
    
    if(funct == "Tootlist.cat.delCatBO"){

      Tootlist.cat.delCatBO();
    }
    
    if(funct == "Tootlist.publicity.ajaxdisplay"){
     Tootlist.publicity.ajaxdisplay();
    }
  }
}

Tootlist.tabs = {
  "open" : null,
  "element" : null,
  
  "init" : function(){
    if($('title_formulaire_content')){
      if($('title_formulaire_content').getChildren('span').length > 0){
        $('title_formulaire_content').getChildren('span').each(function(element,index){ 
          if(index == 0 ){
            Tootlist.tabs.element = element;
          }
          $(element.get('target')).hide();
          element.setStyles({'cursor':'pointer'}); 
          element.addEvent('click', function(e){
            Tootlist.tabs.open.fade(0);
            var open = function(){ 
              if(Tootlist.tabs.element){
                Tootlist.tabs.element.setStyles({"text-decoration":"none"});
              }
              element.setStyles({"text-decoration":"underline"});
              Tootlist.tabs.element = element;
              Tootlist.tabs.open.setStyles({'display':'none'});
              Tootlist.tabs.open = $(element.get('target'));
              Tootlist.tabs.open.show();
              Tootlist.tabs.open.fade(1);
              Tootlist.tabs.open.setStyles({'display':'block'});
            };
            open.delay(500);
            
          });
        });
        $($('title_formulaire_content').getChildren('span')[0].get('target')).show();
        Tootlist.tabs.open = $($('title_formulaire_content').getChildren('span')[0].get('target'));
      }
    }
  }
}

Tootlist.publicity = {

  "idPub" : null,
  "display" : null,
  
  "init" : function(){
     var tmp = $('publicity_img').getStyle('height');
      $('publicity_div').setStyle('height',(parseInt(tmp.substr(0,tmp.indexOf('px',0)))+30)+"px");
      new Drag.Move($('publicity_img'),{'container': $('site')});
      $('publicity_img').setStyle('top','20px');
      
      var genPub= function(){
        $('publicity_img').fade(0);
        var donnee = {'id_pub':$('publicity_img').get('suiv')};
        var myRequest = new Request({url: '/index/publicity',
                               method: 'post',
                               data: donnee,
                               onComplete: function(response) { 
                                 $('publicity_div').set('html',response);
                                 $('publicity_img').fade(1);  
                                 $('publicity_div').setStyle('height',(parseInt(tmp.substr(0,tmp.indexOf('px',0)))+20)+"px");
                                 new Drag.Move($('publicity_img'),{'container': $('site')});
                               }
                              }).send();
        
        };      
      genPub.periodical(5000);
  },
  
  "display" : function(display,idPub,title){
    Tootlist.publicity.idPub = idPub;
    Tootlist.publicity.display = display;
  
    if(display == 1){
      var bool = Tootlist.dialog.confirm("Tootlist : Activer la publicite", "Etes vous sur de vouloir activer la   publicite ("+title+") ?", "Tootlist.publicity.ajaxdisplay");  
    } else {
      var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'une publicite", "Etes vous sur de vouloir supprimer la publicite ("+title+") ?", "Tootlist.publicity.ajaxdisplay"); 
    }
  },
  
  "ajaxdisplay":function(){
    var donnee = {"idPub":Tootlist.publicity.idPub,"display":Tootlist.publicity.display};
    Tootlist.Ajax.request('/backend/publicity/display',donnee);
    var tmp = function(){
      Tootlist.Ajax.updateBO('/backend/publicity/',null,'center');
    }
    tmp.delay(500);
  }
  
}


Tootlist.friend = {
  "init" : function(){
    if($('listAjaxUser')){
      $('listAjaxUser').fade(0);  
      var listUserBlock = function(){
        $('listAjaxUser').setStyles({'display':'block'});   
      } 
      listUserBlock.delay(500);
      
    }
  },
  
  "search" : function(value,typeARG){
    if(value==""){
      Tootlist.dialog.info("Recherche d'un utilisateur", "Le champ de recherche ne peut etre vide !");
      return;
    }
    var donnee = {search : value, type : typeARG };
		Tootlist.Ajax.update("/friend/list",donnee,'listUserContent');
		$('listAjaxUser').fade(1);  
		Tootlist.Ajax.updateJS('/user/skinjs');  
  },
  
  "gmail" : function(loginARG,passwordARG,typeARG){
    if(loginARG=="" || passwordARG==""){
      Tootlist.dialog.info("Gmail : Recherche d'un utilisateur", "Vous devez renseigner l'email et le mot de passe");
      return;
    }
    var donnee = {login : loginARG,password : passwordARG, type : typeARG };
		Tootlist.Ajax.update("/friend/list",donnee,'listUserContent');
		$('listAjaxUser').fade(1);
  },
  
  "action" : function(state,value,elt){
    if(state == 0){
      var donnee = {idFriend : value};
      Tootlist.Ajax.update("/friend/add",donnee,elt.getParent().get('id'),1);
    }else{
      var donnee = {mail : value};
      Tootlist.Ajax.update("/friend/mail",donnee,elt.getParent().get('id'),1);
    }
  },
  
  "actionFriend" : function(idNotification,idItemFriend,state){
    var donnee = {idNotif :idNotification, idItemF : idItemFriend};
    if(state == 1){
       Tootlist.Ajax.request("/friend/accept",donnee);
    }else{
       Tootlist.Ajax.request("/friend/refuse",donnee);
    }
  } 
}


Tootlist.index = {
  "see" : null,
  
  "slidePicture" : function(element,element2){
    element2.fade(0);
    element2.setStyles({"display":"none"});
    if(element2.getNext()){
     element2 = element2.getNext();
     element2.setStyles({"display":"block"});
     element2.fade(1);
    }else{
      element2=element2.getParent().getChildren()[0];
      element2.fade(1);
      element2.setStyles({"display":"block"});
    }
    var slidePicture = function(){
      Tootlist.index.slidePicture(element,element2);
    }
    slidePicture.delay(5000);
  },
  
  "init" : function(){
    if($$('.picture_index')){
      $$('.picture_index').each(function(element,index){
        element.getChildren('li').each(function(element2,index2){
          element2.fade(0);
          if(index2 == 0){
            var listPictureBlock = function(){
              element2.setStyles({'display':'block'});
              element2.fade(1);
              var slidePicture = function(){
                Tootlist.index.slidePicture(element,element2);
              }
              slidePicture.delay(5000);
            }
          }else{
            var listPictureBlock = function(){
              element2.setStyles({"display":"none"});
            }
          }
          
          listPictureBlock.delay(500);
        });
      });
    }
  }
}

Tootlist.addThis = {
  "init" : function(){
    if($$('.addthis_toolbox')[0]){
      $$('.addthis_toolbox')[0].setStyles({"height":"30px","line-height":"30px"});
      $$('.addthis_toolbox')[0].getChildren('a').each(function(element,index){
        element.getChildren('span').each(function(element2,index2){
          element2.setStyles({"margin-top":"7px","background-repeat":"no-repeat"});
        });      
      });
      $$('.addthis_toolbox')[0].getChildren('span')[0].setStyles({"margin-top":"7px"});  
    }   
  }
}

Tootlist.calendrier = {
  "idRecall" : null,
  
  "view" : function(year,month,view, week){
    var donnee = {"year" : year, "month" : month, "view" : view, "week": week };
    $('center').setStyles({"visibility": "hidden", "opacity": 0});
    new Request({url: "/agenda/index",
                 method: 'post',
                 data: donnee,
                 onComplete: function(response) { 
                   $('center').set('html',response);
                   $('center').fade(1);
                   Tootlist.skin.reload();
                   Tootlist.lienTips.init();
                  }
               }).send();
  },
  
  "addRecall" : function(args){
    var myRequest = new Request({url: '/agenda/addrecall',
                                 method: 'post',
                                 data: args,
                                 onComplete: function(response) { 
                                   $('recall_type').set('value',1);
                                   $('recall_timescale').set('value',1);
                                   $('recall_number').set('value','');
                                   Tootlist.Ajax.update('/agenda/viewrecall',{'idEvent' : $('recall_Event_idEvent').get('value')},'recall_view',1);
                                 }
                                }).send();
  },
  
  "delRecall" : function(id){
    Tootlist.calendrier.idRecall = id;
    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'un rappel", "Etes vous sur de vouloir supprimer ce rappel ?", "Tootlist.calendrier.destroyRecall"); 
  },
  
  "destroyRecall" : function(){
    var donnee = {'idItem' :Tootlist.calendrier.idRecall}
    var myRequest = new Request({url: '/agenda/deleterecall',
                                 method: 'post',
                                 data: donnee,
                                 onComplete: function(response) { 
                                   Tootlist.Ajax.update('/agenda/viewrecall',{'idEvent' : $('recall_Event_idEvent').get('value') },'recall_view',1);
                                 }
                                }).send();
  }
}


Tootlist.music = {
  "toogle" : function(elt){
    $$('.player_music').each(function(element,index){
      element.hide();
    });
    $(elt).show();
  }
}

Tootlist.picture = {
  "slideur" : 0,
  "nb_max" : 0,
  "periodical" : null,

  "init" : function(){
    Tootlist.picture.nb_max = $$('.picture_block').length;
    $$('.picture_block').each(function(element, index){
      element.hide();
      element.fade(0);
    }); 
    if($$('.picture_block')[Tootlist.picture.slideur]){
      $$('.picture_block')[Tootlist.picture.slideur].show();
      $$('.picture_block')[Tootlist.picture.slideur].fade(1);
      if($$('.picture_block')[Tootlist.picture.slideur].getChildren('div')[0].getChildren('a')[0].getChildren('img')[0]){
        var img_width = $$('.picture_block')[Tootlist.picture.slideur].getChildren('div')[0].getChildren('a')[0].getChildren('img')[0].getStyle('width');
        img_width = img_width.replace('px','');
        img_width_new  = img_width - 200;
  
        $$('.picture_block')[Tootlist.picture.slideur].getChildren('div')[0].setStyle('width',img_width_new+'px');
        $$('.picture_block')[Tootlist.picture.slideur].getChildren('div')[0].getChildren('a')[0].getChildren('img')[0].setStyle('width',img_width_new+'px');
                    
        new Zoomer($$('.picture_block')[Tootlist.picture.slideur].getChildren('div')[0].getChildren('a')[0].getChildren('img')[0].id); 
      }
    }
  },
  
  "slide_next" : function(){
    Tootlist.picture.slideur ++;
    if(Tootlist.picture.nb_max <= Tootlist.picture.slideur) {
      Tootlist.picture.slideur = 0;
    }
    Tootlist.picture.init();
  },
  
  "slide_previous" : function(){
    Tootlist.picture.slideur --;
    if(Tootlist.picture.slideur < 0) {
      Tootlist.picture.slideur = (Tootlist.picture.nb_max-1);
    }
    Tootlist.picture.init();
  },
  
  "play" : function(){
    Tootlist.picture.periodical = Tootlist.picture.slide_next.periodical(10000);
    $('picture_play').setStyles({'display':'none'});
    $('picture_pause').setStyles({'display':'inline'});
  },
  
  "pause" : function(){
    $('picture_play').setStyles({'display':'inline'});
    $('picture_pause').setStyles({'display':'none'});
    $clear(Tootlist.picture.periodical);
  }
}


Tootlist.skin = {
  "reload" : function(){
    Tootlist.Ajax.updateJS('/user/skinjs'); 
    TB_init();
  }
}


Tootlist.item = {
  "idItem" :null,
  
  "delItem" : function(idItem,title){
    Tootlist.item.idItem = idItem;
    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'un item", "Etes vous sur de vouloir supprimer l'item ("+title+") ?", "Tootlist.item.itemDel");
  },
  
  "itemDel":function() {
     var idItem = Tootlist.item.idItem;
     var idList = $("idListDetail").value; 
     var donnee = {"idList":idList,"idItem":idItem,"del":1};
     Tootlist.Ajax.update("/list/ajaxitemlist",donnee,"divListItem");
  },
  
  "updateItem" : function(idItem){
   var idList = $("idListDetail").value;     
   var donnee = {"idItem":idItem,"idList":idList};
    Tootlist.Ajax.update("/list/ajaxupdateitem",donnee,"divUpdateItem_"+idItem);
  
  }
}

Tootlist.autocompletion = {
  "init" : function(){
    $$(".autocomplete").each(function(elt,index){
      new TextboxList(elt.get('id'), {unique: true, plugins: {autocomplete: {
					minLength: 3,
					queryRemote: true,
					remote: {url: elt.get('target')}
				}}});
    });
  }
}

Tootlist.Message = {
  "verifForm" : function(){
    Tootlist.mooEditable.submitFormulaire();
    
    if($('input_destinataire').get('value')==""){
      $('input_destinataire').getAllNext('div')[1].show();
      return false;
    }else{
      $('input_destinataire').getAllNext('div')[1].hide();
    }
    if($('subject').get('value')==""){
      $('subject').getNext('div').show();
      return false;
    }else{
      $('subject').getNext('div').hide();
    }
    if($('description').get('value')==""){
      $('description').getNext('div').show();
      return false;
    }else{
    $('description').getNext('div').hide();
    }
  },
  
  "addMessage" : function(){
    Tootlist.mooEditable.submitFormulaire();
    if($('description_message').get('value')==""){
      $('description_message').getParent().getNext().show();
      return false;
    }else{
      $('description_message').getParent().getNext().hide();
    }
  },
  
  "routine" : function(){
    var donnee = {};
    Tootlist.Ajax.updateJS("/message/verif",donnee);
  },
  
  "init" : function(){
    function tmp() {
      Tootlist.Message.routine();
    };
    
    Tootlist.Message.routine();
    tmp.periodical(30000);
  }
}

Tootlist.Chat = {
  "compteur" : 0,
    
  "init" : function(){    
    function tmp() {
      Tootlist.Chat.routine();
    };
    
    Tootlist.Chat.routine();
    tmp.periodical(30000);
    
  },
  
  "show" : function(count){
    Tootlist.Chat.compteur = count;
    $$(".tootlist_chat_tchat").each(function(elt,index){
      elt.hide();
      $$(".tootlist_chat_menu")[index].getChildren('p').setStyles({"text-decoration":"none"});
    });
    
    $('form_msg_description').set('value','');
    if($$(".tootlist_chat_tchat").length > 0) {
      $$(".tootlist_chat_tchat")[Tootlist.Chat.compteur].show();
      $('form_msg_destinataire').set('value',$("chat_users_chat").getChildren('div')[Tootlist.Chat.compteur].get('target'));
      $('form_msg_user').set('html',$("menu_users_chat").getChildren('div')[Tootlist.Chat.compteur].get('target'));
      $$(".tootlist_chat_menu")[Tootlist.Chat.compteur].getChildren('p').setStyles({"text-decoration":"underline"});
      new Fx.Scroll($$(".tootlist_chat_tchat")[Tootlist.Chat.compteur]).toBottom(); 
    }
  },
  
  "onSubmit" : function(args){
  
    if($('form_msg_description').get('value')==""){
      $('form_msg_description').getNext('div').show();
      return false;
    }else{
      $('form_msg_description').getNext('div').hide();
    }
    
    var args = {"user_id":$('form_msg_destinataire').get('value'),"description":$('form_msg_description').get('value')};
    
    var myRequest = new Request({url: '/chat/add',
                                 method: 'post',
                                 data: args,
                                 onComplete: function(response) { 
                                   Tootlist.Chat.routine();
                                 }
                                }).send();
                                
                                
    $('form_msg_description').set('value','');
  },
  
  "routine" : function(){
    if($('listChat')) {
       var donnee ={};        
       var myRequest = new Request({url: '/chat/update',
                                   method: 'post',
                                   data: donnee,
                                   onComplete: function(response) { 
                                     $('listChat_Update').set('html',response);
                                     Tootlist.Chat.maj();
                                     Tootlist.skin.reload();
                                     if($$(".tootlist_chat_tchat").length > 0) {
                                       new Fx.Scroll($$(".tootlist_chat_tchat")[Tootlist.Chat.compteur]).toBottom(); 
                                     }
                                   }
                                  }).send();
    }
  },
  
  "maj" : function(){
     if($('chat_users_chat')) {
      $$(".tootlist_chat_tchat").each(function(elt,index){
        elt.hide();
      });
      
      var height = $('menu_users_chat').getStyle('height').replace('px','');
  
      if(height > 300){
        $('chat_users_chat').getChildren('div').each(function(elt,index){
          elt.setStyles({"height":$('menu_users_chat').getStyle('height')});
        });
      }else{
        $('chat_users_chat').getChildren('div').each(function(elt,index){
          elt.setStyles({"height":"300px"});
        });
      }
      
      if($$(".tootlist_chat_tchat").length > 0) {
        $$(".tootlist_chat_tchat")[Tootlist.Chat.compteur].show();
        $('form_msg_destinataire').set('value',$("chat_users_chat").getChildren('div')[Tootlist.Chat.compteur].get('target'));
        $('form_msg_user').set('html',$("menu_users_chat").getChildren('div')[Tootlist.Chat.compteur].get('target'));
        $$(".tootlist_chat_menu")[Tootlist.Chat.compteur].getChildren('p').setStyles({"text-decoration":"underline"});
        new Fx.Scroll($$(".tootlist_chat_tchat")[Tootlist.Chat.compteur]).toBottom();  
      }
    }
  }
}


Tootlist.weather = {
  "verifForm" : function(){
    if($('country').get('value')==""){
      $('country').getAllNext('div').show();
      return false;
    }else{
      $('country').getAllNext('div').hide();
    }
    
    if($('city').get('value')==""){
      $('city').getAllNext('div').show();
      return false;
    }else{
      $('city').getAllNext('div').hide();
    }
    
    Tootlist.weather.onSubmit();
  },
  
  "onSubmit" : function(){
    var donnee = {'country':$('country').get('value'),'city':$('city').get('value')};
    var myRequest = new Request({url: "/weather/search",
                               method: 'post',
                               data: donnee,
                               onComplete: function(response) { 
                                if(response > 0){
                                  Tootlist.dialog.info("Tootlist M&eacute;t&eacute;o", $('city').get('value')+ " a &eacute;t&eacute; ajout&eacute; &agrave; votre liste de m&eacute;t&eacute;o avec succ&egrave;s");
                                  document.location.href="/weather/index";
                                }else{
                                  Tootlist.dialog.error("Tootlist M&eacute;&eacute;o", $('city').get('value')+ " n'a pas &eacute;t&eacute; ajout&eacute; &agrave; votre liste de m&eacute;t&eacute;o. <br /> Verifier votre ville et le pays.");
                                }
                               }
                              }).send();
  }
}  
  
Tootlist.search ={

  "key" : function(value){
    $('center').fade(0); 
    var donnee = {search : value};
    var myRequest = new Request({url: "/search/list",
                               method: 'post',
                               data: donnee,
                               onComplete: function(response) { 
                               	 $('center').set('html',response);
                               	 $('center').fade(1);  
                            		 Tootlist.list.initSortable();
                            		 Tootlist.Ajax.updateJS('/user/skinjs'); 
                               }
                              }).send();
  }
  
}

Tootlist.user = {
  "idUser" : null, 
  
  "deleteMyListBO":function(idlist,title){
    Tootlist.user.idUser = idlist;
    var bool = Tootlist.dialog.confirm("Tootlist : Suppression d'un utilisateur", "Etes vous sur de vouloir supprimer un utilisateur ("+title+") ?", "Tootlist.user.delUserBO"); 
  },
  
  "addMyListBO":function(idlist,title){
    Tootlist.user.idUser  = idlist;
    var bool = Tootlist.dialog.confirm("Tootlist : Activation d'un utilisateur", "Etes vous sur de vouloir activer un utilisateur ("+title+") ?", "Tootlist.user.addUserBO"); 
  },
  
  
  "addUserBO": function(){
    var donnee = {"idList":Tootlist.user.idUser };
    Tootlist.Ajax.request('/backend/user/adduser',donnee);
    Tootlist.Ajax.updateBO('/backend/user/view',donnee,'center');
  },
  
  "delUserBO": function(){
    var donnee = {"idList":Tootlist.user.idUser };
    Tootlist.Ajax.request('/backend/user/deluser',donnee);
    Tootlist.Ajax.updateBO('/backend/user/view',donnee,'center');
  }

}



window.addEvent('load', Tootlist.init.start);