<?php
	/*
		Stephen Hung
		CSE 154 AD
		submit.php is a PHP file that does different actions depending on if the user is 
		adding or deleting an item.
		If the user is adding an item, their item is added to their unique text file.
		If the user is deleting an item, their item is removed from their unique text file.
	*/
	session_start();
	// the action in the POST request has been set.
	if(isset($_POST['action'])){
		$file_name = "todo_" . $_SESSION['user'] . ".txt";
		$action = $_POST['action'];
		// If the action is to delete an item.
		if($action === 'delete'){
			if(isset($_POST['index'])){
				// Check to make sure the index is there.
				$index = $_POST['index'];
				$todolist_contents = file($file_name);
				if(array_key_exists($index,$todolist_contents)){
					// Check to make sure the index is applicable to the
					// current todolist's contents.
					unset($todolist_contents[$index]);
					$new_contents = implode("",$todolist_contents);
					file_put_contents($file_name, $new_contents);
					// removes the specified text and overwrites the todolist.
				}else{
					// If the index is not applicable to the current todolist's
					// contents, submit an error.
					$_SESSION['submit_error'] = "Error Deleting Item";
				}
			}
		}elseif($action === 'add'){
			// If the action is to add an item.
			if(isset($_POST['item'])){
				// Append the item to the text file.
				file_put_contents($file_name, $_POST['item'] . "\n",FILE_APPEND);
			}
		}
	}
	// go back to todolist.php
	header('Location: todolist.php');
	die();
?>