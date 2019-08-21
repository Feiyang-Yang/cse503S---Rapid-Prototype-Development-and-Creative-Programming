<!DOCTYPE html>

<html>
    
<head>
    <title>Your Calendar</title>
    <meta charset="UTF-8">
   
    <script src="calendar.js" type="text/javascript"></script>
      <script src="http://classes.engineering.wustl.edu/cse330/content/calendar.min.js" type="text/javascript"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
      <script src=" https://cloud.github.com/downloads/knockout/knockout/knockout-2.2.0.js"></script>
   
   
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
      
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();

$("#datepicker").datepicker("setDate", new Date());
 altFormat: "yy-mm-dd";

  } );
  </script>

  


<style>
table, th, td {
    border: 1px solid black;
}
.example{padding: 10px; font-family: Arial}
.example p{margin-top: 10px;}
</style>


</head>

<body>
    <?php
    session_start();
    if ($_SESSION['username']!= null){
      $username = $_SESSION['username'];}
      
      ?>
    
      <button onclick="next()">next month</button>
    <label> username </label>

<input type="text" name="username" id="loginusername"/>

<label> password </label>

<input type="password" name="password" id="loginpassword"/><br>



 <button onclick="loginAjax()">Click me to login </button>
  <button onclick="register()">Click me to register</button>
  
  
<br>
<br>
<br>
<br>
<br>
<?php

echo '<input type="hidden" id="loadcalendarusername" value="'.$username.'"/>';

 echo' <button onclick="loadCal()">loadCalendar</button>';
 ?>
 <button onclick="loadEvent()">load</button>
<button onclick="logout()">logout</button>







<!-- Calendar -->
<table id="currentcal"></table>


 <p1>
    <label> add a new calendar here </label>
    <br>
    <br><br><br><br>
    <h4>calendar name </h4>
    <?php 
     //$username = $_SESSION['username'];
 echo' <input type="text" name="calendarname" id="calendarname"/>';
  echo'  <input type="hidden" id="calendarusername" value="'.$username.'"/>';
     echo'      <button onclick="addCalendar()">addnewcalendar</button>';
       ?>
 </p1>
 
 <p2>
    <label> your personal calendars are displayed here</label>
    <p id=child> </p>

 </p2>
 
 
<script>

  $("p1").hide();
  $("p2").hide();


</script>


  
   
   
  
  <p>Date: <input type="text" id="datepicker"></p>

   
 <!--  <script type="text/javascript">
      $("#datepicker").datepicker(
{
    onSelect: function()
    { 
        var dateObject = $(this).datepicker('getDate');
       var object2 =  $.datepicker.formatDate( "yy-mm-dd", dateObject );
       var dateconv = new Date (object2);
       console.log (typeof dateconv);
       console.log (typeof dateconv.getMonth());
      console.log( typeof object2);
        $( this).datepicker( "option", "altFormat", "96-11-29" );
        var altFormat = $( this ).datepicker( "option", "altFormat" );
        document.getElementById("dateselected").innerHTML = object2;

        
    }
});
    
        
        
        
    </script>-->
   
   
 
 
  
<span id="dateselected"> date selected is </span><br><br><br><br><br><br>

    <label> choose the time of your event </label>
    <p>
    <input id="hours" name="value" value=0 size=3/>
    <input id="minutes" name="value" value=0  size=2/>
    <input id="seconds" name="value" value=1 size=2/>
</p>
    <label> choose the length of your event </label>
    
     <p>
    <input id="durhours" name="value" value=0 size=3/>
    <input id="durminutes" name="value" value=0  size=2/>
    <input id="durseconds" name="value" value=1 size=2/>
</p>
    
    
    
    
    
    <h4>event title </h4><textarea name = "content" id = "eventtitle" ></textarea>
        <h4>event detail </h4><textarea name = "detail" id = "eventdetail" ></textarea>
       <h4>enter calendar id that want to add to </h4> <input type="text" name="desiredcalid" id="desiredcalid"/>
        
        
        
            <div class='example'>   
