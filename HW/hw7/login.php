<!--
	Stephen Hung
	CSE 154 AD
	login.php is a PHP page that checks if the user entered the correct user name and password
	in order to log in. If not, they are redirected torwards start.php and start.php page displays
	an error message.
	Furthermore, if the user logs in with a user name and password thats not stored on the server
-->
<?php
	// This if statement is to determine that the passed in name & password
	// actually exist.
	if(($_POST['name'] && $_POST['password'])){
		$user_file = file('users.txt');
		$name = $_POST['name'];
		$password = $_POST['password'];
		$user_exists = false;
		// If they do, start checking if they are stored on the database and if not
		// flag that they don't exist.
		foreach($user_file as $login){
			$user_exists = parseLoginInfo($user_exists, $login,$name,$password);
		}
		if(!$user_exists){
			// If the user doesn't exists, check if their user/pass matches regex.
			$user_regex = "/[a-z]([a-z0-9]{2,7})\$/";
			$pass_regex = "/[0-9].{4,10}\W\$/";
			if(preg_match($user_regex, $name) && preg_match($pass_regex, $password)){
				// If they match the regex, add them to the text file and go to
				// todolist.php.
				$new_login = "\n" . $name . ":" . $password;
				file_put_contents('users.txt', $new_login, FILE_APPEND);
				enterTodo($name);
			}else{
				// user or password doesn't match regex.
				incorrectLogin("Username or Password does not match specified guidelines.");
			}
		}
	}else{
		// (no user or no password or both not entered).
		header("Location: start.php");
		die();
	}

	// This function parses the login info (user and password)
	// by checking if the logins are equal to the passed in name & password.
	// If the user is the same but the password is different, it raises an error.
	function parseLoginInfo($user_exists, $login,$name,$password){
		list($user, $pass) = explode(':',$login);
		$pass = trim($pass);
		$user = trim($user);
		if($name === $user){
			$user_exists = true;
			if($password === $pass){
				// password works.
				enterTodo($name);
			}else{
				// Correct user but password doesn't work.
				incorrectLogin("Incorrect password.");
			}
		}
		return $user_exists;
	}

	// If there was an in correct login, set a flag in the $_SESSION global array
	// and redirect to the start.php.
	function incorrectLogin($errorMessage){
		session_start();
		$_SESSION['incorrect_login'] = $errorMessage;
		header("Location: start.php");
		die();
	}

	// If everything ran fine, record the current time as the last login cookie and
	// the user's username.
	// Then redirect towards todolist.php
	function enterTodo($name){
		session_start();
		setcookie('lastlogin', date("D y M d, g:i:s a"), time() + 604800);
		$_SESSION['user'] = $name;
		header('Location: todolist.php');
		die();
	}

?>