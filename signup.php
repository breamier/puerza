<?php
include 'DBConnector.php';
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nickname = $_POST['nickname'];
    $birthday = $_POST['birthday'];

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("INSERT INTO users (email, password, first_name, last_name, nickname, birthdate, weight, height, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $email, $hashed_password, $fname, $lname, $nickname, $birthday, $weight, $height, $picture);

    $weight = NULL;
    $height = NULL;
    $picture = 'default.jpg';
   
    if ($stmt->execute()) {
        
        $_SESSION['email'] = $email;
        $_SESSION['loggedin'] = true;

        
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();
}


$conn->close();
?>