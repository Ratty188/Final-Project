<?php

session_start();

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","guyerr-db","p0qhxwuK81XS0f5r", "guyerr-db");
	if($mysqli->connect_errno){
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$Username = $_POST['username'];
	$Password = $_POST['password'];

	$check = $mysqli->query("SELECT username FROM reviews WHERE username = '$Username' AND password = '$Password'");
	$check_num_rows = mysqli_num_rows($check);

	if($Username == NULL || $Password == NULL){
		echo "You Must enter a username and password";
	}
	else{
		if($check_num_rows == 0){
			echo "The login information you entered is incorrect";
		}
		else{
			echo "Correct";
			echo "<br />";
			echo "Click ";
			echo "<a href = 'SuccessfulLogin.php?username=$Username'>Here</a>";
			echo " to continue to the member page";
			$_SESSION['username'] = $Username;	
		}
	}
?>
