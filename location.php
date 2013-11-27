<?php
include_once('header.php');
?>
  	   <div class="content">
          <table style="width: 100%;">
            <tr>
              <td style="text-align: center; vertical-align: middle;">
                <div id="header">
                  <label for="location">Enter location:</label>
                  <input type="text" id="location" class="form-control" placeholder="address" onkeypress="return userEnteredLocation(event);">
                </div>
              </td>
            </tr>
          </table>

          <div style="width: 100%; height: 500px;" id="map-canvas"></div>
          <div id="closest-clinics"></div>
       </div>
<?php
include_once('footer.php');
?>
