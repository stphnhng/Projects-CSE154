(function(){
	"use strict";
window.onload = function (){
		var button = document.getElementById('validate');
		button.onclick = changeColor
	}

function changeColor(){
	var textBox = document.querySelectorAll('#formtovalidate div input');
	for(var i = 0; i < textBox.length; i++){
		var item = textBox[i];
		item.style.background = "";
		if(item.value == ""){
			item.style.backgroundColor = "red";
		}
		
	}
}
}());