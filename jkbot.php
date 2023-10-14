<?php

// @JK_tools_bot

$token = '6393368167:AAF5e6UyKH1G-OFjDiDK84LlFcYWujd4tbw';
$server = "https://api.telegram.org/bot$token";

$input = file_get_contents("php://input");
$decodedInput = json_decode($input,true);

$chatId = $decodedInput['message']['chat']['id'];
$message = $decodedInput['message']['text'];

// HI command
if(strpos($message, '/start') === 0){
    $reply = "You are using from JK BoT now.";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}

// IMAGE command
if(strpos($message, '/image') === 0){
    // $photoStr = "https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png";
    // curl($server."/sendPhoto",['chat_id'=>$chatId,'photo'=>$photoStr]);

    curl($server."/sendPhoto",['chat_id'=>$chatId,'caption'=>'Send PICs👍','photo'=>new CURLFile(realpath('jk.jpg'))]);
}

// TIME command
if(strpos($message, '/time') === 0){
    // Set the timezone to Tehran
        date_default_timezone_set("Asia/Tehran");
    // Get the current time
        $time = time();
    // Format the time
        $formattedTime = date("Y/m/d H:i:s", $time);        
    $reply = "The Date and Time in Tehran is " . $formattedTime . ".";
    $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
    file_get_contents($path);
}

// DRINK command
if(strpos($message, '/drink') === 0){
    $ch = curl_init('https://www.thecocktaildb.com/api/json/v1/1/random.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);

    $contents = $data['drinks'][0]['strIngredient1']." +".$data['drinks'][0]['strIngredient2']." +".$data['drinks'][0]['strIngredient3']." +".$data['drinks'][0]['strIngredient4']." +".$data['drinks'][0]['strIngredient5']." +".$data['drinks'][0]['strIngredient6']." +".$data['drinks'][0]['strIngredient7']." +".$data['drinks'][0]['strIngredient8']." +".$data['drinks'][0]['strIngredient9']." +".$data['drinks'][0]['strIngredient10']." +".$data['drinks'][0]['strIngredient11']." +".$data['drinks'][0]['strIngredient12']." +".$data['drinks'][0]['strIngredient13']." +".$data['drinks'][0]['strIngredient14']." +".$data['drinks'][0]['strIngredient15'];
    $contents = rtrim($contents, "+");

        $reply = 'Name : ' . $data['drinks'][0]['strDrink'];
        $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
        file_get_contents($path);
        $reply = 'Category : ' . $data['drinks'][0]['strCategory'];
        $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
        file_get_contents($path);
        $reply = 'Is Alcoholic : ' . $data['drinks'][0]['strAlcoholic'];
        $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
        file_get_contents($path);
        $reply = 'Glass type : ' . $data['drinks'][0]['strGlass'];
        $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
        file_get_contents($path);
        $reply = 'Instruction : ' . $data['drinks'][0]['strInstructions'];
        $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
        file_get_contents($path);
        $reply = 'Ingredient : ' . $contents;
        $path = $server."/sendmessage?chat_id=$chatId&text=$reply";
        file_get_contents($path);

        $photoStr = $data['drinks'][0]['strDrinkThumb'];
        curl($server."/sendPhoto",['chat_id'=>$chatId,'photo'=>$photoStr]);
}


function curl($url,$vars){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_HEADER,'Content-Type: multipart/form-data');
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
    curl_exec($ch);
}



?>