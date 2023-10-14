<?php

// @jk_quran_bot

$token = '6683747037:AAFr2QBP_qhxxOfzXX88OQBqCfyN7CssEYI';
$server = "https://api.telegram.org/bot$token";
$webhookAddress = "https://api.telegram.org/bot6683747037:AAFr2QBP_qhxxOfzXX88OQBqCfyN7CssEYI/setWebhook?url=https://isatis.vip/TELEGRAM_BOT/jk_quran_bot.php";

$input = file_get_contents("php://input");
$decodedInput = json_decode($input,true);

$chatId = $decodedInput['message']['chat']['id'];
$message = $decodedInput['message']['text'];

// HI command
if(strpos($message, '/start') === 0){
    $reply = "You are using from JK Quran.You can use the application by click on this link : t.me/jk_quran_bot/tanzil";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}


?>