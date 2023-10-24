<?php
include "db.php";

// @JK_everyday_bot
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

// MY Webhook Address = "https://api.telegram.org/bot6356539505:AAF-UOyPFPeGzLVAz53JmxaChCXEK5fGNlk/setWebhook?url=https://isatis.vip/TELEGRAM_BOT/jk_daily_memories_bot.php";

$token = "6356539505:AAF-UOyPFPeGzLVAz53JmxaChCXEK5fGNlk";
$server = "https://api.telegram.org/bot$token/";
$update = file_get_contents("php://input");
$updateArray = json_decode($update, TRUE);
$username = $updateArray["message"]["chat"]["username"];
$chatID = $updateArray["message"]["chat"]["id"];
$messageText = $updateArray["message"]["text"];


if ($messageText == "/start") {
    $keyboard = array(
        ["English"], ["Deutsch"]
    );
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    $welcomeText = "With this bot, you can send your everyday events and also generate a photo based on your text. %0AAfter a while, you can export them as an illustrated diary. %0ATo start please your language from the below menu, you can send English text and Deutsch text every day. %0A%0AThis bot is designed and developed to improve English and Deutsch knowledge by JavadKarimi@gmail.com";
    file_get_contents($server . "sendmessage?chat_id=$chatID&text=" . $welcomeText . "&reply_markup=" . $reply);	
} else if ($messageText == "English" || $messageText == "/english") {
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id,status,en_txt FROM daily_memories WHERE msg_id='$chatID' AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00' ";
    $res = $conn->query($sql);
    $enRes = "Please write your text and send it in one message";
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $id = $row["id"];
        $qRes = "0";
        $sql = "UPDATE daily_memories SET status=1 WHERE id=$id";
        if ($conn->query($sql) === true) {
            $qRes = "saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
        if ($row["en_txt"] != "") {
            $enRes =
                "You wrote text today, if you send a new text it will replace";
        }
    } else {
        $qRes = "0";
        $sql = "INSERT INTO daily_memories(msg_id,status) VALUES ('$chatID',1)";
        if ($conn->query($sql) === true) {
            $qRes = "saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $path = $server . "sendmessage?chat_id=$chatID&text=$enRes";
    file_get_contents($path);
} else if ($messageText == "Deutsch" || $messageText == "/deutsch") {
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id,status,gr_txt FROM daily_memories WHERE msg_id='$chatID' AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00' ";
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
        $sql = "INSERT INTO daily_memories(msg_id,status) VALUES ('$chatID',1)";
        if ($conn->query($sql) === true) {
            $qRes = "User input saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $path = $server . "sendmessage?chat_id=$chatID&text=$grRes";
    file_get_contents($path);
} else if ($messageText == "MyPhoto") {
    $respnseText = "Try agin later";
    $imageUrl = "";
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id, image_process_id FROM daily_memories WHERE msg_id='$chatID' AND image_status=1 AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00'";
    $result = $conn->query($sql);  
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $imageProcessId = $row["image_process_id"];
        $imageUrl = getGeneratedImage($imageProcessId,$id,$conn);
    } else {
      $respnseText = "NO result";
    }
    if($imageUrl == ""){
        $respnseText = "Your photo is not ready yet, Please try again later.";
        $path = $server . "sendmessage?chat_id=$chatID&text=$respnseText";
        file_get_contents($path);        
    }else{
        $keyboard = array(["English"], ["Deutsch"], ["StoryBook"]);
        $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
        $reply = json_encode($resp);
        $respnseText = "Relevant photo based on your text!%0A$imageUrl";
        file_get_contents($server . "sendmessage?chat_id=$chatID&text=".$respnseText."&reply_markup=" . $reply);
    }
} else if ($messageText == "Back") {
    $keyboard = array(["English"], ["Deutsch"], ["StoryBook"]);
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    $backText = "Please select your language to send your today event(s).";
    file_get_contents($server . "sendmessage?chat_id=$chatID&text=".$backText."&reply_markup=" . $reply);
} else if ($messageText == "StoryBook") {
    $records;
    $bookstoryHtmlLink="";
    $sql = "SELECT DATE_FORMAT(date, '%D %M %Y') date, en_txt,gr_txt,image_url FROM daily_memories WHERE msg_id='$chatID'";
    $result = $conn->query($sql);  
    if ($result->num_rows > 0) {
        $records = $result->fetch_all(MYSQLI_ASSOC);
        $bookstoryHtmlLink = exportBook($chatID,$records,$conn);
    } else {
      $bookstoryHtmlLink = "No result";
    }
    $keyboard = array(["English"], ["Deutsch"], ["StoryBook"]);
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    $exportText = "Your book story is generated and you can use it by this link : $bookstoryHtmlLink";
    file_get_contents($server . "sendmessage?chat_id=$chatID&text=".$exportText."&reply_markup=" . $reply);
} else {
    $currentDate = date("Y-m-d");
    $currentDatePlus = date("Y-m-d", strtotime("+1 day"));
    $sql = "SELECT id,status FROM daily_memories WHERE msg_id='$chatID' AND date>='$currentDate 00:00:00' AND date<'$currentDatePlus 00:00:00' ";
    $res = $conn->query($sql);
    $txtRes = "Wrong input or command,go to /start";
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $id = $row["id"];
        $status = $row["status"];
        // ENGLISH TEXT
        if ($status === "1") {
            $qRes = "0";
            $sql = "UPDATE daily_memories SET en_txt='$messageText',status=0 WHERE id=$id";
            if ($conn->query($sql) === true) {
                $qRes = "saved successfully";
            } else {
                $qRes = "Error: " . $sql . "<br>" . $conn->error;
            }
            $txtRes = "Your text is saved successfully and a relevant photo based on your text is generated. %0AIf you want to view it select 'MyPhoto' from the menu, otherwise, you can back to the main menu.";
        }
        // GERMANY TEXT
        if ($status === "2") {
            $qRes = "0";
            $sql = "UPDATE daily_memories SET gr_txt='$messageText',status=0 WHERE id=$id";
            if ($conn->query($sql) === true) {
                $qRes = "saved successfully";
            } else {
                $qRes = "Error: " . $sql . "<br>" . $conn->error;
            }
            $txtRes = "Ihr Text wurde erfolgreich gespeichert und ein relevantes Foto basierend auf Ihrem Text wird generiert. %0AWenn Sie es anzeigen möchten, wählen Sie im Menü „MyPhoto“. Andernfalls können Sie zum Hauptmenü zurückkehren.";            
        }
        // GENERATE IMAGE BASED ON MY TEXT
        generateImage($messageText, $id, $conn);        
    }    
    $keyboard = array(["MyPhoto"], ["Back"]);
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($server . "sendmessage?chat_id=$chatID&text=" . $txtRes . "&disable_web_page_preview=true&parse_mode=HTML&reply_markup=" . $reply);
}

// TEXT TO IMAGE API (https://monsterapi.ai/)
function generateImage($prompt, $dbId, $cn)
{
    $url = "https://api.monsterapi.ai/v1/generate/sdxl-base";
    $data = [
        "prompt" => '$prompt',
        "style" => "enhance",
    ];
    $jsonPayload = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);    
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
    $firstOutputUrl = "";
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
    if($firstOutputUrl != ''){
        $qRes = "0";
        $sql = "UPDATE daily_memories SET image_url='$firstOutputUrl',image_status=2 WHERE id=$dbId";
        if ($cn->query($sql) === true) {
            $qRes = "saved successfully";
        } else {
            $qRes = "Error: " . $sql . "<br>" . $cn->error;
        }
    }
    return $firstOutputUrl;
}


