<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <link rel="stylesheet" type="text/css" media="only screen and (max-width: 600px), only screen and (max-device-width: 600px)" href="small-device.css" />
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


  <?php
/*
=====================================================
Mobile version detection
-----------------------------------------------------
compliments of http://www.buchfelder.biz/
=====================================================
*/

$mobile = "localhost/wic_finder-mobile/";
$text = $_SERVER['HTTP_USER_AGENT'];
$var[0] = 'Mozilla/4.';
$var[1] = 'Mozilla/3.0';
$var[2] = 'AvantGo';
$var[3] = 'ProxiNet';
$var[4] = 'Danger hiptop 1.0';
$var[5] = 'DoCoMo/';
$var[6] = 'Google CHTML Proxy/';
$var[7] = 'UP.Browser/';
$var[8] = 'SEMC-Browser/';
$var[9] = 'J-PHONE/';
$var[10] = 'PDXGW/';
$var[11] = 'ASTEL/';
$var[12] = 'Mozilla/1.22';
$var[13] = 'Handspring';
$var[14] = 'Windows CE';
$var[15] = 'PPC';
$var[16] = 'Mozilla/2.0';
$var[17] = 'Blazer/';
$var[18] = 'Palm';
$var[19] = 'WebPro/';
$var[20] = 'EPOC32-WTL/';
$var[21] = 'Tungsten';
$var[22] = 'Netfront/';
$var[23] = 'Mobile Content Viewer/';
$var[24] = 'PDA';
$var[25] = 'MMP/2.0';
$var[26] = 'Embedix/';
$var[27] = 'Qtopia/';
$var[28] = 'Xiino/';
$var[29] = 'BlackBerry';
$var[30] = 'Gecko/20031007';
$var[31] = 'MOT-';
$var[32] = 'UP.Link/';
$var[33] = 'Smartphone';
$var[34] = 'portalmmm/';
$var[35] = 'Nokia';
$var[36] = 'Symbian';
$var[37] = 'AppleWebKit/413';
$var[38] = 'UPG1 UP/';
$var[39] = 'RegKing';
$var[40] = 'STNC-WTL/';
$var[41] = 'J2ME';
$var[42] = 'Opera Mini/';
$var[43] = 'SEC-';
$var[44] = 'ReqwirelessWeb/';
$var[45] = 'AU-MIC/';
$var[46] = 'Sharp';
$var[47] = 'SIE-';
$var[48] = 'SonyEricsson';
$var[49] = 'Elaine/';
$var[50] = 'SAMSUNG-';
$var[51] = 'Panasonic';
$var[52] = 'Siemens';
$var[53] = 'Sony';
$var[54] = 'Verizon';
$var[55] = 'Cingular';
$var[56] = 'Sprint';
$var[57] = 'AT&T;';
$var[58] = 'Nextel';
$var[59] = 'Pocket PC';
$var[60] = 'T-Mobile';    
$var[61] = 'Orange';
$var[62] = 'Casio';
$var[63] = 'HTC';
$var[64] = 'Motorola';
$var[65] = 'Samsung';
$var[66] = 'NEC';

$result = count($var);

for ($i=0;$i<$result;$i++)
{    
  $ausg = stristr($text, $var[$i]);    
  if(strlen($ausg)>0)
  {
    header("location: $mobile");
    exit;
  }
  
}
?>
<div class="container" id="css-table">
  <?php
  include'menubar.php';
  ?>

