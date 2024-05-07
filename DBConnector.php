<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("Connection failes: ".$conn->connect_error);
} else {
    echo "Connected successfully!";
}

$conn->close();
?>