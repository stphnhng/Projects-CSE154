<!--
	Stephen Hung
	CSE 154 AD
	common.php is a PHP page for saving common functions & lines.
-->
<!DOCTYPE html>
<?php
	// Displays the top HTML bar.
	function displayTopBar(){
?>
	<div class="headfoot">
			<h1>
				<img src="https://webster.cs.washington.edu/images/todolist/logo.gif" alt="logo" />
				Remember<br />the Cow
			</h1>
	</div>
<?php
	}

	// Displays the bottom HTML bar.
	function displayBottomBar(){
?>
	<div class="headfoot">
			<p>
				<q>Remember The Cow is nice, but it's a total copy of another site.</q> - PCWorld<br />
				All pages and content &copy; Copyright CowPie Inc.
			</p>

			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php">
					<img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php">
					<img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
	</div>
<?php
	}





?>