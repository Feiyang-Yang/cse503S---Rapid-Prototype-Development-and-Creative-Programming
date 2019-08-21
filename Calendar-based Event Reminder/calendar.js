function loginAjax(event){

   
	var username = document.getElementById("loginusername").value; // Get the username from the form
	var password = document.getElementById("loginpassword").value; // Get the password from the form
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "login_ajax.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Logged In!");
			var user = jsonData.username;
			 $("p1").hide(); 
			//document.write(user2);
			$('#calendar').fullCalendar('refetchEvents');
		}else{
			alert("You were not logged in.  "+jsonData.message);
			var user = jsonData.username;
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 
 function Calendar(month, year) {
  this.month = (isNaN(month) || month == null) ? cal_current_date.getMonth() : month;
  this.year  = (isNaN(year) || year == null) ? cal_current_date.getFullYear() : year;
  this.html = '';
}


 function register(event){
    var username = document.getElementById("loginusername").value; // Get the username from the form
	var password = document.getElementById("loginpassword").value; // 
    console.log(username);
  var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "register.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been registered!");
           //  $("p1").show();     $("p2").show();
		}else{
			alert("You were not registeredin.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 
 
 
 function next(){
    if (cal.month<11){
    cal.month+=1;}
    else {
        cal.month = 0 ;
        cal.year+=1;
        
      //var nextMonth = (this.month+1);
    }
    var nextCal = new Calendar(cal.month,cal.year);
    nextCal.generateHTML();
    
    
    
    //console.log(nextCal);
    newHtml = nextCal.getHTML();
    ////document.getElementById("currentcal").innerHTML=  nextCal.getHTML();
      document.getElementById("currentcal").innerHTML=  newHtml;
 }
 

 
 function addCalendar(){
    var username = document.getElementById("calendarusername").value;
    var calendarname = document.getElementById("calendarname").value;
    var dataString = "username=" + encodeURIComponent(username) + "&calendarname=" + encodeURIComponent(calendarname);
    
    	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "addCalendar.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("calendar has been added ");
		}else{
			alert("calendar failed to be added "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 
function loadCal(){
 // var username = $_POST['username'];
    var username = document.getElementById("loadcalendarusername").value;
    var dataString = "username=" + encodeURIComponent(username);
    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "loadCalendar.php", true);
    
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("calendar has been added ");
		}else{
			alert("calendar failed to be added "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

function logout(event){
        var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "logout.php", true);
        xmlHttp.send(null);
        xmlHttp.addEventListener("load", function(event){
                var jsonData = JSON.parse(event.target.responseText);
                if(jsonData.success){
                        alert("Log out successful!");
						
                  $('#calendar').fullCalendar('removeEvents');
				   $('#calendar').fullCalendar('refetchEvents');
				    $("p1").show(); 
                }else{
                        alert("You were not logged out.");
                }
        }, false);
}










 function submitEvent(event){
	
	
	
	      $("#datepicker").datepicker(
{
    onSelect: function()
    { 
        var dateObject = $(this).datepicker('getDate');
       var object2 =  $.datepicker.formatDate( "yy-mm-dd", dateObject );
       var dateconv = new Date (object2);
 
        
    }
});
     
        var dateObject = $("#datepicker").datepicker('getDate');
       var object2 =  $.datepicker.formatDate( "yy-mm-dd", dateObject );
	
var eventhour = $( "#hours" ).spinner( "value" );
 var eventminute = $( "#minutes" ).spinner( "value" );
var eventsecond =  $( "#seconds" ).spinner( "value" );
var datestring = "" + object2 +" "+ eventhour+":"+eventminute+":"+eventsecond;
console.log(datestring);
var fulldate = new Date (datestring);

 console.log(fulldate);

 
 var test;
test = fulldate;
test = test.getUTCFullYear() + '-' +
    ('00' + (test.getUTCMonth()+1)).slice(-2) + '-' +
    ('00' + test.getUTCDate()).slice(-2) + ' ' + 
    ('00' + test.getHours()).slice(-2) + ':' + 
    ('00' + test.getUTCMinutes()).slice(-2) + ':' + 
    ('00' + test.getUTCSeconds()).slice(-2);
console.log(test);






var eventdurhour = $( "#durhours" ).spinner( "value" );
 var eventdurminute = $( "#durminutes" ).spinner( "value" );
var eventdursecond =  $( "#durseconds" ).spinner( "value" );
var duration = ""+eventdurhour+eventdurminute+eventdursecond;

   
   
     var title = document.getElementById("eventtitle").value;
  
   
   
    var detail= document.getElementById("eventdetail").value;

   var targetcalendarid =  document.getElementById("desiredcalid").value;
   
   
   
   
   
	

	var dataString = "test=" + encodeURIComponent(test) + "&duration=" + encodeURIComponent(duration) + "&title=" + encodeURIComponent(title) + "&detail=" + encodeURIComponent(detail)+ "&targetcalendarid=" + encodeURIComponent(targetcalendarid);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "uploadevent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("uploadsuccess!");
		}else{
			alert("uploadfail.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}