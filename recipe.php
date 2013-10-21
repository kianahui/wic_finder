<!--helps user find a recipe for their ingredients using an outside website. To change website, replace the old website url in iframe the iframe with the new one. Specifically set src = "new website url". 
iframe--> 
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
	<?php include'menubar.php'; ?>
	<div class="content">
		<h1> Find a recipe to match your ingredients using yummly.com </h1>
		<p> Enter your ingredients into the serach bar below and push enter.</p>
		<iframe src="http://www.yummly.com" width =900; height=700;> </iframe>
    		</div>
    	</div>
	</div>
    </body>
 </html>
