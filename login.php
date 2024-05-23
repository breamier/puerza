<?php
// Start the session
session_start();

// Database connection details
$host = "localhost"; 
$username = "root";
$password = ""; 
$database = "final";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        
        if (password_verify($password, $row["password"])) {
            
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["email"] = $row["email"];

           
            header("Location: welcome1.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();
?>