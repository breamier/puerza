<?php
include 'DBConnector.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $nickname = $_POST['nickname'];
    $birthdate = $_POST['birthdate'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $picture = $_POST['picture'];


    $sql = "UPDATE users SET first_name = ?, last_name = ?, nickname = ?, birthdate = ?, weight = ?, height = ?, picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdssi", $first_name, $last_name, $nickname, $birthdate, $weight, $height, $picture, $user_id);

    if ($stmt->execute()) {
        $_SESSION["nickname"] = $nickname;
        header("Location: editProfile.php?status=success");
    } else {

        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
