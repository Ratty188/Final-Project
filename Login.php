<html>
<?php

ini_set('display_errors', 'On');

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","guyerr-db","p0qhxwuK81XS0f5r", "guyerr-db");
if($mysqli->connect_errno){
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else{
//	echo "Connection worked!<br>";
}

$create_table = "CREATE TABLE reviews(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
							username VARCHAR(255),
							password VARCHAR(255),
							share INT,
							moviename VARCHAR(255),
							category VARCHAR(255),
							rating VARCHAR(255),
							review VARCHAR(255),
							image BLOB)";

$create_tbl = $mysqli->query($create_table);
?>

<head>
 <title> CS 290 Final Project</title>
 <script type = "text/javascript" src="jquery-1.11.2.min.js"></script>

 <script type = "text/javascript">
  $(document).ready(function(){
    $('#usernamecheck').load('checkusernamer.php').show();

    $('#Username_Input').keyup(function(){
      $.post('checkusernamer.php', {username:LoginForm.Username.value}, function(result){
	$('#usernamecheck').html(result).show();
      });
    });
  });

  $(document).ready(function(){
    $('#passwordcheck').load('checkpasswordr.php').show();

    $('#Password_Input').keyup(function(){
      $.post('checkpasswordr.php', {password:LoginForm.Password.value}, function(result){
	$('#passwordcheck').html(result).show();
      });
    });
  });
 </script>

 <script type = "text/javascript">
  $(document).ready(function(){
    $('#Register').click(function(){
	username = $("#Username").val();
	password = $("#Password").val();
	action = "register";

	if(username.length<4){
		$("#alert").html("Your username is not long enough");
	}
    });
});

</script>

</head>

<body style="background-color:lightgray">
<h2 style="text-align:center; color:blue; font-family:fantasy">Registration for Rotten Banana</h2>
 <form name="LoginForm" action="Login.php" method="POST" style="text-align:center">
   Username: <br/>
   <input type = "text" placeholder="Username" id="Username_Input" name="Username">
   <div id="usernamecheck"></div>
 
   Password: <br/>
   <input type = "password" Placeholder="Password" id="Password_Input" name="Password">
   <br/>
   <div id="passwordcheck"></div>
   <input type="submit" name="Register" value="Register" id="Register">
</form>

<div style="text-align:center"><a href="Login2.php">Click Here for Login Page</a></div>

<?php
if(isset($_POST['Username']) && isset($_POST['Password'])){
	$username = $_POST['Username'];
	$password = $_POST['Password'];
	$rating = 11;

	$Userexists = mysqli_query($mysqli,"SELECT * FROM reviews WHERE username ='$username'");

	if(mysqli_num_rows($Userexists) > 0){
		echo "<p style='color:red; text-align:center'><strong>Username Already Exists</strong></p>";
	}
	else if(strlen($username)<4 || strlen($password)<8){
		echo "<p style='color:red; text-align:center'><strong>Username or Password - Incorrect Format</strong></p>";
	}
	else{
		if(!($stmt = $mysqli->prepare("INSERT INTO reviews (username, password, rating) VALUES (?,?,?)"))){
			echo "prepare failed";
		}
	
		if(!($stmt->bind_param('ssi', $username, $password, $rating))){
			echo "Binding failed";
		}
	
		if(!($stmt->execute())){
			echo "Execute failed";
		}
		
		echo "<p style='color:red; text-align:center'><strong>User Registered - Use Login Page to Login</strong></p>";
	}
}
?>



</body>
</html>
