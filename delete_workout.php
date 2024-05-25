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
    if($conn->query($sql) === TRUE){
        echo "Deleted from strength";
    }
}

$sql_user_workout = "DELETE FROM user_workout WHERE user_id = $user_id AND workout_id = $workout_id";
if($conn->query($sql_user_workout) === TRUE){
    echo "Deleted from user-workout";
}

$sql_workout = "DELETE FROM workout WHERE workout_id = $workout_id";
if($conn->query($sql_workout) === TRUE){
    echo "Deleted from workout";
}
?>