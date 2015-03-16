var GoogleT = {};

GoogleT.init = {
  "start" : function(){
    GoogleT.Calendar.init();
  }
}

GoogleT.Calendar = {
  "scope" : "http://www.google.com/calendar/feeds/",
  "token" : null,
  "myService" :null,
  "calendarService" : null,
  
  "init" : function(){
     google.setOnLoadCallback(GoogleT.Calendar.getMyFeed);
     GoogleT.Calendar.checkLogin();
     GoogleT.Calendar.calendarService = new google.gdata.calendar.CalendarService('GoogleInc-jsguide-1.0');
  },
  
  "checkLogin" : function(){
    var tmp =google.accounts.user.checkLogin(GoogleT.Calendar.scope);
    if(tmp!=""){
      if($('synchronisation_google')){
        $('login').hide();
        $('logout').show();
        $('synchronisation_google').show();
      }
    }else{
      if($('synchronisation_google')){
        $('login').show();
        $('logout').hide();
        $('synchronisation_google').hide();
       }
    }
  },
  
  "logIn" : function(){
    GoogleT.Calendar.token = google.accounts.user.login(GoogleT.Calendar.scope);
    GoogleT.Calendar.checkLogin();
  },
  
  "logOut" : function(){
     google.accounts.user.logout();
     GoogleT.Calendar.checkLogin();
  },
 
  "setupMyService" : function(){
   GoogleT.Calendar.myService = new google.gdata.calendar.CalendarService('exampleCo-exampleApp-1');
   GoogleT.Calendar.logIn();
  },
  
  "getMyFeed" : function(){
    GoogleT.Calendar.myService();
    GoogleT.Calendar.myService.getEventsFeed(GoogleT.Calendar.scope, GoogleT.Calendar.handleMyFeed, GoogleT.Calendar.handleError);
  },
  
  handleMyFeed: function(myResultsFeedRoot) {
    alert("This feed's title is: " + myResultsFeedRoot.feed.getTitle().getText());
  },
  
  handleError : function(e) {
    alert("There was an error!");
    alert(e.cause ? e.cause.statusText : e.message);
  },
  
  synchronisation : function(){
    Tootlist.Ajax.updateJS('/agenda/createevent'); 
  } 
  
}


google.load("gdata", "1");
window.addEvent('load', GoogleT.init.start);










 