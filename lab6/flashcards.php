<?php
		
	$dir = "/www/html/cse154/services/flashcards";
	if(isset($_GET["mode"])){
		if($_GET["mode"] == "categories"){
			$dir = $dir."/*";
			foreach(glob($dir) as $file){
				?>
				<li>
					<?=$file?>
				</li>
				<?php
			}
		}
	}else{
		$xmldoc = new DOMDocument();
		$cardtag = $xmldoc->createElement("card");
		$xmldoc->appendChild($cardtag);

		$dir = $dir."/pokemon";
		$test = glob($dir."/*.txt");
		$randFile = array_rand($test,1);
		$fileArray = file($test[$randFile]);
		$questiontag = $xmldoc->createElement("question");
		$questionText = $xmldoc->createTextNode($fileArray[0]);
		$questiontag->appendChild($questionText);
		$answertag = $xmldoc->createElement("answer");
		$answerText = $xmldoc->createTextNode($fileArray[1]);
		$answertag->appendChild($answerText);
		$cardtag->appendChild($questiontag);
		$cardtag->appendChild($answertag);
		header("Content-type: text/xml");
		print $xmldoc->saveXML();		
	}
?>


