<?php
include 'DBConnector.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$date = date('F d, Y', strtotime($row['birthdate']));

echo "<h3 id='name'>" . $row['first_name'] . " ". $row['last_name'] ."</h3>
<table class='sidenav-prof'>
    <tr>
        <td style='text-align: left;'>Birthdate: </td>
        <td>". $date ."</td>
    </tr>
    <tr>
        <td style='text-align: left;'>Weight: </td>
        <td>". $row['weight'] ." lbs</td>
    </tr>
    <tr>
        <td style='text-align: left;'>Height: </td>
        <td>". $row['height'] ." cm</td>
    </tr>
</table>";
?>