	<?php 
	$Agency = $_GET['agency'];
	$con = mysqli_connect("localhost", "root");
	mysqli_select_db($con, "mydb");

	$sql = "SELECT Link FROM foodList WHERE Agency = '".$Agency."';";

	$result=mysqli_query($con, $sql); 

	while($row = mysqli_fetch_array($result)) {
		$Link=$row["Link"]; 
		if ($Link != "") {
			echo $Link;
		} else {
			echo "No known food list yet.";
		}
	}

	mysqli_close($con);
	echo json_encode($Agency);
	?>
