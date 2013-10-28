<?php
// doLookup.php: maps State in $_GET['state'] to agencies

$State = $_GET['state'];
$con = mysqli_connect("localhost", "root");
mysqli_select_db($con, "mydb");

$sql="SELECT Agency FROM foodList WHERE State = '".$State."';"; 
$result=mysqli_query($con, $sql); 

echo "<select name=\"agency\" id =\"agencydropdown\">";
echo "<option value=\"\">Please select your agency</option>";

while ($row=mysqli_fetch_array($result)) { 
	$Agency=$row["Agency"]; 

	if ($Agency !="") {

		$option="<OPTION VALUE=\"$Agency\">$Agency</option>";
		echo $option;
	}
} 

echo "</select>";

mysqli_close($con);


// if (isset($post_offices[$_GET['zip']])
//     echo "Post office: ", $post_offices[$_GET['zip']];
// else
//     echo "Sorry, invalid zip code.";
?>
