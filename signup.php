<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "final"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


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

    
    $stmt = $conn->prepare("INSERT INTO users (email, password, first_name, last_name, nickname, birthday) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $hashed_password, $fname, $lname, $nickname, $birthday);

   
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