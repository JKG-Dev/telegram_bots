<!-- <html>
    <body>
        <div style="width: auto;">
            <table style="width: auto;">
                <tr>
                    <td>EN</td>
                    <td>GR</td>
                </tr>
            </table>
        </div>
    </body>
</html> -->
<?php
$servername = "localhost";
$username = "isatisvi_telegram_bot_user";
$password = "jkkREo9WM^pV";
$dbname = "isatisvi_telegram_bot";

// Create connection
$cn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($cn->connect_error) {
  die("Connection failed: " . $cn->connect_error);
}

echo "START \n";
$prompt="i love dogs";

$url = 'https://api.monsterapi.ai/v1/generate/sdxl-base';
    $data = array(
        'prompt' => '$prompt',
        'style' => 'anime'
    );
    $jsonPayload = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IjE2NGJmN2QxZDg3NjgxMDcxN2Y2NTNhMTY3OTZhMWMxIiwiY3JlYXRlZF9hdCI6IjIwMjMtMTAtMThUMDU6Mzg6MDUuODg4MzkzIn0.osZjoZlry21Bcy5gIhd0Xwo0aSLQb-vCUr9-vlITFKo',
        'content-type: application/json'
    ));
    $response = curl_exec($ch);
    if(curl_errno($ch)){
        echo 'Error: ' . curl_error($ch);
    }
    curl_close($ch);
    $responseArray = json_decode($response, true);
    $processId = $responseArray['process_id'];
    echo "GET FIRST ".$processId."\n";
    // GET GENERATED PHOTO
    $apiUrl = 'https://api.monsterapi.ai/v1/status/'.$processId;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IjE2NGJmN2QxZDg3NjgxMDcxN2Y2NTNhMTY3OTZhMWMxIiwiY3JlYXRlZF9hdCI6IjIwMjMtMTAtMThUMDU6Mzg6MDUuODg4MzkzIn0.osZjoZlry21Bcy5gIhd0Xwo0aSLQb-vCUr9-vlITFKo',
    ));
    $response = curl_exec($curl);
    echo "RESPONSE IS :".$response."\n";
    if(curl_errno($curl)){
        echo 'Error: ' . curl_error($curl);
    }
    curl_close($curl);
    $responseArray = json_decode($response, true);
    $firstOutputUrl = $responseArray['result']['output'][0];
    echo "RESULT IS :".$firstOutputUrl."\n";
    // SET PHOTO URL IN DB
    $qRes = "0";
    $sql = "UPDATE daily_memories SET other='$firstOutputUrl' WHERE id=4";    
    if ($cn->query($sql) === TRUE) {
      $qRes = "saved successfully";
    } else {
      $qRes = "Error: " . $sql . "<br>" . $cn->error;
    }

    echo "SAVED IN DB :".$firstOutputUrl;