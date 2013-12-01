
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="jquery.touchSwipe.js"></script>

      <!-- 3.0 -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp2uBqmOP1iUIzym9L4EEyOi01gOHGHpY&sensor=true"></script>


    <script type="text/javascript">

    // ERRORS TO FIX
    // LOCATION SERVICES NOT ALLOWED (TIMEOUTS)
    // NO ROUTE COULD BE FOUND BY GOOGLE

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


      function getStateFromAddressComponents(addressComponents) {
        for (component in addressComponents) {
          for (type in addressComponents[component]["types"]) {
            if (addressComponents[component]["types"][type] == 'administrative_area_level_1') {
              return addressComponents[component]["short_name"];
            }
          }
        }
      }


      var map;
      var state = "";
      var markers = [];
      var bounds;
  
      function initMap() {
        var mapOptions = {
            zoom: 19,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        
        if (navigator.geolocation) {
            getLocation();
        } else {
          alert('Get fucked');
        }
      }

      //IF LOCATION SERVICES ARE ENABLED

      function getLocation() {
          navigator.geolocation.getCurrentPosition(function(position) {
            setCenter(position.coords.latitude, position.coords.longitude, map);
            setStringLocation(position.coords.latitude, position.coords.longitude);
          });
      }

      function setCenter(lat, lng, map) {
        var latLng = new google.maps.LatLng(lat, lng);
        map.setCenter(latLng);
      }

      function setStringLocation(lat, lng) {
        $.get('https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=false', function(data) {

          $('#location').val(data["results"][0]["formatted_address"]);
          state = getStateFromAddressComponents(data["results"][0]["address_components"]);
          queryDatabase(lat, lng, state);
        });
      }

      // USER INPUTTED ADDRESS 

      function userEnteredLocation(e) {
        if (e.keyCode == 13) {
            var stringLocation = document.getElementById("location").value.replace(' ','+');

            $.get('https://maps.googleapis.com/maps/api/geocode/json?address='+stringLocation+'&sensor=false', function(data) {

              var location = data["results"][0]["geometry"]["location"];
              setCenter(location['lat'], location['lng'], map);
              setStringLocation(location['lat'], location['lng']);
            });
        //???
            return false;
        }
      }

      function getCoords(address) {
        var formattedAddress = address.replace(' ', '+;')
        $.get('https://maps.googleapis.com/maps/api/geocode/json?address='+formattedAddress+'&sensor=false', function(data) {
          var position = data["results"][0]["geometry"]["location"];
          console.log('Lat/Lng from string:')
          console.log(String(position['lat']) + ',' + String(position['lng']));
        });
      }




      function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }

      function addMarker(lat, lng, title) {
        //FIGURE OUT HOW TO DEAL WITH BOUNDS
        //bounds = new google.maps.LatLngBounds();

        var latLng = new google.maps.LatLng(lat, lng);
        bounds.extend(latLng);

        var marker = new google.maps.Marker({
          position: latLng,
          map: map,
          title: title
        });

        google.maps.event.addListener(marker, 'click', function() {
          alert('waft');
        });
        markers.push(marker);
      }


          function queryDatabase(lat, lng, state) {

            $.get('nearClinics.php?lat='+lat+'&lng='+lng+'&state='+state+'&candNum=10', function (clinics) {

              clinics = JSON.parse(clinics);
              //addMarker(data[i]['Latitude'], data[i]['Longitude'], data[i]['Agency']);
              getDistancesToClinics(lat, lng, clinics);
              //map.fitBounds(bounds);
            });
          }

      function getDistancesToClinics(startLat, startLng, clinics) {

        var destinations = [];
        for (var i = 0; i < clinics.length; i++) {
          destinations.push(clinics[i]['Latitude']+', '+clinics[i]['Longitude']);
        }

        console.log(clinics);

        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
          {
            origins: [startLat+', '+startLng],
            destinations: destinations,
            travelMode: google.maps.TravelMode.DRIVING,
          }, callback);

        function callback(response, status) {

        // ADD markers (handle bounds)
        // ADD info

          console.log('Distance matrix:')
          console.log(response["rows"][0]["elements"]);
          var object = response["rows"][0]["elements"];
          for (var i=0; i < clinics.length; i++) {
            object[i]['data'] = clinics[i];
          }
          object.sort(function(a, b) {return parseInt(a.duration.value) - parseInt(b.duration.value) });

          clearMarkers();
          bounds = new google.maps.LatLngBounds();

          $('#closest-clinics').empty();
          for (destination in response["rows"][0]["elements"]) {

            addMarker(object[destination]['data']['Latitude'], object[destination]['data']['Longitude'], object[destination]['data']['Agency']);
            
            console.log(response["rows"][0]["elements"][destination]["duration"]["text"]);
            $('#closest-clinics').append("<p>"+object[destination]["duration"]["text"]+ " | " +object[destination]['data']['Agency']+ "</p>");
          }

          map.fitBounds(bounds);
        }
      }

        google.maps.event.addDomListener(window, 'load', initMap);
      
    </script>
</head>
<body>
	   <div class="container">
	     <?php include'menubar.php'; ?>
  	   <div class="content">
          <div style="width: 70%; height: 90%; float: left;">
            <table style="width: 100%;">
              <tr>
                <td style="text-align: center; vertical-align: middle;">
                  <div id="header">
                    <label for="location">Enter location (e.g. Folsom, CA; 9121 Doc Bar Ct Elk Grove, CA; 95630)</label>
                    <input type="text" id="location" placeholder="address" onkeypress="return userEnteredLocation(event);">
                  </div>
                </td>
              </tr>
            </table>
            <div style="width: 100%; height: 90%; float: left;" id="map-canvas"></div>

          </div>
          <div style="width: 1%; height: 500px; float: left;"></div>
          <div style="float: left; min-width: 300px; width:20%" id="closest-clinics"></div>
          
       </div>
	   </div>
   </div><!--This extra div closes an open div from the menubar.php and must be included after the content class -->
</body>
</html>
