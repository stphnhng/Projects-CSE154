<!--
	Stephen Hung
	CSE 154 AD
	common.php is a php file containing all common HTML & php code for the other php files.
	It provides functionality such as making table headers, table rows, and setting the
	table's title.
-->
<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />
		<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" 
		type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
</head>
<body>
		<div id="frame">
			<div id="banner">
				<a href="mymdb.php">
					<img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" 
					alt="banner logo" />
				</a>
				My Movie Database
			</div>
<?php
	// A function for creating the HTML necessary to make a title for the table.
	function setTitle($first_name, $last_name){
?>
			<h1>
				Results for <?=$first_name . ' ' . $last_name ?>
			</h1>
<?php
	}

	// A function for displaying each table's row using HTML.
	function displayTableRow($counter, $row){
?>
		<tr>
			<td>
				<?=$counter?>
			</td>
			<td>
				<?=$row['name']?> 
			</td>
			<td>
				<?= $row['year']?> 
			</td>
		</tr>
<?php
	}

	// A function to find an actor's id given their first and last name.
	function findActorID($first_name, $last_name,$db){
		$first_name = $db->quote($first_name . '%');
		$last_name = $db->quote($last_name);
		// Query discovers an actor whos last name is exactly the same but the 
		// first name can start with text typed by the user.
		$query="SELECT id,film_count FROM actors
			WHERE last_name = $last_name AND first_name LIKE $first_name";

		$id_response = $db->query($query);
		if($id_response->rowCount() > 0){
			// Makes sure the response made sense and then gets the ID of the actor,
			// tie breaking with most movies & lower numbered ID.
			$id_Array = array();
			foreach($id_response as $row){
				$id_Array[$row['id']]= $row['film_count'];
			}
			$max_Keys = array_keys($id_Array,max($id_Array));
			$finalId = (min($max_Keys));
			return $finalId;
		}
		// returns nonsense number to demonstrate that the actor was not found.
		return -999;
	}

	// Function that prints out the table's header & caption.
	function getTableHeader($first_name, $last_name, $allBool){
		$title = 'Films with ' . $first_name . ' ' . $last_name . ' and Kevin Bacon.';
		if($allBool){
			$title = 'All Films';
		}
?>
		<table>
			<caption>
				<?=$title?>
			</caption>
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Year</th>
				</tr>
			</thead>

			<tbody>
<?php
	}

	// Prints the bottom of the HTML page (w3c validators & forms).
	function printEnd(){
?>
		<!-- form to search for every movie by a given actor -->
		<form action="search-all.php" method="get">
			<fieldset>
				<legend>All movies</legend>
				<div>
					<input name="firstname" type="text" size="12" placeholder="first name" 
					autofocus="autofocus" /> 
					<input name="lastname" type="text" size="12" placeholder="last name" /> 
					<input type="submit" value="go" />
				</div>
			</fieldset>
		</form>

		<!-- form to search for movies where a given actor was with Kevin Bacon -->
		<form action="search-kevin.php" method="get">
			<fieldset>
				<legend>Movies with Kevin Bacon</legend>
				<div>
					<input name="firstname" type="text" size="12" placeholder="first name" /> 
					<input name="lastname" type="text" size="12" placeholder="last name" /> 
					<input type="submit" value="go" />
				</div>
			</fieldset>
		</form>

		<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php">
					<img src="https://webster.cs.washington.edu/images/w3c-html.png" 
					alt="Valid HTML5" />
				</a>
				<a href="https://webster.cs.washington.edu/validate-css.php">
					<img src="https://webster.cs.washington.edu/images/w3c-css.png" 
					alt="Valid CSS" />
				</a>
			</div>
		</div> <!-- end of #frame div -->
</body>

<?php
	}
?>
			