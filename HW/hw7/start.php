<!--
	Stephen Hung
	CSE 154 AD
	Start.php is a php page that displays the "Remember The Cow" website.
	It allows the user to login to access their to do list and make an account
	if they don't already have one.
-->
<?php
	include 'common.php';
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
		// displays the top HTML bar.
		displayTopBar();
?>

		<div id="main">

<?php
			session_start();
			// Starts Session in order to check if there was an error logging in.
			if(isset($_SESSION['incorrect_login'])){
?>
			<div class="own_error" id="error">
				<p><?=$_SESSION['incorrect_login']?></p>
			</div>
<?php
				unset($_SESSION['incorrect_login']);
			}
?>

			<p>
				The best way to manage your tasks. <br />
				Never forget the cow (or anything else) again!
			</p>

			<p>
				Log in now to manage your to-do list. <br />
				If you do not have an account, one will be created for you.
			</p>

			<form id="loginform" action="login.php" method="post">
				<div><input name="name" type="text" size="8" autofocus="autofocus" /> <strong>User Name</strong></div>
				<div><input name="password" type="password" size="8" /> <strong>Password</strong></div>
				<div><input type="submit" value="Log in" /></div>
			</form>
<?php
			// If someone has logged in using this browser, display the time they did it.
			if(isset($_COOKIE['lastlogin'])){
?>
			<p>
				<em>(last login from this computer was <?=$_COOKIE['lastlogin']?>)
				</em>
			</p>
<?php
			}
?>
		</div>

<?php
		// displays the bottom HTML bar.
		displayBottomBar();
?>
	</body>
</html>
