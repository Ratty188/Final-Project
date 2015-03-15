<?php

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","guyerr-db","p0qhxwuK81XS0f5r", "guyerr-db");
	if($mysqli->connect_errno){
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$username = $_POST['username'];

	$check = $mysqli->query("SELECT username FROM reviews WHERE username = '$username'");
	$check_num_rows = mysqli_num_rows($check);

	if($username == NULL){
		//echo "Enter a username";
	}
	else if(strlen($username)<5){
		echo "The username you have entered is not long enough";
	}
	else{
		if($check_num_rows == 0){
			echo "That username is avaliable";
		}
		else{
			echo "That username is NOT avaliable";
		}
	}
?>
