<?php

 	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","guyerr-db","p0qhxwuK81XS0f5r", "guyerr-db");
	if($mysqli->connect_errno){
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if(isset($_GET['id'])){
		$id = mysqli_real_escape_string($_GET['id']);
//		$InsertImg = "SELECT * FROM 'reviews' WHERE 'id' ='$id'";
//		$query = mysqli_query($mysqli, $InsertImg);
		$query = mysqli_query("SELECT * FROM 'reviews' WHERE 'id' ='$id'");
		while($row = mysqli_fetch_assoc($query)){
			$imageData = $row["image"];
		}
		header("content-type: image/jpeg");
		echo $imagedata;
	}
	else{
		echo "No Image to Load"
	}

?>
