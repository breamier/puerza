<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$nickname = $_SESSION["nickname"];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Puerza | Profile</title>
        <link rel="stylesheet" type="text/css" href="css/editProfile.css">
        <!--Import Fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <!--Side Bar-->
        <div class="sidenav">
            <h3 class="message">Welcome,
                <?php echo $nickname; ?>!
            </h3>
            <img src="images/default.jpg" id="profile" />
            <a href="#"><button id="edit">Change Picture</button></a>
            <a href="logout.php"><button id="logout">Log Out</button></a>
        </div>

        <!--Main-->
        <div class="main">
            <header>
                <a class="logo" href="dashboard.php"><img src="images/logo2.png"><span>Puerza</span></a>
            </header>
            <h1>Edit Profile</h1>
            
            <!-- <input type="submit" value="Generate Workout" class="submit-button"> -->
        </div>
        

    </body>
</html>