<?php 

// definizione delle credenziali del database
define("DATABASE","ecommerce");
define("SERVERNAME", "localhost");
define("USERNAME","root");
define("PASSWORD","");

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD);

// Check connection
if ($conn->connect_error) {
  die("<br>Connection failed: " . $conn->connect_error);
}
echo "<br>Connected successfully";