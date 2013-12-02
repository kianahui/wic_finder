<!DOCTYPE HTML>
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
      div = document.getElementById("link");
      div.innerHTML = "";
            // insert HTML content into "link" <div>
            div.innerHTML = content;
          } else {
            alert("There was a problem with the response" + httpObj.statusText);
          }
        }
      }

var url = "doLookup.php?state="; // URL for server-side PHP script
function getLink(ev) {
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

</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
</head>

<body>
<div class="container" id="css-table">
  <?php
  include'menubar.php';
  ?>
