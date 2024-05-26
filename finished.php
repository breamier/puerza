<?php
include 'DBConnector.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$workout_id = $_POST['workout_id'];
$status = $_POST['status'];

if($status == 0){
    $sql = "UPDATE workout SET status = '1' WHERE workout_id = $workout_id";
    $conn->query($sql);
} else {
    $sql = "UPDATE workout SET status = '0' WHERE workout_id = $workout_id";
    $conn->query($sql);
}

header("Location: dashboard.php");
exit();
?>