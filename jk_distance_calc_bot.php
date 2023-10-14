<?php
include 'db.php';

// @jk_distance_calc_bot

$token = '6332953816:AAGSebazzKTBX06rfOEjZRf_ra42kvXL5GU';
$server = "https://api.telegram.org/bot$token";
$webhookAddress = "https://api.telegram.org/bot6332953816:AAGSebazzKTBX06rfOEjZRf_ra42kvXL5GU/setWebhook?url=https://isatis.vip/TELEGRAM_BOT/jk_distance_calc_bot.php";

$input = file_get_contents("php://input");
$decodedInput = json_decode($input,true);

$chatId = $decodedInput['message']['chat']['id'];
$message = $decodedInput['message']['text'];

// Commands
if(strpos($message, '/start') === 0){
                    $sql = "SELECT id FROM distance_calc WHERE msg_id='$chatId'";
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0) {
                        // nothing to do
                    }else{
                           $sql = "INSERT INTO distance_calc(msg_id) VALUES ('$chatId')";
                           $jk = '0';
                           if ($conn->query($sql) === TRUE){
                             $jk = "User input saved successfully";
                           } else {
                             $jk = "Error: " . $sql . "<br>" . $conn->error;
                           }
                    }
    $reply = "<< This bot will help you to calculate distances, To begin send /calc >>";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}else if(strpos($message, '/calc') === 0){
    $reply = ">> Choose type to start : /loc OR /post";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}else if(strpos($message, '/loc') === 0){
    $reply = ">> 1.Send first latitude and longitude by this format(comma separated) : latitude,longitude";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}else if(strpos($message, '/post') === 0){
    $reply = ">> 1.Send first postal code";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}else{
    $json = file_get_contents("php://input");
    $update = json_decode($json, true);
    $userMessage = $update["message"]["text"];
    $pos = strpos($userMessage, ',');
    if($pos === false){
        // BY POST CODE
        $qStatus;
                    $sql = "SELECT status FROM distance_calc WHERE msg_id='$chatId'";
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0) {
                      if($row = $res->fetch_assoc()){
                        $qStatus = $row['status'];
                      }
                    } else {
                      $qStatus = 0;
                    }
                    if($qStatus == 0){
                        $sql = "UPDATE distance_calc SET post1='$userMessage',status=1 WHERE msg_id = '$chatId'";
                        $jk = '0';
                        if ($conn->query($sql) === TRUE) {
                                  $jk = "User input saved successfully";
                        } else {
                                  $jk = "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $result = ">> 2.Send second postal code";
                    }else if($qStatus == 1 ){
                        $sql = "UPDATE distance_calc SET post2='$userMessage' WHERE msg_id = '$chatId'";
                        $jk = '0';
                        if ($conn->query($sql) === TRUE) {
                                  $jk = "User input saved successfully";
                        } else {
                                  $jk = "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $post_1 = '';

                        $sql = "SELECT post1 FROM distance_calc WHERE msg_id='$chatId'";
                            $res = $conn->query($sql);
                                if ($res->num_rows > 0) {
                                   // output data of each row
                                  if($row = $res->fetch_assoc()){
                                    // You can now use $row['user_input'] for your calculations
                                      $post_1 = $row['post1'];
                                  }
                                } else {
                                  $reply = "0";
                                }
                        $postCalculation = postalCodeDis($post_1,$userMessage);
                                                $sql = "UPDATE distance_calc SET result='$postCalculation',status=0 WHERE msg_id = '$chatId'";
                                                $jk = '0';
                                                if ($conn->query($sql) === TRUE) {
                                                          $jk = "User input saved successfully";
                                                } else {
                                                          $jk = "Error: " . $sql . "<br>" . $conn->error;
                                                }
                        $result = "Distance is : " . $postCalculation . " Km";
                    }
    }else{
        // BY LOCATION
        $qStatus;
                    $sql = "SELECT status FROM distance_calc WHERE msg_id='$chatId'";
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0) {
                      if($row = $res->fetch_assoc()){
                        $qStatus = $row['status'];
                      }
                    } else {
                      $qStatus = 0;
                    }
                    if($qStatus == 0){
                        $arr_1 = preg_split ("/\,/", $userMessage);
                        $sql = "UPDATE distance_calc SET lat1='$arr_1[0]',lng1='$arr_1[1]',status=1 WHERE msg_id = '$chatId'";
                        $jk = '0';
                        if ($conn->query($sql) === TRUE) {
                                  $jk = "User input saved successfully";
                        } else {
                                  $jk = "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $result = ">> 2.Send second latitude and longitude by this format(comma separated) : latitude,longitude";
                    }else if($qStatus == 1 ){
                        $arr_2 = preg_split ("/\,/", $userMessage);
                        $sql = "UPDATE distance_calc SET lat2='$arr_2[0]',lng2='$arr_2[1]' WHERE msg_id = '$chatId'";
                        $jk = '0';
                        if ($conn->query($sql) === TRUE) {
                                  $jk = "User input saved successfully";
                        } else {
                                  $jk = "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $lat_1 = '';
                        $lng_1='';

                        $sql = "SELECT lat1,lng1 FROM distance_calc WHERE msg_id='$chatId'";
                            $res = $conn->query($sql);
                                if ($res->num_rows > 0) {
                                   // output data of each row
                                  if($row = $res->fetch_assoc()){
                                    // You can now use $row['user_input'] for your calculations
                                      $lat_1 = $row['lat1'];
                                      $lng_1 = $row['lng1'];
                                  }
                                } else {
                                  $reply = "0";
                                }
                        $locCalculation = haversine_distance($lat_1,$lng_1,$arr_2[0],$arr_2[1]);
                                                $sql = "UPDATE distance_calc SET result='$locCalculation',status=0 WHERE msg_id = '$chatId'";
                                                $jk = '0';
                                                if ($conn->query($sql) === TRUE) {
                                                          $jk = "User input saved successfully";
                                                } else {
                                                          $jk = "Error: " . $sql . "<br>" . $conn->error;
                                                }
                        $result = "Distance is : " . $locCalculation . " Km";
                    }
    }

    $path = $server."/sendmessage?chat_id=$chatId&text=$result";
    file_get_contents($path);
}


function haversine_distance($lat1, $lon1, $lat2, $lon2)
{
  $radius = 6371; // Earth's radius in kilometers

  // Calculate the differences in latitude and longitude
  $delta_lat = $lat2 - $lat1;
  $delta_lon = $lon2 - $lon1;

  // Calculate the central angles between the two points
  $alpha = $delta_lat / 2;
  $beta = $delta_lon / 2;

  // Use the Haversine formula to calculate the distance
  $a = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($beta)) * sin(deg2rad($beta));
  $c = asin(min(1, sqrt($a)));
  $distance = 2 * $radius * $c;

  // Round the distance to four decimal places
  $distance = round($distance, 4);

  return $distance;
}

function postalCodeDis($first,$second){
$origins = $first; // replace with your 90210 postal code
$destinations = $second; // replace with 10001 second postal code

$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$origins&destinations=$destinations&key=AIzaSyDuOdBbNwYOhx4zSYAnPALh3t9rRL_jZVs";

$response = file_get_contents($url);
$data = json_decode($response, true);

if (!empty($data['rows'][0]['elements'][0]['distance'])) {
    $distance = $data['rows'][0]['elements'][0]['distance']['text'];
    echo "The distance between the two postal codes is $distance";
} else {
    echo "Unable to calculate distance";
}

}



?>