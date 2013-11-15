<?php
include_once('header.php');
?>
<div class="content">
	<h1> See Food List </h1>
	<p> Once you select your state, you can access that state's food list.</p>
	<form id="stateSelector" method = 'POST'>
		<select name="state" id ="stateDropdown" onchange="getLink(event)">
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
		<div id="link">
			<!--Link appears here-->
		</div>
	</form>
</div>

</div>
 </div>
       </div>
    </div><!--This extra div closes an open div from the menubar.php and must be included after the content class -->
    
</body>
</html>
