<?php
	/*
		Stephen Hung
		CSE 154 AD
		logout.php logs out the user by unsetting the session variables and going back to 
		start.php.
	*/
	session_start();
	session_unset();
	// unsets all variables in the $_SESSION global array and redirects
	// towards start.php.
	header('Location: start.php');
	die();	
?>