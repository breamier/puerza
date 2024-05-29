<?php
include 'DBConnector.php';
// Start the session
session_start();

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
            
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["nickname"] = $row["nickname"];

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["error"] = "Invalid email or password";
        }
    } else {
        $_SESSION["error"] = "Invalid email or password";
    }

    $stmt->close();
    if(isset($_SESSION["error"])) {
        echo "<script>alert('" . $_SESSION["error"] . "');</script>";
        unset($_SESSION["error"]);
    }
}

$conn->close();
?>