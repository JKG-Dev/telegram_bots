<?php
// Set your OpenAI API key
$apiKey = "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";

// API endpoint for listing engines
$apiUrl = "https://api.openai.com/v1/engines";

// Set up cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
));

// Execute cURL request and get response
$response = curl_exec($ch);
curl_close($ch);

// Decode and process the response
$result = json_decode($response, true);

if (isset($result['data']) && is_array($result['data'])) {
    foreach ($result['data'] as $engine) {
        echo "Engine: " . $engine['id'] . "\n";
    }
} else {
    echo "No engines found.";
}
?>
