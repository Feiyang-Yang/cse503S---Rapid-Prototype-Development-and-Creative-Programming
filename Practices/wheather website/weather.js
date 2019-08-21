/*
The structure and fixed expression of the code
come from the examples in Course Wiki of Ajax and JSON
in Module 5
*/

// This is almost the same as getNoteAjax(event) in Course Wiki example
function fetchWeather(event){
	// The XMLHttpRequest is simple this time:
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "https://classes.engineering.wustl.edu/cse330/content/weather_json.php", true);
	xmlHttp.addEventListener("load", dataCallBack, false);
	xmlHttp.send(null);
}

// This is almost the same as getNoteCallback(event) in Course Wiki example
function dataCallBack(event) {
	var jsonData = JSON.parse(event.target.responseText);
	
	let htmlLocationParent = document.getElementsByClassName("weather-loc")[0];
	let htmlTempParent = document.getElementsByClassName("weather-temp")[0];
	let htmlHumiParent = document.getElementsByClassName("weather-humidity")[0];
	let htmlTomorrowParent = document.getElementsByClassName("weather-tomorrow")[0];
	let htmlDayAfterParent = document.getElementsByClassName("weather-dayaftertomorrow")[0];
	
	let tomorrowURL = "http://us.yimg.com/i/us/nws/weather/gr/" + jsonData.tomorrow.code + "ds.png";
	let dayAfterURL = "http://us.yimg.com/i/us/nws/weather/gr/" + jsonData.dayafter.code + "ds.png";
	
	htmlLocationParent.innerHTML = "<strong>" + jsonData.location.city + "</strong> " + jsonData.location.state;
	htmlTempParent.innerHTML = jsonData.wind.chill;
	htmlHumiParent.innerHTML = jsonData.atmosphere.humidity;
	htmlTomorrowParent.src = tomorrowURL;
	htmlDayAfterParent.src = dayAfterURL;
}

document.addEventListener("DOMContentLoaded", fetchWeather, false);
document.getElementById("update").addEventListener("click", fetchWeather, false);