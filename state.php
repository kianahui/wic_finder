<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

		<style type="text/css">
    	html { height: 100% }
      	body { height: 100%; margin: 0; padding: 0 }

      	#map-canvas { height: 50%;}
      	#head_text {font-family: 'Arimo'; font-size: 22px;}
    	</style>

    	<link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>

	    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	    <script type="text/javascript" src="bootstrap-select.min.js"></script>
	    <link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">

	    <!-- 3.0 -->
	    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
	    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp2uBqmOP1iUIzym9L4EEyOi01gOHGHpY&sensor=true"></script>


	    <script src="jquery.touchSwipe.js"></script>

	    <script>
	    	$(window).load(function(){
	        	$("[data-toggle]").click(function() {
	        		var toggle_el = $(this).data("toggle");
	        		$(toggle_el).toggleClass("open-sidebar");
	        	});

	        	$(".swipe-area").swipe({
		            swipeStatus:function(event, phase, direction, distance, duration, fingers) {
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

	    <script>

	    	var map;
	    	var coordinates = "";

	    	var db = ['1991 Santa Rita Rd, Suite H Pleasanton CA', '2491 Carmichael Drive, Suite 400 Chico CA', '20 N DeWitt Clovis CA', '30 Van Ness Ave, Suite 260 San Francisco CA', '830 University Avenue Berkeley CA'];

			var usStates = [
				{ name: 'Alaska'	, abbreviation: 'AK', latitude: 	61.385	, longitude:	-152.2683},
				{ name: 'Alabama'	, abbreviation: 'AL', latitude: 	32.799	, longitude:	-86.8073},
				{ name: 'Arkansas'	, abbreviation: 'AR', latitude: 	34.9513	, longitude:	-92.3809},
				{ name: 'Arizona'	, abbreviation: 'AZ', latitude: 	33.7712	, longitude:	-111.3877},
				{ name: 'California', abbreviation: 'CA', latitude: 	36.17	, longitude:	-119.7462},
				{ name: 'Colorado'	, abbreviation: 'CO', latitude: 	39.0646	, longitude:	-105.3272},
				{ name: 'Connecticut',abbreviation: 'CT', latitude: 	41.5834	, longitude:	-72.7622},
				{ name: 'Delaware'	, abbreviation: 'DE', latitude: 	39.3498	, longitude:	-75.5148},
				{ name: 'Florida'	, abbreviation: 'FL', latitude: 	27.8333	, longitude:	-81.717	},
				{ name: 'Georgia'	, abbreviation: 'GA', latitude: 	32.9866	, longitude:	-83.6487},
				{ name: 'Hawaii'	, abbreviation: 'HI', latitude: 	21.1098	, longitude:	-157.5311},
				{ name: 'Iowa'		, abbreviation: 'IA', latitude: 	42.0046	, longitude:	-93.214	},
				{ name: 'Idaho'		, abbreviation: 'ID', latitude: 	44.2394	, longitude:	-114.5103},
				{ name: 'Illinois'	, abbreviation: 'IL', latitude: 	40.3363	, longitude:	-89.0022},
				{ name: 'Indiana'	, abbreviation: 'IN', latitude: 	39.8647	, longitude:	-86.2604},
				{ name: 'Kansas'	, abbreviation: 'KS', latitude: 	38.5111	, longitude:	-96.8005},
				{ name: 'Kentucky'	, abbreviation: 'KY', latitude: 	37.669	, longitude:	-84.6514},
				{ name: 'Louisiana'	, abbreviation: 'LA', latitude: 	31.1801	, longitude:	-91.8749},
				{ name: 'Massachusetts',abbreviation:'MA',latitude: 	42.2373	, longitude:	-71.5314},
				{ name: 'Maryland'	, abbreviation: 'MD', latitude: 	39.0724	, longitude:	-76.7902},
				{ name: 'Maine'		, abbreviation: 'ME', latitude: 	44.6074	, longitude:	-69.3977},
				{ name: 'Michigan'	, abbreviation: 'MI', latitude: 	43.3504	, longitude:	-84.5603},
				{ name: 'Minnesota'	, abbreviation: 'MN', latitude: 	45.7326	, longitude:	-93.9196},
				{ name: 'Missouri'	, abbreviation: 'MO', latitude: 	38.4623	, longitude:	-92.302	},
				{ name: 'Mississippi',abbreviation: 'MS', latitude: 	32.7673	, longitude:	-89.6812},
				{ name: 'Montana'	, abbreviation: 'MT', latitude: 	46.9048	, longitude:	-110.3261},
				{ name: 'North Carolina',abbreviation:'NC',latitude: 	35.6411	, longitude:	-79.8431},
				{ name: 'North Dakota',abbreviation:'ND', latitude: 	47.5362	, longitude:	-99.793	},
				{ name: 'Nebraska'	, abbreviation: 'NE', latitude: 	41.1289	, longitude:	-98.2883},
				{ name: 'New Hampshire',abbreviation:'NH',latitude: 	43.4108	, longitude:	-71.5653},
				{ name: 'New Jersey', abbreviation: 'NJ', latitude: 	40.314	, longitude:	-74.5089},
				{ name: 'New Mexico', abbreviation: 'NM', latitude: 	34.8375	, longitude:	-106.2371},
				{ name: 'Nevada'	, abbreviation: 'NV', latitude: 	38.4199	, longitude:	-117.1219},
				{ name: 'New York'	, abbreviation: 'NY', latitude: 	42.1497	, longitude:	-74.9384},
				{ name: 'Ohio'		, abbreviation: 'OH', latitude: 	40.3736	, longitude:	-82.7755},
				{ name: 'Oklahoma'	, abbreviation: 'OK', latitude: 	35.5376	, longitude:	-96.9247},
				{ name: 'Oregon'	, abbreviation: 'OR', latitude: 	44.5672	, longitude:	-122.1269},
				{ name: 'Pennsylvania',abbreviation:'PA', latitude: 	40.5773	, longitude:	-77.264	},
				{ name: 'Rhode Island',abbreviation:'RI', latitude: 	41.6772	, longitude:	-71.5101},
				{ name: 'South Carolina',abbreviation:'SC',latitude: 	33.8191	, longitude:	-80.9066},
				{ name: 'South Dakota',abbreviation:'SD', latitude: 	44.2853	, longitude:	-99.4632},
				{ name: 'Tennessee'	, abbreviation: 'TN', latitude: 	35.7449	, longitude:	-86.7489},
				{ name: 'Texas'		, abbreviation: 'TX', latitude: 	31.106	, longitude:	-97.6475},
				{ name: 'Utah'		, abbreviation: 'UT', latitude: 	40.1135	, longitude:	-111.8535},
				{ name: 'Virginia'	, abbreviation: 'VA', latitude: 	37.768	, longitude:	-78.2057},
				{ name: 'Vermont'	, abbreviation: 'VT', latitude: 	44.0407	, longitude:	-72.7093},
				{ name: 'Washington', abbreviation: 'WA', latitude: 	47.3917	, longitude:	-121.5708},
				{ name: 'Wisconsin'	, abbreviation: 'WI', latitude: 	44.2563	, longitude:	-89.6385},
				{ name: 'West Virginia',abbreviation:'WV',latitude: 	38.468	, longitude:	-80.9696},
				{ name: 'Wyoming'	, abbreviation: 'WY', latitude: 	42.7475	, longitude:	-107.2085}
			];

			function getStringLocation(position) {
				getDistance(position.coords.latitude+','+position.coords.longitude);
				$.get('https://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude+'&sensor=false', function(data) {

					$('#location').val(data["results"][0]["formatted_address"]);
					console.log(data["results"]);

					/*
					var addressComponents = data["results"][0]["address_components"];
					for (component in addressComponents) {
				  		for (type in addressComponents[component]["types"]) {
				  			if (addressComponents[component]["types"][type] == 'postal_code') {
				  				var zipCode = addressComponents[component]["long_name"];
				  				$('#location').val(zipCode);
				  			}
				  		}
					}*/
				});
	      	}


			function getCoords(address) {
				var formattedAddress = address.replace(' ', '+;')
				$.get('https://maps.googleapis.com/maps/api/geocode/json?address='+formattedAddress+'&sensor=false', function(data) {
					var position = data["results"][0]["geometry"]["location"];
					console.log(String(position['lat']) + ',' + String(position['lng']));
				});
			}

			function getDistance(start) {
				var end = '';
				for (i in db) {
					end += db[i].split(' ').join('+') + '|';
				}
				
				$.get('https://maps.googleapis.com/maps/api/distancematrix/json?origins='+start+'&destinations='+end+'&sensor=false', function(data) {
					$('#closest-clinics').empty();
					for (destination in data["rows"][0]["elements"]) {
						console.log(data["rows"][0]["elements"][destination]["duration"]["text"]);
						$('#closest-clinics').append("<p>"+data["rows"][0]["elements"][destination]["duration"]["text"]+ " | " +db[destination]+ "</p>").css('font-family', 'Arimo');
					}
				});


			}

			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(initMap);
					navigator.geolocation.getCurrentPosition(getStringLocation);
					//navigator.geolocation.getCurrentPosition(getDistance);
				} else {
					alert('Geolocation not supported by browser.');
				}
			}

	      	function initMap(position) {
	      		var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

	          	var mapOptions = {
	          		center: latLng,
	          		zoom: 19,
	          		mapTypeId: google.maps.MapTypeId.ROADMAP
	        	};

	        	map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	      	}

	      	function initialize() {
	        	getLocation();
	      	}

	      	function userEnteredLocation(e) {
	      		if (e.keyCode == 13) {
	      			var stringLocation = document.getElementById("location").value.replace(' ','+');

					$.get('https://maps.googleapis.com/maps/api/geocode/json?address='+stringLocation+'&sensor=false', function(data) {
						var location = data["results"][0]["geometry"]["location"];
						var latLng = new google.maps.LatLng(location['lat'], location['lng']);
						map.setCenter(latLng);

						getDistance(String(location['lat'])+','+String(location['lng']));
					});
					return false;
	      		}
	      	}

	      google.maps.event.addDomListener(window, 'load', initialize);


    </script>
  </head>
  <body>
  	<div class="container">
  		<?php include 'menubar.php'; ?>
	  	<div class="content">
		<!-- Single button -->
		<table style="width: 100%;">
			<tr>
				<td style="text-align: center; vertical-align: middle;">
					<div id="header">
						<form class="well form-inline" role="form">
							<div class="form-group">
								<label for="location">Enter location:</label>
								<input type="text" id="location" class="form-control" placeholder="address" onkeypress="return userEnteredLocation(event);">
							</div>
						</form>
					</div>
				</td>
			</tr>
		</table>

	    <div id="map-canvas"></div>
	    <div id="closest-clinics"></div>
	</div>
	</div><!-- closes open div from menubar.php -->
  </body>
</html>