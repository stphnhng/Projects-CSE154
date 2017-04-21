<!--
	Stephen Hung
	CSE 154 AD
	todolist.php is a PHP file that displays the user's todolist.
	Furthermore, users can add and remove specific items by sending a POST request 
	to submit.php.
	When users are done, they can logout which leads them back to start.php.
-->
<?php
	include 'common.php';
	session_start();
	// Checks if a session has been started with a passed in
	// user name.
	// If not, it redirects towards start.php.
	if(!isset($_SESSION['user'])){
		header('Location: start.php');
		die();
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Remember the Cow</title>
		<link href="https://webster.cs.washington.edu/css/cow-provided.css" type="text/css" rel="stylesheet" />
		<link href="cow.css" type="text/css" rel="stylesheet" />
		<link href="https://webster.cs.washington.edu/images/todolist/favicon.ico" type="image/ico" rel="shortcut icon" />
	</head>

	<body>
<?php
		displayTopBar();
?>

		<div id="main">
			<h2><?=$_SESSION['user']."'s"?> To-Do List</h2>
<?php
			// If there has been an error deleting an item.
			if(isset($_SESSION['submit_error'])){
?>
				<div id="error" class="own_error">
					<p><?=$_SESSION['submit_error']?></p>
				</div>
<?php
				unset($_SESSION['submit_error']);
			}

?>
			<ul id="todolist">
<?php
				// Grabs the todolist for the specified user and if it doesn't exist
				// create one for them.
				$file_name = "todo_" . $_SESSION['user'] . ".txt";
				if(!file_exists($file_name)){
					file_put_contents($file_name, "");
				}
				$counter = 0;
				$todolist_contents = file($file_name);
				// For each todo list item in their text file, create a form
				// for them.
				foreach($todolist_contents as $item){
?>
				<li>
					<form action="submit.php" method="post">
						<input type="hidden" name="action" value="delete" />
						<input type="hidden" name="index" value="<?=$counter?>" />
						<input type="submit" value="Delete" />
					</form>
					<?=htmlspecialchars($item)?>
				</li>
<?php
					$counter = $counter + 1;
				}
?>
				<li>
					<form action="submit.php" method="post">
						<input type="hidden" name="action" value="add" />
						<input name="item" type="text" size="25" autofocus="autofocus" />
						<input type="submit" value="Add" />
					</form>
				</li>
			</ul>

			<div>
				<a href="logout.php"><strong>Log Out</strong></a>
<?php
					// If the user has logged in from the browser previously
					// display their log in time.
					if(isset($_COOKIE["lastlogin"])){
?>
					<em>(logged in since <?=$_COOKIE["lastlogin"]?>)</em>
<?php
					}
?>
				
			</div>

		</div>
<?php
		displayBottomBar();
?>
	</body>
</html>
