<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","guyerr-db","p0qhxwuK81XS0f5r", "guyerr-db");
	if($mysqli->connect_errno){
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if(!$_SESSION['username']){
		header('Location: Login2.php');
	}
?>
<html>
<head>
<title>Rotten Banana</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

</head>

<body style="background-color:lightgray">
<h6 style= "text-align:right"><a href = "Login2.php?logout">Logout</a></h6>

<h1 style="color:red;text-align:center"> Welcome <?php echo $_SESSION['username'];?>!</h1>

<p style="color:;text-align:left; font-size:150%"> This website is designed to allow you to review movies and share those movies with the world. You also have the ability to keep your reviews private if you wish. I hope you enjoy using the program.</p>
<form action="SuccessfulLogin.php" method ="post" enctype="multipart/form-data">
	<table border ='0'>
		<tr>
			<td>Movie Title: </td>
			<td> <input type="text" name="MovieTitle"></td>
		</tr>
		<tr>
			<td>Category: </td>
			<td> <input type="text" name="Category"></td>
		</tr>
		<tr>
			<td>Review: </td>
			<td> <textarea rows="3" cols="40" name="Review"></textarea>
		</tr>
		<tr>
			<td>Rating: </td>
			<td> <select name="Rating">
				<Option>1 Star</Option>
				<Option>2 Star</Option>
				<Option>3 Star</Option>
				<Option>4 Star</Option>
				<Option>5 Star</Option>
			</select></td>
		</tr>

		<tr>
			<td>Share: </td>
			<td> <select name="Share">
				<Option>Yes</Option>
				<Option>No</Option>
			</select></td>
		</tr>
		<tr>
			<td>Add Image: </td>
			<td>
			<input type = "file" name = "image">
			</td>
		</tr>
		<tr>
			<td>
			<input type = 'Submit' name="AddReview" value= "Add Review">
			</td>
		</tr>

	</table>
</form>

<?php
if(isset($_POST['MovieTitle'])){
	if(!empty($_POST['MovieTitle']) && !empty($_POST['Review'])){
?>

<script>
	var TempMovie = "<?php echo $_POST['MovieTitle'];?>";
	window.alert(TempMovie);

</script>

    <script>
//Code for pulling web link from Rotten Tomatoes
var apikey = "t9esf5ws3mcqbcxpcedmy57s";
var baseUrl = "http://api.rottentomatoes.com/api/public/v1.0";

// construct the uri with our apikey
var moviesSearchUrl = baseUrl + '/movies.json?apikey=' + apikey;
var query = TempMovie;
//window.alert(TempMovie);
$(document).ready(function() {

  // send off the query
  $.ajax({
    url: moviesSearchUrl + '&q=' + encodeURI(query),
    dataType: "jsonp",
    success: searchCallback
  });
});

// callback for when we get back the results
function searchCallback(data) {
 var movies = data.movies;
 $.each(movies, function(index, movie) {

  if(movie.title == TempMovie){
   $(document.body).append('<a href="'+movie.links.alternate+'">Link to the most recent movie you added to the database.</a>');
  }
 });
}
</script>

<?php 
		$Username = $_SESSION['username'];
		$MovieTitle = $_POST['MovieTitle'];
		$Category = $_POST['Category'];
		$Review = $_POST['Review'];
		$Rating = $_POST['Rating'];
		$Share = $_POST['Share'];
			if($Share == "Yes"){
				$Share = 1;
			}
			else{
				$Share = 0;
			}
		$file = $_FILES['image']['tmp_name'];

		if(!($stmt = $mysqli->prepare("INSERT INTO reviews (username, moviename, share, category, rating, review) VALUES (?,?,?,?,?,?)"))){
			echo "prepare failed";
		}
		if(!($stmt->bind_param('ssisss',$Username, $MovieTitle, $Share, $Category, $Rating, $Review))){
			echo "bind failed";
		}
		if(!($stmt->execute())){
			echo "execute failed";
		}
	
		if($file != NULL){
			$image = file_get_contents($_FILES['image']['tmp_name']);
			$image_name = $_FILES['image']['name'];
			$image_size = getimagesize($_FILES['image']['tmp_name']);

		if($image_size == False){
				echo "That file you included is not an image";
			}
			else{
				$InsertImg = "UPDATE reviews SET image ='$image' WHERE moviename = '$MovieTitle'";
				mysqli_query($mysqli, $InsertImg);
			}
		}
	}
	else{
		echo "<p style='color:red'>You must enter something into the Movie Title and Review box for a review to be submitted</p>";
		echo"<br />";
	}
}
?>

<?php
	$Username = $_SESSION['username'];
	$sql = "SELECT username, moviename, category, rating, review FROM reviews WHERE (username = '$Username' OR share=1) AND rating!=11";
	$searchdata = mysqli_query($mysqli, $sql);
	echo"<h3 style='text-align:center'>Here are your reviews (This includes shared reviews):</h3>";

	while($row = mysqli_fetch_array($searchdata)){
	echo"<div style='margin-left:15%;'><u><em>Review provided by: </em><strong style='color:red'>".$row['username']."</u></strong></div>";
	echo "<table style='background-color:green; border:5px solid black; width:70%; margin-left:15%; table-layout:fixed' >";
		$Website = "http://www.google.com";
//		echo"<tr><td>Review provided by: ".$row['username']."</td></tr>";
		echo "<tr>";
		echo "<td style='width: 50%; word-wrap: break-word'>Movie Title: <strong>".$row['moviename']."</strong></td>";
		echo "<td>Rating: ".$row['rating']."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='width: 50%; word-wrap: break-word'>Category: ".$row['category']."</td>";
		echo "<td>Website: <a href=\"$Website\">Website</a></td>";
		echo "</tr>";
		echo "<tr><td>Review:</td></tr>";
		echo "<tr style='color:yellow'><td>".$row['review']."</td></tr>";
		echo "</table>";
	echo "<br /> <br />";
	}
?>
</body>
</html>


