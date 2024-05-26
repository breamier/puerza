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
} else {
    $iso_exercise = 0;
}

// Add to Workout Table
$sql = "INSERT INTO `workout` (`workout_id`, `workout_type`, `date`, `lp`, `drpm`, `crpm`, `srpm`, `brpm`, `iso_id`, `idv_iso`, `status`)
    VALUES ('', '$type', '$date', '$lp', '$drpm', '$crpm', '$srpm', '$brpm', '$iso', '$iso_exercise', 'false')";

$conn->query($sql);

// Add to User-Workout Table UserID and WorkoutID
$workout_id = $conn->insert_id;

$sql_link = "INSERT INTO `user_workout`(`user_id`, `workout_id`)
    VALUES('$user_id', '$workout_id')";

$conn->query($sql_link);


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
        break;
    case 2:
        generateBackSquatWorkout($conn, $bsrpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep, $workout_id);
        break;
    case 3:
        generateBeginnerPlyo($conn);
        break;
    case 4:
        generateIntermediatePlyo($conn);
        break;
    case 5:
        generateExtremePlyo($conn);
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

    $conn->query($sql);

    $sWarmUp1 = calculateWarmUp1($srpm, $lp);
    $sWarmUp2 = calculateWarmUp2($srpm, $lp);
    $sWorking1 = calculateWorking1($srpm, $lp);
    $sWorking2 = calculateWorking2($srpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Shoulder Press', '$sWarmUp1', '$set1_rep', '$sWarmUp2', '$set2_rep', '$sWorking1', '$set3_rep', '$sWorking2', '$set4_rep')";

    $conn->query($sql);

    $cWarmUp1 = calculateWarmUp1($crpm, $lp);
    $cWarmUp2 = calculateWarmUp2($crpm, $lp);
    $cWorking1 = calculateWorking1($crpm, $lp);
    $cWorking2 = calculateWorking2($crpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Chest Press', '$cWarmUp1', '$set1_rep', '$cWarmUp2', '$set2_rep', '$cWorking1', '$set3_rep', '$cWorking2', '$set4_rep')";

    $conn->query($sql);

    $bWarmUp1 = calculateWarmUp1($brpm, $lp);
    $bWarmUp2 = calculateWarmUp2($brpm, $lp);
    $bWorking1 = calculateWorking1($brpm, $lp);
    $bWorking2 = calculateWorking2($brpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Back Row', '$bWarmUp1', '$set1_rep', '$bWarmUp2', '$set2_rep', '$bWorking1', '$set3_rep', '$bWorking2', '$set4_rep')";

    $conn->query($sql);
    
}

function generateBackSquatWorkout($conn, $bsrpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep, $workout_id){
    $bsWarmUp1 = calculateWarmUp1($bsrpm, $lp);
    $bsWarmUp2 = calculateWarmUp2($bsrpm, $lp);
    $bsWorking1 = calculateWorking1($bsrpm, $lp);
    $bsWorking2 = calculateWorking2($bsrpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Back Squat', '$bsWarmUp1', '$set1_rep', '$bsWarmUp2', '$set2_rep', '$bsWorking1', '$set3_rep', '$bsWorking2', '$set4_rep')";

    $conn->query($sql);

    $cWarmUp1 = calculateWarmUp1($crpm, $lp);
    $cWarmUp2 = calculateWarmUp2($crpm, $lp);
    $cWorking1 = calculateWorking1($crpm, $lp);
    $cWorking2 = calculateWorking2($crpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Chest Press', '$cWarmUp1', '$set1_rep', '$cWarmUp2', '$set2_rep', '$cWorking1', '$set3_rep', '$cWorking2', '$set4_rep')";

    $conn->query($sql);

    $bWarmUp1 = calculateWarmUp1($brpm, $lp);
    $bWarmUp2 = calculateWarmUp2($brpm, $lp);
    $bWorking1 = calculateWorking1($brpm, $lp);
    $bWorking2 = calculateWorking2($brpm, $lp);

    $sql = "INSERT INTO `strengthworkout`(`workout_id`, `exercise`, `wu_weight1`, `wu_rep1`, `wu_weight2`, `wu_rep2`, `work_weight1`, `work_rep1`, `work_weight2`, `work_rep2`)
        VALUES('$workout_id', 'Back Row', '$bWarmUp1', '$set1_rep', '$bWarmUp2', '$set2_rep', '$bWorking1', '$set3_rep', '$bWorking2', '$set4_rep')";

    $conn->query($sql);
}

function generateBeginnerPlyo($conn){
    $sql = "SELECT plyo_name, sets, reps FROM plyoexercise WHERE plyo_set='1'";
    $result = $conn->query($sql);    
}

function generateIntermediatePlyo($conn){
    $sql = "SELECT plyo_name, sets, reps FROM plyoexercise WHERE plyo_set='2'";
    $result = $conn->query($sql);    
}

function generateExtremePlyo($conn){
    $sql = "SELECT plyo_name, sets, reps FROM plyoexercise WHERE plyo_set='3'";
    $result = $conn->query($sql);    
}

function generateIso($conn, $iso){
    $rand = rand(1, 4);
    return $rand;
}

header("Location: dashboard.php");

$conn->close();
exit();
?>