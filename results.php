<div class="container-fluid" id="#main">
<head>
  <link rel="stylesheet" type="text/css" href="pagestyle.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
  <script src="styling.js"></script>
</head>

<body id="resultsBodyPage">

  <div class="row container-fluid" id="navigation">
			<div class="col-md-6">
				<a class="btn btn-default" id="homebutton" role="button" href="home.html">
          <div class="container-fluid">
            <img src="photos\Capture.PNG" alt="logo" id ="logo">
          </div>
        </a>
	</div>

      <!--search bar -->
      <div class="col-md-4" id="navSearch">
        <div class="col-md-10">
          <div class="form-group">
              <input type="text" class="form-control" id="searchInput" aria-describedby="searchHelp" placeholder="Enter a destination..">
              <medium id="searchHelp" class="form-text text-muted" style="align: center;"></medium>
          </div>
        </div>
      </div>
	</div>

  <div class = "col-md-6" id="leftside">
    <div class="container-fluid" id="searchedAddress">

    </div>



    <div class="container-fluid" id="resources">
      <h5>Resources...</h5>


<?php
      // function to geocode address, it will return false if unable to geocode address
      function geocode($address){
          // url encode the address
          $address = urlencode($address);
          // google map geocode api url
          $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDRxKRhy9S55UnU-SjBlWAZ4KH7gyzDPow";
          // get the json response
          $resp_json = file_get_contents($url);
          // decode the json
          $resp = json_decode($resp_json, true);
          // response status will be 'OK', if able to geocode given address
          if($resp['status']=='OK'){
              // get the important data
              $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
              $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
              $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
              // verify if data is complete
              if($lati && $longi && $formatted_address){
                  // put the data in the array
                  $data_arr = array();
                  array_push(
                      $data_arr,
                          $lati,
                          $longi,
                          $formatted_address
                      );
                  return $data_arr;
              }
              else{
                  return false;
              }
          }
          else{
              echo "<strong>ERROR: {$resp['status']}</strong>";
              return false;
          }
      }
      
if($_POST){
    // get latitude, longitude and formatted address
    $data_arr = geocode($_POST['address']);
        // if able to geocode the address
        if($data_arr){
          $radius = 200 ;
          $latitude = $data_arr[0];
          $longitude = $data_arr[1];
          $formatted_address = $data_arr[2];
				echo"You entered: " .$_POST['address'];
                echo"<br>the longitude is :\n".$longitude;
                echo"the latitude is :".$latitude;
                //$latitude == 37.7799963;
                //$longitude == -122.3938519;
                //if($latitude == 37.7799963 && $longitude == -122.3938519){
                    //$latitude = 37.7798;
                    //$longitude = -122.3939;
					$requestURL = "http://opendata.mybluemix.net/crimes?lat={$latitude}&lon={$longitude}&radius={$radius}";
                    //echo $requestURL + '<br>';
					$str = file_get_contents("http://opendata.mybluemix.net/crimes?lat={$latitude}&lon={$longitude}&radius={$radius}");
                    //echo 'the string 2 is' .$str;
                    $json = json_decode($str, true); // decode the JSON into an associative array
                    /*echo '<pre>' . print_r($json, true) . '</pre>' */
                    /*$counter =0;
                    foreach($json as $file) {
                        $counter = f$counter +1;
                    $str = file_get_contents('http://opendata.mybluemix.net/crimes?lat=37.7798&lon=-122.3939&radius=200');
                    }
                    echo "the count number is:" .$counter;
                    */
                           $countSexOf = 0;
            $countDrugs = 0;
            $countOtherTheft = 0;
            $countFeature = 0;
          $TheftFromPerson = 0;
          $countPublicOrder = 0;
          
          
            for ($x = 0; $x < count($json['features']); $x++) {
                $source = $json['features'][$x]['properties']['source'];
                $type = $json['features'][$x]['properties']['type'];
                //echo "<br> source :".$source;
                //echo "<br> type : ".$type;
                echo PHP_EOL;
                if($type == "Drugs"){
					//echo"inside of drug count";
                  $countDrugs = $countDrugs +1;
                }else if($type == "Other theft"){
                  $countOtherTheft = $countOtherTheft +1;
                }else if($type == "Feature"){
                  $countFeature = $countFeature +1;
                }else if($type == "Public order"){
                  $countPublicOrder = $countPublicOrder +1;
                }else if($type == "Theft from the person"){
                  $TheftFromPerson = $TheftFromPerson +1;
                }else if($type == "Violence and sexual offences"){
                  $countSexOf = $countSexOf +1;
                }
            }
			
			echo "<br> The number of Drugs reports are : ".$countDrugs;
            echo "<br> The number of other thefts are : ".$countOtherTheft;
            echo "<br> The number of Feature are : ".$countFeature;
            echo "<br> The number of Public order reports are : ".$countPublicOrder;
            echo "<br> The number of Drugs Theft from other people: ".$TheftFromPerson;
            echo "<br> The number of Violence and sexual offences : ".$countSexOf;
                           
                //}
      }
      else{
        echo "No map found.";
        }
  }
    ?>
    </div>

  </div>

  <div class = "col-md-4" id="rightside">
    <div class="container-fluid" id="twitterFeed">
      <a class="twitter-timeline" data-width="200" data-height="700" data-link-color="#A2B964" href="https://twitter.com/CNN?ref_src=twsrc%5Etfw">Tweets by CNN</a>
      <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
  </div>

</body>

<footer>
  <div class="container-fluid" id="resulttagline">
    <h5>Search | Decide | Arrive</h5>
  </div>
</footer>
</div>

