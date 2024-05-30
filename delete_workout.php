<?php
include 'DBConnector.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$workout_id = $_POST['workout_id'];
$type = $_POST['type'];

echo $type;
echo $workout_id;
echo $user_id;

if($type == 1 || $type == 2){
    $sql = "DELETE FROM strengthworkout WHERE workout_id = $workout_id";
    $conn->query($sql);
}

$sql_user_workout = "DELETE FROM user_workout WHERE user_id = $user_id AND workout_id = $workout_id";
    $conn->query($sql_user_workout);

$sql_workout = "DELETE FROM workout WHERE workout_id = $workout_id";
    $conn->query($sql_workout);

header("Location: dashboard.php");

$conn->close();
exit();
?>