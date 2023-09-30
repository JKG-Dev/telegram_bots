<?php

$token = '6498430542:AAG6lDXSApjd3mRm2afCFX4FZmCB53T_io0';
$server = "https://api.telegram.org/bot$token";
$webhookAddress = "https://api.telegram.org/bot6498430542:AAG6lDXSApjd3mRm2afCFX4FZmCB53T_io0/setWebhook?url=https://isatis.vip/TELEGRAM_BOT/jkEnBot.php";

$input = file_get_contents("php://input");
$decodedInput = json_decode($input,true);

$chatId = $decodedInput['message']['chat']['id'];
$message = $decodedInput['message']['text'];

// GPT
$gptResponse = "Start";
function jkGpt(){
    // Set your OpenAI API key
    $apiKey = "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";
    // API endpoint
    $apiUrl = "https://api.openai.com/v1/engines/davinci/completions";
    // Data to send in the request
    $data = array(
        'prompt' => 'hello',
        'max_tokens' => 50
    );
    $gptResponse = "all data set";
    // Set up cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ));
    $gptResponse = "curl defined";
    // Execute cURL request and get response
    $response = curl_exec($ch);
    $gptResponse = "curl executed";
    curl_close($ch);
    $gptResponse = "curl closed";
    // Decode and process the response
    $result = json_decode($response, true);
    $gptResponse = "result decoded";
    if (isset($result['choices'][0]['text'])) {
        $gptResponse = $result['choices'][0]['text'];
    } else {
        $gptResponse = "No response received.";
    }
}


// Start command
if(strpos($message, '/start') === 0){
    $reply = "You are using from JK English BoT now.";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}else if(strpos($message, '/translate') === 0){
    $reply = urlencode("Enter your word and send");  
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}else{
    $json = file_get_contents("php://input");
    $update = json_decode($json, true);
    $userMessage = $update["message"]["text"];
    // TRANSLATE IT
    $apiKey = '3b811154-038e-4087-9b3b-127173d008c4';
    $url = 'https://www.dictionaryapi.com/api/v3/references/thesaurus/json/'.$userMessage.'?key='.$apiKey;    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
    $result = $data[0]['meta']['syns'][0][0];
    $path = $server."/sendmessage?chat_id=$chatId&text=$result";
    file_get_contents($path);
}

// // help command
// if(strpos($message, '/help') === 0){
//     // $reply1 = urlencode("You can use this bot to learn English tenses.\nAs you know we have 12 tenses in English language and the structute of using this bot is described below with several commands.");
//     // $reply2 = urlencode("/p : ");   
//         if(jkGpt()){
//             $path = $server."/sendmessage?chat_id=$chatId&text=$gptResponse";
//             file_get_contents($path);
//         }else{
//             $path = $server."/sendmessage?chat_id=$chatId&text=$gptResponse";
//             file_get_contents($path);
//         }
// }


?>