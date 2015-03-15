<?php

	$password = $_POST['password'];

	if($password == NULL){
	//	echo "Enter Password"; 
	}
	else if(strlen($password)<8){
		echo "Password too short";
	}
	else{
		echo "Password acceptable";
	}

?>
