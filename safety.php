<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Live Demo of Google Maps Geocoding Example with PHP</title>

    <style>
    /* some custom css */
    #gmap_canvas{
        width:100%;
        height:30em;
    }
    </style>

</head>

<body>

  <form action="" method="post">
      <input type='text' name='address' placeholder='Enter any address here' />
      <input type='submit' value='Geocode!' />
  </form>
  <div id='address-examples'>
    <div>Address examples:</div>
    <div>1. G/F Makati Cinema Square, Pasong Tamo, Makati City</div>
    <div>2. 80 E.Rodriguez Jr. Ave. Libis Quezon City</div>
</div>

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

        }else{
            return false;
        }

    }

    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}
?>

<?php
if($_POST){

    // get latitude, longitude and formatted address
    $data_arr = geocode($_POST['address']);

    // if able to geocode the address
    if($data_arr){

        $latitude = $data_arr[0];
        $longitude = $data_arr[1];
        $formatted_address = $data_arr[2];
	echo"the longitude is :\n".$longitude;
	echo"the latitude is :".$latitude;

    ?>
	
	<?php

    // if unable to geocode the address
    }else{
        echo "No map found.";
    }
}
?>

<?php
$str = file_get_contents('http://opendata.mybluemix.net/crimes?lat=37.7798&lon=-122.3939&radius=200');
$json = json_decode($str, true); // decode the JSON into an associative array
/*echo '<pre>' . print_r($json, true) . '</pre>';*/


/*$counter =0;
foreach($json as $file) {
	$counter = $counter +1;

}*/
/*echo "the count number is:" .$counter;*/

for ($x = 0; $x < count($json['features']); $x++) {

$source = $json['features'][$x]['properties']['source'];
$type = $json['features'][$x]['properties']['type'];
echo "<br> source :".$source;
echo "<br> type : ".$type;
echo PHP_EOL;

}



?>

</body>
</html>
