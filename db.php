<?php
$servername = "localhost";
$username = "isatisvi_telegram_bot_user";
$password = "jkkREo9WM^pV";
$dbname = "isatisvi_telegram_bot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
