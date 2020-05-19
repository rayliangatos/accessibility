<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="fontawesome/css/all.css" rel="stylesheet">
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
  require 'vendor/autoload.php';
  use Nahid\JsonQ\Jsonq;

  $jsonData=$busLine=$busStop=$leaveTime=$nextTime= "";

  if($_SERVER['REQUEST_METHOD'] == "POST") {
      searchResult();
  }

  function searchResult() {
    $busLine = isset($_POST['busLine']) ? $_POST['busLine'] : '';
    $busStop = isset($_POST['busStop']) ? $_POST['busStop'] : '';
    $leaveTIme = isset($_POST['leaveTime']) ? $_POST['leaveTime'] : '';

    $jsonData = new Jsonq('bustimetable.json');
    $line = $jsonData->from("lines")
    ->where('id', '=', $busLine)
    ->get();

    foreach ($line as $value) {
      $stops = $value["stops"];
      foreach ($stops as $stop) {
        if($stop["name"]==$busStop){
          $times = $stop["times"];
          foreach ($times as $time) {
            $date = new DateTime("now", new DateTimeZone('Europe/London') );
            $currentTime = $date->format('H:i');
            if ($leaveTIme != "") {
              //print("Preferred leave time:$leaveTIme");
              if (date('H:i', strtotime($time))>=date('H:i', strtotime($leaveTIme))) {
                  print("<div class='container'><h2>Your next bus time at:<b>$time</b></h2></div>\n");
                  $nextTime = $leaveTIme;
                  break;
              }
            } else {
              if (date('H:i', strtotime($time))>=date('H:i', strtotime($currentTime))) {
                  print("<div class='container'><h2>Your next bus time at:<b>$time</b></h2></div>\n");
                  $nextTime = $time;
                  break;
              }
            }
          }
        }
      }
    }
  }

?>
<script type="text/javascript">
  function changeStops(){
    var selectedBusLine = $('#busLine').children("option:selected").val();
    if (selectedBusLine=='8') {
      $('option[class^="bus9"]').hide();
      $('option[class^="bus8"]').show();
    } else if(selectedBusLine=='9'){
      $('option[class^="bus8"]').hide();
      $('option[class^="bus9"]').show();
    }
  }
</script>
</head>
  <body onload="changeStops()">
    <div class="container">
      <h2>Search Bus</h2>
      <form class="" action="searchbus.php" method="post">
        <div class="form-group row">
          <label for="busLine" class="col-sm-3 col-form-label">Your Bus Line:</label>
          <div class="col-sm-9">
            <select class="custom-select" id="busLine" name="busLine" onchange="changeStops()">
              <option value="8"
              <?php if(isset($_POST['busLine']) && $_POST['busLine'] == '8')
              echo ' selected="selected"';
              ?>
              >8</option>
              <option value="9"
              <?php if(isset($_POST['busLine']) && $_POST['busLine'] == '9')
              echo ' selected="selected"';
              ?>
              >9</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="busStop" class="col-sm-3 col-form-label">Your current Stop:</label>
          <div class="col-sm-9">
            <select class="custom-select" id="busStop" name="busStop">
              <option value="">--</option>
              <option value="St Mary's Butts" class="bus8"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'St Mary\'s Butts')
              echo ' selected="selected"';
              ?>
              >St Mary's Butts</option>
              <option value="Station Road" class="bus8"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Station Road')
              echo ' selected="selected"';
              ?>
              >Station Road</option>
              <option value="RBH South Wing" class="bus8"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'RBH South Wing')
              echo ' selected="selected"';
              ?>
              >RBH South Wing</option>
              <option value="TVSP" class="bus8"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'TVSP')
              echo ' selected="selected"';
              ?>
              >TVSP</option>
              <option value="School Green" class="bus8"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'School Green')
              echo ' selected="selected"';
              ?>
              >School Green</option>
              <option value="Bays Crescent" class="bus8"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Bays Crescent')
              echo ' selected="selected"';
              ?>
              >Bays Crescent</option>
              <option value="St Mary's Butts" class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'St Mary\'s Butts')
              echo ' selected="selected"';
              ?>
              >St Mary's Butts</option>
              <option value="Station Road" class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Station Road')
              echo ' selected="selected"';
              ?>
              >Station Road</option>
              <option value="RBH South Wing" class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'RBH South Wing')
              echo ' selected="selected"';
              ?>
              >RBH South Wing</option>
              <option value="Community Centre" class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Community Centre')
              echo ' selected="selected"';
              ?>
              >Community Centre</option>
              <option value="Hartland Road"  class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Hartland Road')
              echo ' selected="selected"';
              ?>
              >Hartland Road</option>
              <option value="Wentworth Avenue"  class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Wentworth Avenue')
              echo ' selected="selected"';
              ?>
              >Wentworth Avenue</option>
              <option value="Three Mile Cross Post Office"  class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Three Mile Cross Post Office')
              echo ' selected="selected"';
              ?>
              >Three Mile Cross Post Office</option>
              <option value="St Michaels Hall"  class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'St Michaels Hall')
              echo ' selected="selected"';
              ?>
              >St Michaels Hall</option>
              <option value="Bays Crescent"  class="bus9"
              <?php if(isset($_POST['busStop']) && $_POST['busStop'] == 'Bays Crescent')
              echo ' selected="selected"';
              ?>
              >Bays Crescent</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="leaveTime" class="col-sm-3 col-form-label">Your preferred leave time:</label>
          <div class="col-sm-9">
            <input type="time" id="leaveTime" name="leaveTime">
          </div>
        </div>
        <div class="btn-group row">
          <button type="submit" class="btn btn-primary ml-3" name="button">Search</button>
        </div>
        <div id="result" class="">
          <!--<div>Your next bus time:<p id="myNextTime"></p></div>-->
        </div>
      </form>
    </div>
  </body>
</html>
