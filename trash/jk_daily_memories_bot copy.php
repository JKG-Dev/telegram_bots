<?php
include "db.php";

// @JK_everyday_bot

$apiLink = "https://api.telegram.org/bot6855361182:AAHdQywHAUr_O5xFwOwOzkPGSx2Tfc3Gmgk/";
$update = file_get_contents("php://input");
$updateArray = json_decode($update, TRUE);
$username = $updateArray["message"]["chat"]["username"];
$userID = $updateArray["message"]["chat"]["id"];
$chatID = $updateArray["message"]["chat"]["id"];
$messageText = $updateArray["message"]["text"];

$keyboard = array(
    ["ONE"], ["TWO"], ["THREE"]
);
$resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
$reply = json_encode($resp);

if ($messageText == "/start") {
    $welcomeText = "This is a Simple Bot!";
    file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $welcomeText . "&reply_markup=" . $reply);
	
} else if ($messageText == "ONE") {
    $output = "ONE";
    file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&disable_web_page_preview=true&parse_mode=HTML&reply_markup=" . $reply);
	
} else if ($messageText == "TWO") {
    $output = "TWO";
    file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&disable_web_page_preview=true&parse_mode=HTML&reply_markup=" . $reply);

} else if ($messageText == "THREE") {
    $output = "THREE";
    file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&reply_markup=" . $reply);
	
} else {
    $errorMsg = "You entered a wrong command!";
    file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $errorMsg);
}

/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////






$token = "6356539505:AAEPV8X2bzyuc0jlxDQq_F_WEfp7S0NeEyY";
$server = "https://api.telegram.org/bot$token";
$webhookAddress = "https://api.telegram.org/bot6356539505:AAEPV8X2bzyuc0jlxDQq_F_WEfp7S0NeEyY/setWebhook?url=https://isatis.vip/TELEGRAM_BOT/jk_daily_memories_bot.php";

$updatesJson = file_get_contents("https://api.telegram.org/bot$token/getUpdates");
$updates = json_decode($updatesJson, true);

$input = file_get_contents("php://input");
$decodedInput = json_decode($input, true);
$chatId = $decodedInput["message"]["chat"]["id"];
$message = $decodedInput["message"]["text"];



/*
* TABLE STATUS HINTS *
0 = Default
1 = Ready to send ENGLISH TEXT
2 = Ready to send GERMANY TEXT
*/

/*
* IMAGE STATUS HINTS *
0 = Default
1 = Image proseccID is given
2 = Image proseccID & Image URL are given
3 = Image BLOB & Image proseccID and Image URL are given
*/

foreach ($updates['result'] as $update) {
    // If this update is a callback query
    if (isset($update['callback_query'])) {
        // Get the callback data
        $callback_data = $update['callback_query']['data'];

        // If the callback data is '/english', send a response to the user
        if ($callback_data === '/english') {
            // Define the data for the response
            $data = [
                'chat_id' => $update['callback_query']['message']['chat']['id'],
                'text'    => 'You selected English!',
            ];

            // Send the POST request to the Telegram Bot API
            $response = file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));

            // You can handle the response here
        }
    }
}


