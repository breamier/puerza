<?php
include 'DBConnector.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$date = $_GET["date"];
$type = $_GET["type"];
$drpm = $_GET["drpm"];
$crpm = $_GET["crpm"];
$srpm = $_GET["srpm"];
$brpm = $_GET["brpm"];
$bsrpm = $_GET["bsrpm"];
$lp = $_GET["lp"];
$iso = $_GET["iso"];

if ($iso != 5){
    $iso_exercise = generateIso($conn, $iso);
    echo 'Iso Workout'.$iso_exercise.'<br>';
} else {
    $iso_exercise = 0;
}

// Add to Workout Table
$sql = "INSERT INTO `workout` (`workout_id`, `workout_type`, `date`, `lp`, `drpm`, `crpm`, `srpm`, `brpm`, `iso_id`, `idv_iso`)
    VALUES ('', '$type', '$date', '$lp', '$drpm', '$crpm', '$srpm', '$brpm', '$iso', '$iso_exercise')";

if($conn->query($sql) === TRUE){
    echo "Added to WORKOUT <br>";
} else {
    echo "Error adding to WORKOUT<br>";
}

// Add to User-Workout Table UserID and WorkoutID
$workout_id = $conn->insert_id;

$sql_link = "INSERT INTO `user_workout`(`user_id`, `workout_id`)
    VALUES('$user_id', '$workout_id')";

if($conn->query($sql_link) === TRUE){
    echo "Linked Successfully";
}

// Repetitions Based on Lifting Percentage
$sql = "SELECT set_num, reps FROM strengthRepetitions WHERE lp='$lp'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        switch($row["set_num"]){
            case 1:
                $set1_rep = $row["reps"];
                break;
            case 2:
                $set2_rep = $row["reps"];
                break;
            case 3:
                $set3_rep = $row["reps"];
                break;
            case 4:
                $set4_rep = $row["reps"];
                break;
            default:
                break;
        }
    }
}


// Adds appropriate workout based on type of workout selected
switch($type){
    case 1: 
        generateDeadliftWorkout($conn, $drpm, $srpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep, $workout_id);
        echo "<br>Deadlift Generated";
        break;
    case 2:
        generateBackSquatWorkout($conn, $bsrpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep, $workout_id);
        echo "<br>Back Squat Generated";
        break;
    case 3:
        generateBeginnerPlyo($conn);
        echo "Beginner Plyo Generated";
        break;
    case 4:
        generateIntermediatePlyo($conn);
        echo "Intermediate Plyo Generated";
        break;
    case 5:
        generateExtremePlyo($conn);
        echo "Extreme Plyo Generated";
        break;
    default:
        break;
}


function calculateWarmUp1($rpm, $lp){
    $weight = $rpm * ($lp/100 - 0.15);
    return roundWeight($weight);
}

function calculateWarmUp2($rpm, $lp){
    $weight = $rpm * ($lp/100 - 0.10);
    return roundWeight($weight);
}

function calculateWorking1($rpm, $lp){
    $weight = $rpm * ($lp/100 - 0.05);
    return roundWeight($weight);
}

function calculateWorking2($rpm, $lp){
    $weight = $rpm * $lp/100;
    return roundWeight($weight);
}

function roundWeight($weight){
    return round($weight/5)*5;
}

function generateDeadliftWorkout($conn, $drpm, $srpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep, $workout_id){
    $dWarmUp1 = calculateWarmUp1($drpm, $lp);
    $dWarmUp2 = calculateWarmUp2($drpm, $lp);
    $dWorking1 = calculateWorking1($drpm, $lp);
    $dWorking2 = calculateWorking2($drpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Deadlift', '$dWarmUp1', '$set1_rep', '$dWarmUp2', '$set2_rep', '$dWorking1', '$set3_rep', '$dWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Deadlift";
    }

    $sWarmUp1 = calculateWarmUp1($srpm, $lp);
    $sWarmUp2 = calculateWarmUp2($srpm, $lp);
    $sWorking1 = calculateWorking1($srpm, $lp);
    $sWorking2 = calculateWorking2($srpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Shoulder Press', '$sWarmUp1', '$set1_rep', '$sWarmUp2', '$set2_rep', '$sWorking1', '$set3_rep', '$sWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Shoulder Press";
    }

    $cWarmUp1 = calculateWarmUp1($crpm, $lp);
    $cWarmUp2 = calculateWarmUp2($crpm, $lp);
    $cWorking1 = calculateWorking1($crpm, $lp);
    $cWorking2 = calculateWorking2($crpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Chest Press', '$cWarmUp1', '$set1_rep', '$cWarmUp2', '$set2_rep', '$cWorking1', '$set3_rep', '$cWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Chest Press";
    }

    $bWarmUp1 = calculateWarmUp1($brpm, $lp);
    $bWarmUp2 = calculateWarmUp2($brpm, $lp);
    $bWorking1 = calculateWorking1($brpm, $lp);
    $bWorking2 = calculateWorking2($brpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Back Row', '$bWarmUp1', '$set1_rep', '$bWarmUp2', '$set2_rep', '$bWorking1', '$set3_rep', '$bWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Back Row";
    }
}

