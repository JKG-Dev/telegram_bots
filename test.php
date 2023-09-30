<style>
body {background-color: #333;font-size: 20px;font-family: Verdana, Geneva, Tahoma, sans-serif;}
pre, p    {color: #CCC;}
</style>

<?php

// $wordEN = "";
// $wordFA = "";

// $url = 'https://www.merriam-webster.com/word-of-the-day';
// $content = file_get_contents($url);
// $dom = new DOMDocument;
// libxml_use_internal_errors(true); // suppress parse errors and warnings
// $dom->loadHTML($content);
// libxml_clear_errors(); // clear any parse errors and warnings
// // get the first <h2> tag
// $paragraphs = $dom->getElementsByTagName('h2');
// if ($paragraphs->length > 0) {
//     $first_paragraph = $paragraphs->item(0);
//     $wordEN = $first_paragraph->nodeValue;
// }

// // translate
// $url = "https://www.ego4u.com/en/cram-up/grammar/simple-past";
// $content = file_get_contents($url);
// $dom = new DOMDocument;
// libxml_use_internal_errors(true); // suppress parse errors and warnings
// $dom->loadHTML($content);
// libxml_clear_errors(); // clear any parse errors and warnings
// // get the first <textarea> tag
// $txtArs = $dom->getElementsByTagName('body')->item(0)->nodeValue;

// // if ($txtArs->length > 0) {
// //     $tr_area = $txtArs->item(1);
// //     $wordFA = $tr_area->nodeValue;
// // }
// // echo $wordEN." = ".$wordFA;

// echo $txtArs;



// // FOOD SAMPLE
// $curl = curl_init();
// $url = "https://world.openfoodfacts.net/api/v3/product/3017620422003";
// curl_setopt($curl, CURLOPT_URL, $url);
// // Set the request method to GET
// curl_setopt($curl, CURLOPT_HTTPGET, true);
// // Set the Accept header to specify JSON response
// curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
// // Set the CURLOPT_RETURNTRANSFER option to true
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// // Execute the cURL request and retrieve the response
// $response = curl_exec($curl);
// // Check for any errors
// if ($response === false) {
//     $error = curl_error($curl);
//     echo "cURL error: " . $error;
//     // Handle the error
// } else {
//     // Decode the JSON response
//     $jsonData = json_decode($response);
//     // Encode the data with JSON_PRETTY_PRINT option for formatting
//     $formattedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
//     // Wrap the JSON string in <pre> tags to preserve formatting
//     $formattedHtml = '<pre>' . htmlspecialchars($formattedJsonString) . '</pre>';
//     // Display the formatted JSON in HTML
//     //echo $formattedHtml;
//     echo '<p> Product Name : ' . $jsonData->product->abbreviated_product_name . '<br />';
//     echo ' Allergens : ' . $jsonData->product->allergens . '<br />';
//     echo ' Brands : ' . $jsonData->product->brands . '<br />';
//     echo ' Categories : ' . $jsonData->product->categories . '<br />';
//     echo ' Countries : ' . $jsonData->product->countries . '<br />';
//     echo ' Countries imported : ' . $jsonData->product->countries_imported . '<br />';
//     echo ' Material : ' . $jsonData->product->ecoscore_data->adjustments->packaging->packagings[0]->material . '<br />';
//     echo ' Warnings : ' . $jsonData->product->ecoscore_extended_data->impact->warnings[0] . '</p>';
// }
// // Close cURL session
// curl_close($curl);


// COCTAIL SAMPLE
    // // Set up cURL
    // $ch = curl_init('https://www.thecocktaildb.com/api/json/v1/1/random.php');
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // // Execute cURL request and get response
    // $response = curl_exec($ch);
    // curl_close($ch);
    // // Decode and process the response
    // $data = json_decode($response, true);
    // echo $response . '<hr />' ;
    // print_r($data['drinks'][0]['strDrink']);
    // print_r($data['drinks'][0]['strInstructions']);


// Key (Thesaurus):
// 3b811154-038e-4087-9b3b-127173d008c4

// Key (Intermediate Dictionary):
// 24f12d18-0121-4f93-a7d6-e58f0913ed5b

$apiKey = '3b811154-038e-4087-9b3b-127173d008c4';
$url = 'https://www.dictionaryapi.com/api/v3/references/thesaurus/json/umpire?key='.$apiKey;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Execute cURL request and get response
    $response = curl_exec($ch);
    curl_close($ch);
    // Decode and process the response
    $data = json_decode($response, true);
    echo $response . '<hr />' ;
    print_r($data[0]['meta']['syns'][0]);
