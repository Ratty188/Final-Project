<?php
//ob_start();
//ob_end_flush();

if(isset($_GET['logout'])){
	session_start();
	session_destroy();
}
?>

<html>
<head>
	<title> Movie Login</title>
	<script type = "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type = "text/javascript">
	$(function(){
		$('input[type=submit]').click(function(){
			$.ajax({
				type: "POST",
				url: "server.php",
				data: $("#myform").serialize(),
				success: function(data){
					$('#result').html(data);
				}
			});
		});
	})
	</script>
</head>

<body style="background-color : lightgrey">
<h2 style = "color:blue; text-align:center">Login to Rotten Banana</h2>
<form action="SuccessfulLogin.php" method="post" onsubmit="return false;" id="myform" style = "text-align:center">
  <input type = "text" name="username" placeholder="Username">
  <br />
  <input type = "password"  name="password" placeholder="Password">
  <br />
  <input type="submit" name="submit" value="Login">
  <div id="result" style="color:red" ></div>
</form>
<div style="text-align: center; color:red"> Click <a href="Login.php">here</a> to register</div>
</body>
</html>
