<?php
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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Puerza | Workout Generator</title>
        <link rel="stylesheet" type="text/css" href="css/generator.css">
        <!--Import Fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <!--Main-->
        <div class="main">
            <header>
                <a class="logo" href="dashboard.php"><img src="images/logo2.png"><span>Puerza</span></a>
            </header>
            <h1>Workout Generator</h1>

            <form action="generateWorkout.php" method="get">
                <table>
                    <tr>
                        <td colspan="3" class="form-sec">When do you plan to workout?</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">
                            <input type="date" id="date" name="date" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="form-sec">What type of workout will you have?</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="card">
                                <h3 class="label">Strength Training</h3>
                                <br>
                                <input type="radio" name="type" value="1" required>Deadlift Set<br>
                                <input type="radio" name="type" value="2" required>Backsquat Set<br>
                            </div>
                        </td>
                        <td>
                            <div class="card">
                                <h3 class="label">Plyometrics</h3>
                                <br>
                                <div style="column-count: 2;">
                                    <input type="radio" name="type" value="3" required>Beginner Set<br>
                                    <input type="radio" name="type" value="4" required>Intermediate Set<br>
                                    <input type="radio" name="type" value="5" required>Extreme Set<br>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="form-sec">Enter your One Rep Max for each exercise:</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" name="drpm" placeholder="lbs" required>
                            <h4 class="identifier">Deadlift</h4>
                        </td>
                        <td>
                            <input type="number" name="crpm" placeholder="lbs" required>
                            <h4 class="identifier">Chest Press</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" name="brpm" placeholder="lbs" required>
                            <h4 class="identifier">Backrow</h4>
                        </td>
                        <td>
                            <input type="number" name="bsrpm" placeholder="lbs" required>
                            <h4 class="identifier">Back Squat</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" name="srpm" placeholder="lbs" required>
                            <h4 class="identifier">Shoulder Press</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="form-sec">Select your Lifting Percentage:</td>                        
                    </tr>
                    <tr class="lp-container">
                        <td>
                            <input type="radio" name="lp" value="75" class="lp" required>75%<br>   
                            <input type="radio" name="lp" value="80" class="lp" required>80%<br>
                            <input type="radio" name="lp" value="85" class="lp" required>85%
                        </td>
                        <td>
                            <input type="radio" name="lp" value="90" class="lp" required>90%<br>
                            <input type="radio" name="lp" value="95" class="lp" required>95%<br>
                            <input type="radio" name="lp" value="100" class="lp" required>100%
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="form-sec">Which isolation exercise would you like to do?</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="iso-container">
                                <div style="display: inline-block; text-align: left;">
                                    <input type="radio" name="iso" value="1" class="iso" required>Biceps and Triceps<br>
                                    <input type="radio" name="iso" value="2" class="iso" required>Shoulders<br>
                                    <input type="radio" name="iso" value="3" class="iso" required>Abs, Core, Side Obliques<br>
                                    <input type="radio" name="iso" value="4" class="iso" required>Calves<br>
                                    <input type="radio" name="iso" value="5" class="iso" required>Maybe Next Time<br>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Generate Workout" class="submit-button"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>