// Commands
if (strpos($message, "/start") === 0) {
    $keyboard = array(
        "inline_keyboard" => array(
            array(
                array(
                    "text" => "English",
                    "callback_data" => "/english"
                ),
                array(
                    "text" => "Deutsch",
                    "callback_data" => "callback_data_2"
                )
            )
        )
    );
    $replyMarkup = json_encode($keyboard);

    // $path = $server . "/sendmessage?chat_id=$chatId&text=Please select your language from the menu /english or /deutsch.";
    // file_get_contents($path);
    // $path = $server . "/sendmessage?chat_id=$chatId&text=Bitte wählen Sie Ihre Sprache aus dem Menü /english oder /deutsch aus.";
    // file_get_contents($path);

    $data = array(
        'chat_id' => "$chatId",
        'text' => "Your message",
        'reply_markup' => $replyMarkup
    );
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
    
} elseif (strpos($message, "/english") === 0) {
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id,status,en_txt FROM daily_memories WHERE msg_id='$chatId' AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00' ";
    $res = $conn->query($sql);
    $enRes = "Please write your text and send it in one message";
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $id = $row["id"];
        $qRes = "0";
        $sql = "UPDATE daily_memories SET status=1 WHERE id=$id";
        if ($conn->query($sql) === true) {
            $qRes = "User input saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
        if ($row["en_txt"] != "") {
            $enRes =
                "You wrote text today, if you send a new text it will replace";
        }
    } else {
        $qRes = "0";
        $sql = "INSERT INTO daily_memories(msg_id,status) VALUES ('$chatId',1)";
        if ($conn->query($sql) === true) {
            $qRes = "User input saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $path = $server . "/sendmessage?chat_id=$chatId&text=$enRes";
    file_get_contents($path);
} elseif (strpos($message, "/deutsch") === 0) {
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id,status,gr_txt FROM daily_memories WHERE msg_id='$chatId' AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00' ";
    $res = $conn->query($sql);
    $grRes =
        "Bitte schreiben Sie Ihren Text und senden Sie ihn in einer Nachricht";
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $id = $row["id"];
        $qRes = "0";
        $sql = "UPDATE daily_memories SET status=2 WHERE id=$id";
        if ($conn->query($sql) === true) {
            $qRes = "User input saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
        if ($row["gr_txt"] != "") {
            $grRes =
                "Sie haben heute einen Text geschrieben. Wenn Sie einen neuen Text senden, wird dieser ersetzt";
        }
    } else {
        $qRes = "0";
        $sql = "INSERT INTO daily_memories(msg_id,status) VALUES ('$chatId',1)";
        if ($conn->query($sql) === true) {
            $qRes = "User input saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $path = $server . "/sendmessage?chat_id=$chatId&text=$grRes";
    file_get_contents($path);
    // GET GENERATED PHOTOS
} elseif (strpos($message, "/generatephotos") === 0) {
  $response = "Try agin later";
    $sql = "SELECT id, image_process_id FROM daily_memories WHERE msg_id='$chatId' AND image_status=1";
    $result = $conn->query($sql);  
    if ($result->num_rows > 0) {
        $records = $result->fetch_all(MYSQLI_ASSOC);
    } else {
      $response = "0 result";
    }
    foreach ($records as $row) {
     getGeneratedImage($row["image_process_id"],$row["id"],$conn);
    }

    $path =
        $server .
        "/sendmessage?chat_id=$chatId&text=Your photos successfully generated up to now.";
    file_get_contents($path);
    // EXPORT DATA
} elseif (strpos($message, "/export") === 0) {
    $path =
        $server .
        "/sendmessage?chat_id=$chatId&text=UNDER CUNSTRUCTION, contact : javadkarimi@gmail.com";
    file_get_contents($path);
} else {
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id,status FROM daily_memories WHERE msg_id='$chatId' AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00' ";
    $res = $conn->query($sql);
    $txtRes = "CLICK on /start";
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $id = $row["id"];
        $status = $row["status"];
        // ENGLISH TEXT
        if ($status === "1") {
            $qRes = "0";
            $sql = "UPDATE daily_memories SET en_txt='$message',status=0 WHERE id=$id";
            if ($conn->query($sql) === true) {
                $qRes = "saved successfully";
            } else {
                $qRes = "Error: " . $sql . "<br>" . $conn->error;
            }
            $txtRes = "Your text is saved successfully";
            // GENERATE IMAGE BASED ON MY TEXT
            generateImage($message, $id, $conn);
        }
        // GERMANY TEXT
        if ($status === "2") {
            $qRes = "0";
            $sql = "UPDATE daily_memories SET gr_txt='$message',status=0 WHERE id=$id";
            if ($conn->query($sql) === true) {
                $qRes = "User input saved successfully";
            } else {
                $qRes = "Error: " . $sql . "<br>" . $conn->error;
            }
            $txtRes = "Ihr Text wurde erfolgreich gespeichert";
            // GENERATE IMAGE BASED ON MY TEXT
            generateImage($message, $id, $conn);
        }
    }
    $path = $server . "/sendmessage?chat_id=$chatId&text=$txtRes";
    file_get_contents($path);
}

// TEXT TO IMAGE API (https://monsterapi.ai/)
function generateImage($prompt, $dbId, $cn)
{
    $url = "https://api.monsterapi.ai/v1/generate/sdxl-base";
    $data = [
        "prompt" => '$prompt',
        "style" => "anime",
    ];
    $jsonPayload = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "accept: application/json",
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IjE2NGJmN2QxZDg3NjgxMDcxN2Y2NTNhMTY3OTZhMWMxIiwiY3JlYXRlZF9hdCI6IjIwMjMtMTAtMThUMDU6Mzg6MDUuODg4MzkzIn0.osZjoZlry21Bcy5gIhd0Xwo0aSLQb-vCUr9-vlITFKo",
        "content-type: application/json",
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
    }
    curl_close($ch);
    $responseArray = json_decode($response, true);
    $processId = $responseArray["process_id"];
    // SET PROCESS ID INTO DB
    $qRes = "0";
    $sql = "UPDATE daily_memories SET image_process_id='$processId',image_status=1 WHERE id=$dbId";
    if ($cn->query($sql) === true) {
        $qRes = "saved successfully";
    } else {
        $qRes = "Error: " . $sql . "<br>" . $cn->error;
    }
}

// GET GENERATED PHOTO
function getGeneratedImage($processId, $dbId, $cn)
{
    $curl = curl_init();
    $apiUrl = "https://api.monsterapi.ai/v1/status/" . $processId;
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "accept: application/json",
        "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IjE2NGJmN2QxZDg3NjgxMDcxN2Y2NTNhMTY3OTZhMWMxIiwiY3JlYXRlZF9hdCI6IjIwMjMtMTAtMThUMDU6Mzg6MDUuODg4MzkzIn0.osZjoZlry21Bcy5gIhd0Xwo0aSLQb-vCUr9-vlITFKo",
    ]);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        echo "Error: " . curl_error($curl);
    }
    curl_close($curl);
    $responseArray = json_decode($response, true);
    $firstOutputUrl = $responseArray["result"]["output"][0];
    // SET PHOTO URL IN DB
    $qRes = "0";
    $sql = "UPDATE daily_memories SET image_url='$firstOutputUrl',image_status=2 WHERE id=$dbId";
    if ($cn->query($sql) === true) {
        $qRes = "saved successfully";
    } else {
        $qRes = "Error: " . $sql . "<br>" . $cn->error;
    }
}

?>
