// CSE 154 Ajax section pre-problem
// You should complete this file.
// Your code must be run on the Webster server (not on your local computer).

window.onload = function() {
	document.getElementById("go").onclick = goClick;
};

function goClick() {
	// write your solution here!
	// Your code needs to connect to: https://webster.cs.washington.edu/cse154/sections/9/horoscope-server.php
	var monthInput = document.getElementById('month');
	monthInput = monthInput.value;
	var dayInput = document.getElementById('day');
	dayInput = dayInput.value;

	var url = "https://webster.cs.washington.edu/cse154/sections/9/horoscope/horoscope-server.php?month=" + monthInput + 
	"&day=" + dayInput;
	var ajax = new XMLHttpRequest();
	ajax.onload = ajaxLoad;
	ajax.open("GET",url,true);
	ajax.send(monthInput,dayInput);
}

function ajaxLoad(){
	var results = document.getElementById('results');
	results.innerHTML = this.responseText;
}
