/*
	Stephen Hung
	CSE 154 AD
	Javascript file for bestreads.html.
	This provides the functionality to load all the books onto the home page,
	display the book's information once it is clicked, and go to the home page
	when the home button is clicked.
*/
// Anonymous function following the module pattern.
(function(){
	"use strict";
	// module-global constant variable for the php URL.
	var URL = "https://webster.cs.washington.edu/students/hungs3/hw6/bestreads.php";

	// Anonymous function for when the page loads.
	// This function loads the home page and sets the home button's onclick.
	window.onload = function(){
		loadHome();
		var homeButton = document.getElementById('back');
		homeButton.onclick = loadHome;
	};

	// Lodas the home page by querying the server for the books and
	// setting the single book div to hidden.
	function loadHome(){
		var singleBookDiv = document.getElementById('singlebook');
		singleBookDiv.style.display = "none";
		queryServer("?mode=books",loadBookXML);
	}

	// Loads the information on a specific book as a response
	// to an AJAX request.
	function loadInfo(){
		var jsonText = JSON.parse(this.responseText);
		document.getElementById('title').innerText = jsonText.title;
		document.getElementById('author').innerText = jsonText.author;
		document.getElementById('stars').innerText = jsonText.stars;
	}

	// Loads the description of a book as a response to an AJAX request.
	function loadDescription(){
		var descriptionText = this.responseText;
		document.getElementById('description').innerText = descriptionText;
	}

	// Loads the reviews of a book as a response to an AJAX request.
	function loadReviews(){
		var reviewsHTML = this.responseText;
		document.getElementById('reviews').innerHTML = reviewsHTML;
	}

	// Loads the cover image for a book when needed.
	function loadCoverImage(folderName){
		document.getElementById('cover').src = 
		"https://webster.cs.washington.edu/students/hungs3/hw6/books/" + folderName + "/cover.jpg";
	}

	// Loads the XML doc for each book as a response to an AJAX request.
	// Then it creates divs for each of the books and shows their cover
	// and title in it.
	function loadBookXML(){
		var allBooksDiv = document.getElementById('allbooks');
		allBooksDiv.style.display = "";
		allBooksDiv.innerHTML = "";
		var node = this.responseXML;
		var bookArray = node.querySelectorAll('book');
		for(var i = 0; i < bookArray.length; i++){
			// For each book in the XML doc, create a div with the cover image and title.
			
			var bookURL = "https://webster.cs.washington.edu/students/hungs3/hw6/books/";
			var bookDiv = document.createElement('div');
			bookDiv.onclick = bookClick;
			bookDiv.id = bookArray[i].querySelector('folder').textContent;
			var bookTitle = document.createElement('p');
			var bookImage = document.createElement('img');
			bookImage.setAttribute("alt","cover image");
			var srcPath = bookURL + bookArray[i].querySelector('folder').textContent + 
			"/cover.jpg";
			bookImage.setAttribute("src",srcPath);
			bookTitle.innerText = (bookArray[i].querySelector('title').textContent);
			bookDiv.appendChild(bookImage);
			bookDiv.appendChild(bookTitle);
			document.getElementById('allbooks').appendChild(bookDiv);
		}
	}

	// Event Handler for when a book is clicked.
	// This function querys the server for the information, description, and reviews
	// once the book is clicked.
	function bookClick(){
		document.getElementById('allbooks').style.display = "none";
		document.getElementById('singlebook').style.display = "";
		queryServer("?mode=info&title=" + this.id,loadInfo);
		queryServer("?mode=description&title=" + this.id,loadDescription);
		queryServer("?mode=reviews&title=" + this.id,loadReviews);
		loadCoverImage(this.id);
	}

	// Querys the server for given params & loads a given function once
	// the request is done loading.
	function queryServer(params,onloadFunction){
		var ajax = new XMLHttpRequest();
		ajax.onload = onloadFunction;
		ajax.open("GET",URL + params,true);
		ajax.send();
	}

})();