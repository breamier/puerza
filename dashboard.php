<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$nickname = $_SESSION["nickname"];

if(isset($_GET['date'])) {
    $current_date = $_GET['date'];
} else {
    $current_date = date("Y-m-d");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Puerza | Profile</title>
        <link rel="stylesheet" type="text/css" href="css/dashboard.css">
        <!--Import Fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <!--Side Bar-->
        <div class="sidenav">
            <h2 id="welcome">Welcome, <?php echo $nickname; ?>!</h2>
            <img src="images/default.jpg" id="profile"/>
            <?php
                include 'showProfile.php';
            ?>
            <a href="editProfile.php" ><button id="edit">Edit Profile</button></a>
            <a href="logout.php"><button id="logout">Log Out</button></a>
        </div>

        <!--Main-->
        <div class="main">
            <header>
                <a class="logo" href="#"><img src="images/logo2.png"><span>Puerza</span></a>
            </header>

            <form action="generator.php" method="get" style="float: right; height: 0px;">
                <input type="submit" value="Generate Workout" class="submit-button">
            </form>
            <br>

            <h1>Dashboard</h1><br>

                <form action="dashboard.php" method="get" style="float: right;">
                        <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($current_date . ' +1 day')); ?>">
                        <input type="submit" value=">" class="submit-button">
                </form>
                <form action="dashboard.php" method="get" style="float: left;">
                    <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($current_date . ' -1 day')); ?>">
                    <input type="submit" value="<" class="submit-button">
                </form>
                <br>

            
            <?php
            include 'display.php';
            ?>
        </div>
    </body>
</html>