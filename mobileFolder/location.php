<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" type="text/css" media="only screen and (max-width: 480px), only screen and (max-device-width: 480px)" href="small-device.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="jquery.touchSwipe.js"></script>

      <!-- 3.0 -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp2uBqmOP1iUIzym9L4EEyOi01gOHGHpY&sensor=true"></script>


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



      var map;
        var coordinates = "";

        var db = ['1991 Santa Rita Rd, Suite H Pleasanton CA', '2491 Carmichael Drive, Suite 400 Chico CA', '20 N DeWitt Clovis CA', '30 Van Ness Ave, Suite 260 San Francisco CA', '830 University Avenue Berkeley CA'];

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
       <?php include'menubar.php'; ?>
       <div class="content">
          <div id="header">
            <label for="locationBox">Enter location:</label>
            <div class="submissionBox"><input type="text" id="locationBox" class="form-control" placeholder="address" onkeypress="return userEnteredLocation(event);"></div>
          </div>

          <div style="width: 100%; height: 90%;" id="map-canvas"></div>
          <div id="closest-clinics"></div>
       </div>
     </div>
   </div><!--This extra div closes an open div from the menubar.php and must be included after the content class -->
</body>
</html>

