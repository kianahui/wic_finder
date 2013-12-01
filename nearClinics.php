<?php 
	$candidateNum = (int) $_GET['candNum'];
	$lat = (float) $_GET['lat'];
	$lng = (float) $_GET['lng'];
	$state = $_GET['state'];

	function distance($x1, $x2, $y1, $y2) {
		$distance = pow((pow($x1 - $x2, 2) + pow($y1 - $y2, 2)), 1/2);
		return $distance;
	}

	$con = mysqli_connect("localhost", "root", "", "mydb");

	$results = mysqli_query($con, "SELECT * FROM `californiaClinics` WHERE State = 'CA'");

	$nearestClinics = array();

	while($row = mysqli_fetch_assoc($results)) {
		
		// If array contains less entries than the number of entries you want to return

		for ($i = count($nearestClinics) -1; $i >= -1; $i--) {
			if ($i == -1) {
				array_unshift($nearestClinics , $row);
			#if selected clinic's distance is greater than the current clinic's distance, then keep going 
			} elseif (distance($nearestClinics[$i]['Latitude'], $lat, $nearestClinics[$i]['Longitude'], $lng) < distance($row['Latitude'], $lat, $row['Longitude'], $lng)) {
				//echo 'added at '.$i."\n";
				array_splice($nearestClinics, $i + 1, 0, array($row));
				break;
			}
		// Array is already full, only way to get in is to be less distance than a member of the array
		}
		if (count($nearestClinics) > $candidateNum) {
			array_pop($nearestClinics);
		}

		/*else {
			for last to first:
				compare distances
				insert where relevant
		}
			//echo "'".$row['Address1']." ".$row['City']." ".$row['State']." ".$row['Zip_Code']."', "; */
	}

	//$str = implode(",", $nearestClinics);
	//echo $lat - $lng;
	echo json_encode($nearestClinics);
?>