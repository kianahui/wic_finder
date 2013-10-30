<!DOCTYPE HTML>
<html>
<head>
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
</head>
<body>
    <div class="container">
       <?php
        include'menubar.php';
       ?>
       <div class="content">
          <img src = "http://www.fns.usda.gov/sites/default/files/wic---250_0.png" />
          <h1>WIC Central</h1>
          <pre width=300>
          <p>Welcome! The National WIC Association runs this website and works with WIC agencies to give you the 
          most up to date info in one spot. </br>You can trust this website because we are the WIC community.</p>  
          </pre>
       </div>
       </div>
    </div><!--This extra div closes an open div from the menubar.php and must be included after the content class -->
</body>
</html>

