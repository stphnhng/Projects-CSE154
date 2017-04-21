<!--
	Stephen Hung
	CSE 154 AD
	search-all.php is a PHP page that searches for movies that a specified actor has starred in.
-->
<!DOCTYPE html>
<?php
	include 'common.php';
	// If the parameters are there for the first & last name.
	if(isset($_GET["firstname"]) && isset($_GET["lastname"]) ){
		$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "hungs3", "T7vmFfgdDS");
		$first_name = $_GET["firstname"];
		$last_name = $_GET["lastname"];
		$id = findActorID($first_name,$last_name,$db);
		// gets the movies that the actor has been in.
		getActorMovies($first_name, $last_name, $id,$db);
		printEnd();
	}

	// function that gets the movies that the specified actor has starred in.
	function getActorMovies($first_name, $last_name, $id, $db){
		// query that selects movies that the acor has starred in ordered in descending order
		// by year & ascending order by name.
		$query = "SELECT m.name,m.year FROM actors a 
			JOIN roles i ON a.id = i.actor_id
			JOIN movies m ON m.id = i.movie_id
			WHERE a.id = $id 
			ORDER BY m.year DESC, m.name ASC";
		$movie_table = $db->query($query);
		if($movie_table->rowCount() > 0){
			// If the response makes sense, create a table containing the data
			// that was sent back from the SQL query.
			$counter = 1;
			setTitle($first_name,$last_name);
			getTableHeader($first_name,$last_name,true);
			foreach($movie_table as $row){
				displayTableRow($counter,$row);
				$counter = $counter + 1;
			}?>
			</tbody>
			</table>
<?php
		}else{
			// If the actor wasn't found in the SQl database.
?>
			<p>
				Actor <?=$first_name." ".$last_name?> not found.
			</p>
<?php
		}
	}
?>	