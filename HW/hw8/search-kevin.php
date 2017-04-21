<!--
	Stephen Hung
	CSE 154 AD
	search-kevin.php is a PHP page that searches for movies that a specified actor & kevin bacon
	have both starred in.
-->
<!DOCTYPE html>
<?php
	include 'common.php';
	// If the parameters are there for the first & last name.
	if(isset($_GET["firstname"]) && isset($_GET["lastname"]) ){
		$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "hungs3", "T7vmFfgdDS");
		$first_name = $_GET["firstname"];
		$last_name = $_GET["lastname"];
		// Finds the actor id for both the specified actor & kevin bacon.
		$actor_id = findActorID($first_name, $last_name, $db);
		$kevin_id = findActorID('kevin','bacon',$db);
		getKevinMovies($first_name, $last_name, $kevin_id, $actor_id, $db);
		printEnd();
	}

	// This function gets the movies that both the specified actor & kevin bacon have acted in.
	function getKevinMovies($first_name, $last_name, $kevin_id, $actor_id, $db){
		// query to only select movies where they have both starred in.
		$query = "SELECT m.name, m.year FROM roles r
			JOIN movies m ON r.movie_id = m.id
			JOIN roles r2 ON (r2.movie_id = m.id) 
			WHERE r.actor_id = $kevin_id AND (r2.actor_id = $actor_id)
			ORDER BY m.year DESC,m.name ASC";
		$kevin_response = $db->query($query);
		if($kevin_response->rowCount() > 0){
			// Make sure that the response makes sense and then creates a table with the 
			// provided information.
			$counter = 1;
			setTitle($first_name,$last_name);
			getTableHeader($first_name,$last_name,false);
			foreach($kevin_response as $row){
				displayTableRow($counter,$row); 
				$counter = $counter + 1;
			}?>
			</tbody>
			</table>
<?php
		}else{
			// If there were no films with the specified actor & kevin bacon.
?>
			<p>
				<?=$first_name." ".$last_name?>  wasn't in any films with Kevin Bacon.
			</p>
<?php
		}
	}


?>