function exportBook($folderName,$data,$cn){
    $htmlAddress = "";
    $createFolder = true; 
    if (!file_exists('storyBooks/')){
        if (!file_exists('storyBooks/'.$folderName)) {
            $folderExistFlag = true;
        }else{
            $folderExistFlag = false;
        }
    }else{
        if (!file_exists('storyBooks/'.$folderName)) {
            $folderExistFlag = true;
        }else{
            $folderExistFlag = false;
        }
    }
    if ($createFolder) {
        mkdir('storyBooks/'.$folderName, 0777, true);
    }
        copy('bg.webp', 'storyBooks/'.$folderName.'/bg.webp');
        $myFile = 'storyBooks/'.$folderName.'/index.html';
        $fh = fopen($myFile, 'w');
        $stringData = "<html><head><title>StoryBook</title><style>body {font-family: Arial, sans-serif;margin: 0;padding: 0;background-color: #000000;background-image: url(bg.webp);}.book {width: 60%;margin: 40px auto;padding: 20px;background-color: #fff;box-shadow: 0px 0px 20px rgba(0,0,0,0.1);}.chapter {margin-bottom: 30px;}.chapter h2 {margin-bottom: 20px;}.chapter img {max-width: 100%;margin-bottom: 10px;}.chapter .language {display: flex;justify-content: space-between;margin-bottom: 10px;}.chapter .language p {flex: 1;margin: 0;}</style><style>.book {background-color:rgb(241 249 255 / 0%);}.chapter {background-color: rgba(255, 255, 255, 0.5);padding: 20px;border-radius: 10px;text-align: center;}.chapter img {border-radius: 5px;}</style></head><body><div class='book'><h1 style='color: #fff;text-align: center;'>.:: Story Book ::.</h1>";            
            foreach ($data as $row) {
                $eventDate = $row["date"];
                $eventEnglishText = $row["en_txt"];
                $eventDeutschText = $row["gr_txt"];
                $eventImageUrl = $row["image_url"];
                $stringData = $stringData . "<div class='chapter'><h2 style='color: cornsilk;'>$eventDate</h2><img src='$eventImageUrl' alt='$eventImageUrl' style='opacity: 0.8;'><div class='language'><p style='color: #333;text-align: justify;margin: 5px;background-color: rgb(255 252 241 / 60%);padding: 5px;border-radius: 5px;'>$eventEnglishText</p><p style='color: #333;text-align: justify;margin: 5px;background-color: rgb(241 249 255 / 60%);padding: 5px;border-radius: 5px;'>$eventDeutschText</p></div></div>";            
            }
        $stringData = $stringData . "</div></body></html>";
        fwrite($fh, $stringData);
        fclose($fh);
        $htmlAddress = "https://isatis.vip/TELEGRAM_BOT/storyBooks/$folderName";
    
    return $htmlAddress;
}

/*

function getAllGeneratedPhotos(){
      $response = "Try agin later";
    $sql = "SELECT id, image_process_id FROM daily_memories WHERE msg_id='$chatID' AND image_status=1";
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
        "sendmessage?chat_id=$chatID&text=Your photos successfully generated up to now.";
    file_get_contents($path);
}

*/
?>
