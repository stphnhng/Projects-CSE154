<?php
/*
		Stephen Hung
		CSE 154 AD
		PHP page for bestreads.html, this php page handles requests
		for different types of modes (info, description, revies, and books).
		It also takes in an additional parameter in the form of title.
		This PHP page returns information such an XML doc containing all the books,
		a JSON response with the book's title, review author, and review, information
		about the book, and a description of the book.
	*/
	
	// Default directory for hw6.
	$dir = "/www/html/students/hungs3/hw6";

	// If the mode & title parameters are in the request.
	if(isset($_GET["mode"]) && isset($_GET["title"])){
		// If/Else statement for the different types of modes.
		if($_GET["mode"] == "info"){
			infoMode($dir,$_GET["title"]);
		}else if($_GET["mode"] == "description"){
			descriptionMode($dir,$_GET["title"]);
		}else if($_GET["mode"] == "reviews"){
			reviewsMode($dir,$_GET["title"]);
		}
	}else if( isset($_GET["mode"]) ){
		// If there is only a mode in the request.
		if ($_GET["mode"] == "books"){
			// Check if the mode is "book".
			bookMode($dir);
		}
	}

	// Create and print/return a JSON file for the specified book.
	// The JSON file contains information such as the title, author, and rating.
	// This information is taken from info.txt.
	function infoMode($dir,$title){
		$dir = $dir . "/books/" . $title . "/info.txt";
		list($title,$author,$stars) = file($dir);
		// Takes in the title, author, and # of stars and creates a JSON
		// file to print.
		$jsonBookInfo = new stdClass();
		$jsonBookInfo->title = $title;
		$jsonBookInfo->author = $author;
		$jsonBookInfo->stars = $stars;
		print json_encode($jsonBookInfo);
	}

	// Prints/Returns the description of the book from description.txt
	// in the book's folder.
	function descriptionMode($dir,$title){
		$dir = $dir . "/books/" . $title . "/description.txt";
		$descriptioncontent = file_get_contents($dir);
		print $descriptioncontent;
	}

	// Prints/Returns all reviews for the specified book.
	// This function returns it in HTML format such that it follows the assignment's
	// guidelines.
	function reviewsMode($dir,$title){
		$dir = $dir . "/books/" . $title . "/review*.txt";
		foreach(glob($dir) as $review){
			list($author,$score,$review) = file($review);
			// Prints HTML formatted info (author, score, and review).
			print "<h3>".$author."<span>".$score."</span></h3>";
			print "<p>".$review."</p>";
		}
	}

	// Prints/Returns an XML sheet that contains all the books in the hw6 folder.
	// The tags for each book contain their title & the folder they are in.
	function bookMode($dir){
		$dir = $dir . "/books/*";
		$xmldoc = new DOMDocument();
		$books_tag = $xmldoc->createElement('books');
		$xmldoc->appendChild($books_tag);
		foreach(glob($dir) as $file){
			// For each book folder, generate an XML tag for that book and
			// append it to the XML sheet.
			$book_tag = generateBookXML($file,$xmldoc);
			$books_tag->appendChild($book_tag);
		}
		header("Content-type: text/xml");
		print $xmldoc->saveXML();
	}


	// Create an XML tag for each book specified and returns it.
	// The XML tag contains the title & folder for each book.
	function generateBookXML($file,$xmldoc){
		$book_tag = $xmldoc->createElement('book');
		// Creates tags for the title & folder and adds it to the
		// general book tag.

 		$file_content = file($file."/info.txt");
 		$title_tag = $xmldoc->createElement('title');
 		$title_text = $xmldoc->createTextNode($file_content[0]);
 		$title_tag->appendChild($title_text);

		$folder_tag = $xmldoc->createElement('folder');
		$foldername = substr($file, strrpos($file,"/")+1);
		$folder_text = $xmldoc->createTextNode($foldername);
		$folder_tag->appendChild($folder_text);

		$book_tag->appendChild($title_tag);
		$book_tag->appendChild($folder_tag);
		return $book_tag;
	}
?>