function generateBackSquatWorkout($conn, $bsrpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep, $workout_id){
    $bsWarmUp1 = calculateWarmUp1($bsrpm, $lp);
    $bsWarmUp2 = calculateWarmUp2($bsrpm, $lp);
    $bsWorking1 = calculateWorking1($bsrpm, $lp);
    $bsWorking2 = calculateWorking2($bsrpm, $lp);

    // echo "Set 1: ". $set1_rep."<br>". "Set 2: ". $set2_rep. "<br>". "Set 3: ". $set3_rep."<br>". "Set 4: ".$set4_rep. "<br>";

    // echo "<br>Back Squat<br>". $bsWarmUp1. "<br>". $bsWarmUp2."<br>". $bsWorking1. "<br>". $bsWorking2;
    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Back Squat', '$bsWarmUp1', '$set1_rep', '$bsWarmUp2', '$set2_rep', '$bsWorking1', '$set3_rep', '$bsWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Back Squat";
    }

    $cWarmUp1 = calculateWarmUp1($crpm, $lp);
    $cWarmUp2 = calculateWarmUp2($crpm, $lp);
    $cWorking1 = calculateWorking1($crpm, $lp);
    $cWorking2 = calculateWorking2($crpm, $lp);

    // echo "<br>Chest Press<br>". $cWarmUp1. "<br>". $cWarmUp2."<br>". $cWorking1. "<br>". $cWorking2;

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Chest Press', '$cWarmUp1', '$set1_rep', '$cWarmUp2', '$set2_rep', '$cWorking1', '$set3_rep', '$cWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Chest Press";
    }
    $bWarmUp1 = calculateWarmUp1($brpm, $lp);
    $bWarmUp2 = calculateWarmUp2($brpm, $lp);
    $bWorking1 = calculateWorking1($brpm, $lp);
    $bWorking2 = calculateWorking2($brpm, $lp);

    // echo "<br>Back Row<br>". $bWarmUp1. "<br>". $bWarmUp2."<br>". $bWorking1. "<br>". $bWorking2;
    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Back Row', '$bWarmUp1', '$set1_rep', '$bWarmUp2', '$set2_rep', '$bWorking1', '$set3_rep', '$bWorking2', '$set4_rep')";

    if($conn->query($sql) === TRUE){
        echo "Back Row";
    }
}

function generateBeginnerPlyo($conn){
    $sql = "SELECT plyo_name, sets, reps FROM plyoexercise WHERE plyo_set='1'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo "Exercise  Sets    Reps<br>";
        while($row = $result->fetch_assoc()){
            echo $row["plyo_name"] . "    " . $row["sets"]. "   " . $row["reps"] . "<br>";
        }
    }
    
}

function generateIntermediatePlyo($conn){
    $sql = "SELECT plyo_name, sets, reps FROM plyoexercise WHERE plyo_set='2'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo "Exercise  Sets    Reps<br>";
        while($row = $result->fetch_assoc()){
            echo $row["plyo_name"] . "    " . $row["sets"]. "   " . $row["reps"] . "<br>";
        }
    }
    
}

function generateExtremePlyo($conn){
    $sql = "SELECT plyo_name, sets, reps FROM plyoexercise WHERE plyo_set='3'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo "Exercise  Sets    Reps<br>";
        while($row = $result->fetch_assoc()){
            echo $row["plyo_name"] . "    " . $row["sets"]. "   " . $row["reps"] . "<br>";
        }
    }
    
}

function generateIso($conn, $iso){
    $rand = rand(1, 4);
    
    // $sql = "SELECT idv_iso_name FROM isoExercise WHERE iso_id=$iso and idv_iso=$rand";
    // $result = ($conn->query($sql))->fetch_assoc();
    // $workout = $result["idv_iso_name"];

    return $rand;
}

$conn->close();
?>