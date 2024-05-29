<?php
include 'DBConnector.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];


// SQL query to fetch user details
$sql = "SELECT first_name, last_name, nickname, birthdate, weight, height,picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $nickname = $row['nickname'];
    $birthdate = $row['birthdate'];
    $weight = $row['weight'];
    $height = $row['height'];
    $picture = $row['picture'];
} else {
    // Handle case where user is not found
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
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
        <h3 class="message">Hello, <?php echo htmlspecialchars($nickname); ?>!</h3>
        <img class="profile-picture" src="<?php echo $picture; ?>" alt="Profile Picture"/>
        <a href="dashboard.php"><button id="edit">Dashboard</button></a>
        <a href="logout.php"><button id="logout">Log Out</button></a>
    </div>

    <header>
        <a class="logo" href="dashboard.php"><img src="images/logo2.png" alt="Logo"><span>Puerza</span></a>
    </header>


    <h1 class="edit-profile-title">Edit Profile</h1>
    <!--Main-->
    <div class="main">
        <form action="saveProfile.php" method="post">

            <div class="title-row1">
                <h3 class="edit-title">First Name</h3>
                <h3 class="edit-title">Last Name</h3>
                <h3 class="edit-title">Nickname</h3>
            </div>

            <div class="input-row1">
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" class="text-placeholder">
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" class="text-placeholder">
                <input type="text" name="nickname" value="<?php echo htmlspecialchars($nickname); ?>" class="text-placeholder">
            </div>

            <div class="title-row2">
                <h3 class="edit-title">Weight</h3>
                <h3 class="edit-title">Height</h3>
            </div>

            <div class="input-row2">
                <input type="number" name="weight" value="<?php echo htmlspecialchars($weight); ?>" class="text-placeholder">
                <input type="number" name="height" value="<?php echo htmlspecialchars($height); ?>" class="text-placeholder">
            </div>

            <div class="title-row3">
                <h3 class="edit-title">Birthday</h3>
            </div>

            <div class="input-row3">
                <input type="date" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" class="text-placeholder">
            </div>

            <div class="title-row4">
                <h3 class="edit-title">Choose an Icon</h3>
            </div>

            <ul>
                <li>
                    <input type="radio" name="picture" id="cb1" value="images/tiger.png" />
                    <label for="cb1"><img src="images/tiger.png" /></label>
                </li>
                <li>
                    <input type="radio" name="picture" id="cb2" value="images/wolf.png" />
                    <label for="cb2"><img src="images/wolf.png" /></label>
                </li>
                <li>
                    <input type="radio" name="picture" id="cb3" value="images/spartan.png" />
                    <label for="cb3"><img src="images/spartan.png" /></label>
                </li>
                <li>
                    <input type="radio" name="picture" id="cb4" value="images/lion.png" />
                    <label for="cb4"><img src="images/lion.png" /></label>
                </li>
                <li>
                    <input type="radio" name="picture" id="cb5" value="images/bear.png" />
                    <label for="cb5"><img src="images/bear.png" /></label>
                </li>
            </ul>

            <button type="submit" id="save">Save Changes</button>
        </form>
    </div>

</body>
</html>
