<?php
include 'DBConnector.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];
extract($_POST);

$sql = "INSERT INTO `contact`(`name`, `email`, `phone`, `subject`, `message`)
    VALUES ('$name', '$email', '$phone', '$subject', '$message')";

// if($conn->query($sql)===TRUE){
//     // echo "Message sent";
// }

$conn->close();
?>