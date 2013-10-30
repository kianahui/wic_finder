<?php
// doLookup.php: maps State in $_GET['state'] to agencies

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

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

json_encode($Agency);

mysqli_close($con);
?>
