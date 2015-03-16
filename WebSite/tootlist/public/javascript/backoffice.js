var TootlistBO = {};

TootlistBO.init = {
  "start" : function(){
   
  }

}
 
  
TootlistBO.list = {

 "newFieldType": function(){
  
   var nbField = 1;

   
  $$('.field').each(function (el,i){
              nbField += 1;
        });   
 
   var p     = new Element("p",{"class":"field"});
   var lbl   = new Element("label",{"text":"Champ "+nbField});
   var input = new Element("input",{"type":"text","name":"field[]"}) 
   
   
   var select= new Element("select",{"class":"select[]","name":"select[]"});
   var opt1  = new Element("option",{"value":"text","text":"texte"});
   var opt2  = new Element("option",{"value":"varchar(255)","text":"varchar"});
   var opt3  = new Element("option",{"value":"date","text":"date"});
   
   opt1.inject(select);
   opt2.inject(select);
   opt3.inject(select);
   
   
    lbl.inject(p);
    input.inject(p,"bottom");
    select.inject(p,"bottom");
    
    p.inject($("before"),"before");
 },
 
 "submitCreateType":function(){
     var error = true;
    

    if($("nameType").value=="")
    {
      $("lblnameType").set('styles', {'color': 'red'});
      error = false;
    }
    else
    {
      $("lblnameType").set('styles', {'color': 'black'});  
    }
    
    if($("nameTypeEn").value =="")
    {
     $("lblnameTypeEn").set('styles',{'color':'red'});
     error = false;
    }
    else
    {
     $("lblnameTypeEn").set('styles',{'color':'black'});
    }
    
   if($("champ").value =="")
    {
     $("lblChamp").set('styles',{'color':'red'});
     error = false;
    }
    else
    {
     $("lblChamp").set('styles',{'color':'black'});
    }
    
    if(error ==false)
      return false;
    else
     $("form").submit();
 }

}



window.addEvent('load', TootlistBO.init.start);