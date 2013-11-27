<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" type="text/css" media="only screen and (max-width: 600px), only screen and (max-device-width: 600px)" href="small-device.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="jquery.touchSwipe.js"></script>


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
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
</head>
<body>




<div class="container" id="css-table">
  <?php include'menubar.php'; ?>
