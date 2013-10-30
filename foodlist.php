<!Doctype HTML>
<html>

<head>
	<!--Includes css and javascript for menubar-->
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="jquery.touchSwipe.js"></script>
	<script type="text/javascript">
	$(window).load(function(){
		$("[data-toggle]").click(function() {
			var toggle_el = $(this).data("toggle");
			$(toggle_el).toggleClass("open-sidebar");
		});
		$(".swipe-area").swipe({
			swipeStatus:function(event, phase, direction, distance, duration, fingers)
			{
				if (phase=="move" && direction =="right") {
					$(".container").addClass("open-sidebar");
					return false;
				}
				if (phase=="move" && direction =="left") {
					$(".container").removeClass("open-sidebar");
					return false;
				}
			}
		}); 
	});

	</script>
	<!--End including javascript for menubar-->

	<script language="javascript" type="text/javascript">
	function makeHttpObject() {
		var xmlHttpObj;

    // branch for Activex version (Microsoft IE)
    /*@cc_on
    @if (@_jscript_version >= 5)
    try {
        xmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlHttpObj = false;
        }
    }
    @else
         xmlHttpObj = false;
         @end @*/
    // branch for native XMLHttpRequest object (Mozilla & Safari)
    if (!xmlHttpObj && typeof XMLHttpRequest != 'undefined') {
    	try {
    		xmlHttpObj = new XMLHttpRequest();
    	} catch (e) {
    		xmlHttpObj = false;
    	}
    }
    return xmlHttpObj;
}

var httpObj = makeHttpObject(); // create the HTTP Object

function getHttpResponse() {
	if (httpObj.readyState == 4) {
		if (httpObj.status == 200) {
			content = httpObj.responseText;
			div = document.getElementById("agency");
			div.innerHTML = "";
            // insert HTML content into "agency" <div>
            div.innerHTML = content;
        } else {
        	alert("There was a problem with the response" + httpObj.statusText);
        }
    }
}

var url = "doLookup.php?state="; // URL for server-side PHP script
function getAgency(ev) {
	ev = (ev) ? ev : ((window.event) ? window.event : null);
	if (ev) {
		var el = (ev.target) ? ev.target : ((ev.srcElement) ? ev.srcElement : null);
		if (el) {
			if (el.selectedIndex > 0) {
				httpObj.open("GET", url + el.options[el.selectedIndex].value, true);
				httpObj.onreadystatechange = getHttpResponse;
				httpObj.send(null);
			}
		}
	}
}


function getList() {  
var agency = $.getJson("/doLookup.php");
var xhr;  
 if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
    xhr = new XMLHttpRequest();  
} else if (window.ActiveXObject) { // IE 8 and older  
    xhr = new ActiveXObject("Microsoft.XMLHTTP");  
}  
     xhr.open("POST", "getList.php", true);   
     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
     xhr.send(agency);  
xhr.onreadystatechange = display_data;  
    function display_data() {  
     if (xhr.readyState == 4) {  
      if (xhr.status == 200) {  
       document.getElementById("link").innerHTML = xhr.responseText;  
      } else {  
        alert('The food list should link below.');  
      }  
     }  
  }  
}  


	</script>
</head>

<body>
	<div class="container">
		<?php include'menubar.php'; ?>
		<div class="content">
			<h1> See Food List </h1>
			<form id="stateSelector">
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
				<input type ="submit" value ="Get Food List!" onclick = "getList()"></input>
			</form>
			<div id="link"></div>
				<!--Link goes here-->
		</div>
	</div>
</div> <!--Extra div to close open div from menubar.php-->
</body>
</html>
