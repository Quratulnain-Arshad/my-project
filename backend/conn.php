<?php
$username="root";
$password="";
$server="localhost";
$dbName="farmease";

$conn = new mysqli($server, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>