Start Date: 
<input class="datepicker" id = "haha" data-bind='datepicker: startDate' />                    
<select data-bind="options: hourOptions, optionsText: formatTimeOption, value: startDateHour"></select>
<select data-bind="options: minuteOptions, optionsText: formatTimeOption, value: startDateMinute"></select>
<p>Selected date: <span data-bind='text: startDate'></span></p>
</div>
            
            
            <label> now i have a date time picker and the date selected is </label>
            <span id= "datetimedateselected"  value="" >  </span>
            
            <label > and the hour selected is </label>
             <span id= "datetimehourselected"  >  </span>
            
     <button onclick="submitEvent()">submitevent</button>
    
    <script type="text/javascript">
         $(function () {
            // hour, minnute, second are number ,
            
            
     $('#seconds').spinner({
        
       
         spin: function (event, ui) {
            
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#minutes').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#minutes').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#minutes').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#hours').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#hours').spinner('stepDown');
                 return false;
             }
            
         }

     });
     $('#hours').spinner({
         min: 0});
     
     $('#seconds').spinner({change: function( event, ui ) {   }});
     $('#minutes').spinner({change: function( event, ui ) {   }});
     $('#hours').spinner({change: function( event, ui ) {   }});
 });
         
         
                 $(function () {
            // hour, minnute, second are number ,
            
            
     $('#durseconds').spinner({
        
       
         spin: function (event, ui) {
            
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#durminutes').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#durminutes').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#durminutes').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#durhours').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#durhours').spinner('stepDown');
                 return false;
             }
            
         }

     });
     $('#durhours').spinner({
         min: 0});
     
     $('#durseconds').spinner({change: function( event, ui ) {   }});
     $('#durminutes').spinner({change: function( event, ui ) {   }});
     $('#durhours').spinner({change: function( event, ui ) {   }});
 });
         
         
         
       
    </script>
    

      
       
      <script type="text/javascript">
        
        
        
      //  var currentMonth = new Month(2016, 7);
        // these are labels for the days of the week
cal_days_labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// these are human-readable month name labels, in order
cal_months_labels = ['January', 'February', 'March', 'April',
                     'May', 'June', 'July', 'August', 'September',
                     'October', 'November', 'December'];

// these are the days of the week for each month, in order
cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

Calendar.prototype.generateHTML = function(){

  // get first day of month
  var firstDay = new Date(this.year, this.month, 1);
  var startingDay = firstDay.getDay();
  
  // find number of days in month
  var monthLength = cal_days_in_month[this.month];
  
  // compensate for leap year
  if (this.month == 1) { // February only!
    if((this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0){
      monthLength = 29;
    }
  }
  
  // do the header
  var monthName = cal_months_labels[this.month]
  var html = '<table class="calendar-table">';
  html += '<tr><th colspan="7">';
  html +=  monthName + "&nbsp;" + this.year;
  html += '</th></tr>';
  html += '<tr class="calendar-header">';
  for(var i = 0; i <= 6; i++ ){
    html += '<td class="calendar-header-day">';
    html += cal_days_labels[i];
    html += '</td>';
   // html += '<td> "&nbsp;"  </td>'
  }
  html += '</tr><tr>';

  // fill in the days
  var day = 1;
  // this loop is for is weeks (rows)
  for (var i = 0; i < 6; i++) {

    // this loop is for weekdays (cells)
    for (var j = 0; j <= 6; j++) { 
      html += '<td class="calendar-day" id = "j" >';
      if (day <= monthLength && (i > 0 || j >= startingDay)) {
        html += day;
    html+='</td>';
        day++;
        
       //  html+='<td><button onclick="loadCal()">loadCalendar</button></td>';
      }
 
    
    }
    
    
    html += '</tr><tr>   '   ;
    for (var z = 0; z<=6;z++){
        html+='<td><label> hello </label></td>';
    }
  html += '</tr><tr>   '   ;
    // stop making rows if we've run out of days
    if (day > monthLength) {
      break;
    } else {
      html += '</tr><tr>';
    }
    
    
    
    
  }
  html += '</tr></table>';

  this.html = html;
}

Calendar.prototype.getHTML = function() {
  return this.html;
}
Calendar.prototype.nextMonth = function(){

    return nextCal;
}


        </script>
      
      
      <script type="text/javascript">
  var cal = new Calendar(6,2016);

   document.addEventListener("DOMContentLoaded",cal.generateHTML(), false );
 
  document.getElementById("currentcal").innerHTML=cal.getHTML();

</script>

</body>
</html>

