(function(){

	window.onload = function(){
		jsonParse();
	};

	function jsonParse(){
		var student = {
			name: "Austin Weale",
			school: "University of Washington",
			classes: [
				{className: "CSE154", credits: 5},
				{className: "CSE142", credits: 4},
				{className: "CSE143", credits: 5}
			]
		}
		var classes = student.classes;
		var sum = 0;
		for(var i = 0; i < classes.length; i++){
			sum+= parseInt(classes[i].credits);
		}
		var result = student.name + ", " + student.school + ", " + sum + " credits";
		console.log(result);
	}

})();