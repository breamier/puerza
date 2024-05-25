<?php
// Start the session
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}


$user_id = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, User ID: <?php echo htmlspecialchars($user_id); ?>!</h1>
    <p>You have successfully logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
