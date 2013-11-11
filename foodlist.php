<?php
include_once('header.php');
?>
<div class="content">
	<h1> See Food List </h1>
	<form id="stateSelector" method = 'POST'>
		<select name="state" id ="stateDropdown" onchange="getAgency(event)">
			<option value="">Please select your state</option>

			<? 
			$con = mysqli_connect("localhost", "root");
			mysqli_select_db($con, "mydb");

			$sql="SELECT DISTINCT State FROM foodList"; 
			$result=mysqli_query($con, $sql); 

			$options=""; 

			while ($row=mysqli_fetch_array($result)) { 

				$State=$row["State"]; 
				if ($State !="") {
					$option="<OPTION VALUE=\"$State\">$State</option>";
					echo $option;
				}
			} 
			?>
		</select>
		<br>

		<br>
		<div id="agency">
			<!--Agency dropdown goes here-->
		</div>
		<input type ="submit" name ="submit" value ="Get Food List!" onclick = "getList()"></input>
	</form>
	<br>
	<div id="link"></div>
	<!--Link goes here-->
	<?php 
	if(isset($_POST['submit'])) {
		$Agency = $_POST['agency'];
		$con = mysqli_connect("localhost", "root");
		mysqli_select_db($con, "mydb");

		$sql = "SELECT Link FROM foodList WHERE Agency = '".$Agency."';";

		$result=mysqli_query($con, $sql); 

		echo "<br><br><p>";

		while($row = mysqli_fetch_array($result)) {
			$Link=$row["Link"]; 
			if ($Link != "") {
				echo "<a href = \"$Link\" target=\"_blank\">" . $Agency . "</a>";
			} else {
				echo "No known food list yet. Don't worry. We're working on it!";
			}
		}

		mysqli_close($con);
	}
	?>
</div>


<?php
include_once('footer.php');
?>
