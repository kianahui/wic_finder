<script>
$(".fancypdf").fancybox({
                'frameWidth': 680,
                'frameHeight':495,
                'overlayShow':true,
                'hideOnContentClick':false,
                'type':'iframe'
});
</script>

<?php
// doLookup.php: maps State in $_GET['state'] to agencies

$State = $_GET['state'];
$con = mysqli_connect("localhost", "root");
mysqli_select_db($con, "mydb");

$sql="SELECT Link FROM foodList WHERE State = '".$State."';"; 
$result=mysqli_query($con, $sql); 

while ($row=mysqli_fetch_array($result)) { 
	$Link=$row["Link"]; 
	if ($Link != "") {
<<<<<<< HEAD
		echo "<iframe src=\"$Link\"  width=\"395\" height=\"195\"> </iframe> "
		echo "<a class=\"fancypdf\" href = \"$Link\" target=\"_blank\">Click to access " . $State . "'s food list!</a>";
=======
		echo "<a href = \"$Link\" target=\"_blank\">Click to access " . $State . "'s food list!</a>";
>>>>>>> f67c7c026bb80befcc6cd43ec9d280a58b585cf5
	} else {
		echo "No known food list yet. Don't worry. We're working on it!";
	}
} 

mysqli_close($con);
?>
