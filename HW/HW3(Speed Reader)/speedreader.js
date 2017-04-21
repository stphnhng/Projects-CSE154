/*
	CSE 154 AD
	Stephen Hung
	This JavaScript file helps run the logic behind a speed reading website.
	It takes in an input from the user and displays one word at a time in a 
	reading box at varying speeds and sizes.
*/

// Anonymous function to facilitate correct JS style.
(function(){
	"use strict";

	var textBox_Array;
	var textNum = 0;
	var textTimer;

	// Once the window finishes loading, sets onclick and on change
	// of various elements.
	window.onload = function(){
		var radioButtons = document.querySelectorAll('input');
		for(var i = 0; i < radioButtons.length; i++){
			radioButtons[i].onchange = changeSize;
		}
		var startButton = document.getElementById('start_button');
		startButton.onclick = startSpeedReader;
		var selectBox = document.querySelector('select');
		selectBox.onchange = changeSelect;
		var stopButton = document.getElementById('stop_button');
		stopButton.onclick = stopClicked;
		stopButton.disabled = true;
	};

	// Changes the size of displayed text depending on what radio button
	// is clicked.
	function changeSize(){
		var buttonName = this.value;
		var readingBox = document.getElementById('reader');
		if(buttonName == 'Medium'){
			readingBox.className = 'reader_medium';
		}else if(buttonName == 'Big'){
			readingBox.className = 'reader_big';
		}else if(buttonName == 'Bigger'){
			readingBox.className = 'reader_bigger';
		}
	}

	// Stops speed reading once the stop button is clicked.
	function stopClicked(){
		clearInterval(textTimer);
		textTimer = null;
		var startButton = document.getElementById('start_button');
		startButton.disabled = false;
		var stopButton = document.getElementById('stop_button');
		stopButton.disabled = true;
		var readingBox = document.getElementById('reader');
		readingBox.innerText = "";
		textBox_Array = [];
		textNum = 0;
	}

	// Starts speed reading once the start button is clicked.
	function startSpeedReader(){
		var inputBox = document.querySelector('textarea');
		var inputBox_String = inputBox.value;
		var result = inputBox_String.split(/[ \t\n]+/);
		textBox_Array = result;

		var selectBox = document.querySelector('select');
		var currentSelected = selectBox.value;
		var timer = parseInt(currentSelected);
		textTimer = setInterval(changeText,timer);

		disableButtons(true,false);
	}

	// Changes the speed at which words are being shown.
	function changeSelect(){
		if(textTimer !== null){
			clearInterval(textTimer);
			textTimer = null;
			var selectBox = document.querySelector('select');
			var currentSelected = selectBox.value;
			var timer = parseInt(currentSelected);
			textTimer = setInterval(changeText,timer);
		}
	}

	// Helper function to determine if the word contains punctuation.
	function isPunctuation(input){
		var lastChar = input.charAt(input.length-1);
		if((lastChar == ',') || (lastChar == '.') || (lastChar == ';')|| 
			(lastChar == '!') || (lastChar == '?') || (lastChar == ':')){
			return true;		
		}
		return false;
	}

	// Changes the text in the display box.
	function changeText(){
		var readingBox = document.getElementById('reader');
		var currentText = textBox_Array[textNum];
		if(isPunctuation(currentText)){
			currentText = currentText.substring(0,currentText.length-1);
			textBox_Array[textNum] = currentText;
			textBox_Array.splice(textNum,0,currentText);
		}
		textNum++;

		readingBox.innerText = currentText;
		if(textNum >= textBox_Array.length){
			clearInterval(textTimer);
			textTimer = null;
			textNum = 0;
			textBox_Array = [];
			disableButtons(false,true);
		}
	}

	// Disables buttons depending on parameters.
	function disableButtons(start, stop){
		var startButton = document.getElementById('start_button');
		startButton.disabled = start;
		var stopButton = document.getElementById('stop_button');
		stopButton.disabled = stop;
	}

})();