
<html>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="jquery.touchSwipe.js"></script>
    <script src="js/bootstrap.min.js"></script>

      <!-- 3.0 -->
    <style type="text/css">
      ul.scroll-menu {
        position: absolute;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -moz-overflow-scrolling: touch;
        -ms-overflow-scrolling: touch;
        -o-overflow-scrolling: touch;
        overflow-scrolling: touch;
        right: 0 !important;
        top: 33 !important;
        width: 100%;
        height: auto;
        max-height: 500px;
        margin: 0;
        border-left: none;
        border-right: none;
        -webkit-border-radius: 0 !important;
        -moz-border-radius: 0 !important;
        -ms-border-radius: 0 !important;
        -o-border-radius: 0 !important;
        border-radius: 0 !important;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
      }
    </style>

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
      var directionsDisplay;

      var state = "";
      var startLat;
      var startLng;
      var markers = [];
      var bounds;
  
      function initMap() {
        directionsDisplay = new google.maps.DirectionsRenderer();

        var mapOptions = {
            zoom: 19,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('directions-panel'));

        if (navigator.geolocation) {
            getLocation();
        } else {
          alert('geolocation not supported?');
        }
      }

      //IF LOCATION SERVICES ARE ENABLED

      function getLocation() {
          navigator.geolocation.getCurrentPosition(function(position) {
            startLat = position.coords.latitude;
            startLng = position.coords.longitude;
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
              startLat = location['lat'];
              startLng = location['lng'];
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
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
          getDirections(marker.getPosition());
          marker.setMap(null);
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


      function getDirections(endLatLng) {
        var directionsService = new google.maps.DirectionsService();
        directionsService.route(
          {
            origin: startLat+', '+startLng,
            destination: endLatLng,
            travelMode: google.maps.TravelMode.DRIVING,
          }, callback);

        function callback(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            console.log(response);
            directionsDisplay.setDirections(response);
          }
        }

      }

      var now = new Date().valueOf();
      setTimeout(function () {
          if (new Date().valueOf() - now > 100) return;
          window.location = "https://google.com";
      }, 25);
      window.location = "appname://";

        google.maps.event.addDomListener(window, 'load', initMap);
      
    </script>
</head>
<body>
     <div class="container">
       <?php include'menubar.php'; ?>
       <div class="content">
          <div style="width: 95%; height: 50%">
            <table style="width: 100%;">
              <tr>
                <td style="text-align: center; vertical-align: middle;">
                  <div id="header">
                    <label for="location">Enter location (e.g. Folsom, CA; 9121 Doc Bar Ct Elk Grove, CA; 95630)</label>
                    <div stle="margin: 10px;" class="input-group">
                      
                      <input id='location' type="text" class="form-control" onkeypress="return userEnteredLocation(event);">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">State <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right scroll-menu">
                          <li><a href="#">AL</a></li>
                          <li><a href="#">AK</a></li>
                          <li><a href="#">AZ</a></li>
                          <li><a href="#">AR</a></li>
                          <li><a href="#">CA</a></li>
                          <li><a href="#">CO</a></li>
                          <li><a href="#">CT</a></li>
                          <li><a href="#">DE</a></li>
                          <li><a href="#">DC</a></li>
                          <li><a href="#">FL</a></li>
                          <li><a href="#">GA</a></li>
                          <li><a href="#">HI</a></li>
                          <li><a href="#">ID</a></li>
                          <li><a href="#">IL</a></li>
                          <li><a href="#">IN</a></li>
                          <li><a href="#">IA</a></li>
                          <li><a href="#">KS</a></li>
                          <li><a href="#">KY</a></li>
                          <li><a href="#">LA</a></li>
                          <li><a href="#">ME</a></li>
                          <li><a href="#">MD</a></li>
                          <li><a href="#">MA</a></li>
                          <li><a href="#">MI</a></li>
                          <li><a href="#">MN</a></li>
                          <li><a href="#">MS</a></li>
                          <li><a href="#">MO</a></li>
                          <li><a href="#">MT</a></li>
                          <li><a href="#">NE</a></li>
                          <li><a href="#">NV</a></li>
                          <li><a href="#">NH</a></li>
                          <li><a href="#">NJ</a></li>
                          <li><a href="#">NM</a></li>
                          <li><a href="#">NY</a></li>
                          <li><a href="#">NC</a></li>
                          <li><a href="#">ND</a></li>
                          <li><a href="#">OH</a></li>
                          <li><a href="#">OK</a></li>
                          <li><a href="#">OR</a></li>
                          <li><a href="#">PA</a></li>
                          <li><a href="#">RI</a></li>
                          <li><a href="#">SC</a></li>
                          <li><a href="#">SD</a></li>
                          <li><a href="#">TN</a></li>
                          <li><a href="#">TX</a></li>
                          <li><a href="#">UT</a></li>
                          <li><a href="#">VT</a></li>
                          <li><a href="#">VA</a></li>
                          <li><a href="#">WA</a></li>
                          <li><a href="#">WV</a></li>
                          <li><a href="#">WI</a></li>
                          <li><a href="#">WY</a></li>
                        </ul>
                      </div><!-- /btn-group -->
                    </div>
                  </div>
                </td>
              </tr>
            </table>
            <div style="width: 100%; height: 100%; float: left;" id="map-canvas"></div>

          </div>
          <!--<div style="width: 1%; height: 500px; float: left;"></div> -->
          <div style="width:95%; height: 50%">
            <div id='directions-area' style="float: right; width: 45%">
              <h1> Directions </h1>
              <div id='directions-panel'></div>
            </div>
            <div id='closest-clinics-area' style="float: left; min-width: 300px; width:45%">
              <h1> Nearest Clinics </h1>
              <div id="closest-clinics"></div>
            </div>
          </div>
          
       </div>
     </div>
   </div><!--This extra div closes an open div from the menubar.php and must be included after the content class -->
</body>
</html>
