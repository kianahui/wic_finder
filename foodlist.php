<!Doctype HTML>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<SCRIPT language=JavaScript>
	function displayList () {
		//
	}

	function reload(form){
		var val=$State; 
		self.location='foodList.php?agency=' + val ;
	}
	</script>
	<h1> See Food List </h1>
</head>

<body>
	<form method=post name=f1 action=''>
		<div>
			<select name="state" id ="statedropdown" onchange=\"reload(this.form)\">
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
		</div>
		<br>
		<div>

			<select name="agency" id ="agencydropdown">
				<option value="">Please select your agency</option>

				<? 
				$con = mysqli_connect("localhost", "root");
				mysqli_select_db($con, "mydb");

				$sql="SELECT Agency FROM foodList WHERE State = $State"; 
				$result=mysqli_query($con, $sql); 

				$options=""; 

				while ($row=mysqli_fetch_array($result)) { 

					$Agency=$row["Agency"]; 
					if ($Agency !="") {
						$option="<OPTION VALUE=\"$Agency\">$Agency</option>";
						echo $option;
					}
				} 
				?>
			</select>
				
		</form>
	</div>
	<br>
	<input type ="submit" value ="Get Food List!" onclick="displayList();"></input>
</body>
</html>