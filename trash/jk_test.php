<?php


$htmlAddress = "LINK";
$folderName = "101928217";

if (!file_exists('storyBooks/')){
    if (!file_exists('storyBooks/'.$folderName)) {
        mkdir('storyBooks/'.$folderName, 0777, true);
        $myFile = 'storyBooks/'.$folderName.'/index.html';
        $fh = fopen($myFile, 'w');
        $stringData = "<html><head><title>$folderName</title><style>body {font-family: Arial, sans-serif;margin: 0;padding: 0;background-color: #000000;}.book {width: 60%;margin: 40px auto;padding: 20px;background-color: #fff;box-shadow: 0px 0px 20px rgba(0,0,0,0.1);}.chapter {margin-bottom: 30px;}.chapter h2 {margin-bottom: 20px;}.chapter img {max-width: 100%;margin-bottom: 10px;}.chapter .language {display: flex;justify-content: space-between;margin-bottom: 10px;}.chapter .language p {flex: 1;margin: 0;}</style><style>.book {background-image: url('story_bg.jpg');background-size: cover;background-position: center;border-radius: 20px;}.chapter {background-color: rgba(255, 255, 255, 0.8);padding: 20px;border-radius: 10px;}.chapter img {border-radius: 5px;}</style></head><body><div class='book'><h1 style='color: #fff;'>$folderName Story Book</h1>";
        $stringData = $stringData . "</div></body></html>";
        fwrite($fh, $stringData);
        fclose($fh);
        $htmlAddress = "https://isatis.vip/TELEGRAM_BOT/storyBooks/$folderName";
        echo $htmlAddress;
    }else{
        $myFile = 'storyBooks/'.$folderName.'/index.html';
        $fh = fopen($myFile, 'w');
        $stringData = "<html><head><title>JK</title><style>body {font-family: Arial, sans-serif;margin: 0;padding: 0;background-color: #000000;}.book {width: 60%;margin: 40px auto;padding: 20px;background-color: #fff;box-shadow: 0px 0px 20px rgba(0,0,0,0.1);}.chapter {margin-bottom: 30px;}.chapter h2 {margin-bottom: 20px;}.chapter img {max-width: 100%;margin-bottom: 10px;}.chapter .language {display: flex;justify-content: space-between;margin-bottom: 10px;}.chapter .language p {flex: 1;margin: 0;}</style><style>.book {background-image: url('story_bg.jpg');background-size: cover;background-position: center;border-radius: 20px;}.chapter {background-color: rgba(255, 255, 255, 0.8);padding: 20px;border-radius: 10px;}.chapter img {border-radius: 5px;}</style></head><body><div class='book'><h1 style='color: #fff;'>JK Story Book</h1>";
        $stringData = $stringData . "</div></body></html>";
        fwrite($fh, $stringData);
        fclose($fh);
        $htmlAddress = "https://isatis.vip/TELEGRAM_BOT/storyBooks/$folderName";
        echo $htmlAddress;
    }
}else{
    if (!file_exists('storyBooks/'.$folderName)) {
        mkdir('storyBooks/'.$folderName, 0777, true);
        $myFile = 'storyBooks/'.$folderName.'/index.html';
        $fh = fopen($myFile, 'w');
        $stringData = "<html><head><title>$folderName</title><style>body {font-family: Arial, sans-serif;margin: 0;padding: 0;background-color: #000000;}.book {width: 60%;margin: 40px auto;padding: 20px;background-color: #fff;box-shadow: 0px 0px 20px rgba(0,0,0,0.1);}.chapter {margin-bottom: 30px;}.chapter h2 {margin-bottom: 20px;}.chapter img {max-width: 100%;margin-bottom: 10px;}.chapter .language {display: flex;justify-content: space-between;margin-bottom: 10px;}.chapter .language p {flex: 1;margin: 0;}</style><style>.book {background-image: url('story_bg.jpg');background-size: cover;background-position: center;border-radius: 20px;}.chapter {background-color: rgba(255, 255, 255, 0.8);padding: 20px;border-radius: 10px;}.chapter img {border-radius: 5px;}</style></head><body><div class='book'><h1 style='color: #fff;'>$folderName Story Book</h1>";
        $stringData = $stringData . "</div></body></html>";
        fwrite($fh, $stringData);
        fclose($fh);
        $htmlAddress = "https://isatis.vip/TELEGRAM_BOT/storyBooks/$folderName";
        echo $htmlAddress;
    }else{
        $myFile = 'storyBooks/'.$folderName.'/index.html';
        $fh = fopen($myFile, 'w');
        $stringData = "<html><head><title>JK</title><style>body {font-family: Arial, sans-serif;margin: 0;padding: 0;background-color: #000000;}.book {width: 60%;margin: 40px auto;padding: 20px;background-color: #fff;box-shadow: 0px 0px 20px rgba(0,0,0,0.1);}.chapter {margin-bottom: 30px;}.chapter h2 {margin-bottom: 20px;}.chapter img {max-width: 100%;margin-bottom: 10px;}.chapter .language {display: flex;justify-content: space-between;margin-bottom: 10px;}.chapter .language p {flex: 1;margin: 0;}</style><style>.book {background-image: url('story_bg.jpg');background-size: cover;background-position: center;border-radius: 20px;}.chapter {background-color: rgba(255, 255, 255, 0.8);padding: 20px;border-radius: 10px;}.chapter img {border-radius: 5px;}</style></head><body><div class='book'><h1 style='color: #fff;'>JK Story Book</h1>";
        $stringData = $stringData . "</div></body></html>";
        fwrite($fh, $stringData);
        fclose($fh);
        $htmlAddress = "https://isatis.vip/TELEGRAM_BOT/storyBooks/$folderName";
        echo $htmlAddress;
    }
}




// $apiLink = "https://api.telegram.org/bot6855361182:AAHdQywHAUr_O5xFwOwOzkPGSx2Tfc3Gmgk/";
// $update = file_get_contents("php://input");
// $updateArray = json_decode($update, TRUE);
// $username = $updateArray["message"]["chat"]["username"];
// $userID = $updateArray["message"]["chat"]["id"];
// $chatID = $updateArray["message"]["chat"]["id"];
// $messageText = $updateArray["message"]["text"];



// if ($messageText == "/start") {
//     $keyboard = array(
//         ["ONE"], ["TWO"], ["THREE"]
//     );
//     $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
//     $reply = json_encode($resp);
//     $welcomeText = "This is a Simple Bot!";
//     file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $welcomeText . "&reply_markup=" . $reply);
	
// } else if ($messageText == "ONE") {
//     $keyboard = array(
//         ["JK"], ["JJ"]
//     );
//     $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
//     $reply = json_encode($resp);
//     $output = "ONE";
//     file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&disable_web_page_preview=true&parse_mode=HTML&reply_markup=" . $reply);
	
// } else if ($messageText == "TWO") {
//     $output = "TWO";
//     file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&disable_web_page_preview=true&parse_mode=HTML&reply_markup=" . $reply);

// } else if ($messageText == "THREE") {
//     $output = "THREE";
//     file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&reply_markup=" . $reply);
	
// } else if ($messageText == "JK") {
//     $output = "JAVAD";
//     file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $output . "&reply_markup=" . $reply);
	
// } else {
//     $errorMsg = "You entered a wrong command!";
//     file_get_contents($apiLink . "sendmessage?chat_id=$chatID&text=" . $errorMsg);
// }
?>