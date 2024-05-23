<?php
include 'DBConnector.php';

$date = $_GET["date"];
$type = $_GET["type"];
$drpm = $_GET["drpm"];
$crpm = $_GET["crpm"];
$srpm = $_GET["srpm"];
$brpm = $_GET["brpm"];
$bsrpm = $_GET["bsrpm"];
$lp = $_GET["lp"];
$iso = $_GET["iso"];

echo $date.'<br>';
echo $type.'<br>';
echo $drpm.'<br>';
echo $crpm.'<br>';
echo $srpm.'<br>';
echo $brpm.'<br>';
echo $bsrpm.'<br>';
echo $lp.'<br>';
echo 'IsoID'.$iso.'<br>';


if ($iso != 5){
    $iso_exercise = generateIso($conn, $iso);
    echo 'Iso Workout'.$iso_exercise.'<br>';
}
// $sql = "INSERT INTO `workout` (`workout_id`, `workout_type`, `date`, `lp`, `drpm`, `crpm`, `srpm`, `brpm`)
//     VALUES ('', '$type', '$date', '$lp', '$drpm', '$crpm', '$srpm', '$brpm',)";

// if($conn->$query($sql) === TRUE){
//     echo "Added to WORKOUT <br>";
// } else {
//     echo "Error to WORKOUT<br>";
// }

// $last_inserted_id = $conn->insert_id;

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

switch($type){
    case 1: 
        generateDeadliftWorkout($conn, $drpm, $srpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep);
        echo "<br>Deadlift Generated";
        break;
    case 2:
        generateBackSquatWorkout($conn, $bsrpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep);
        echo "<br>Back Squat Generated";
        break;
    case 3:
        generateBeginnerPlyo($conn);
        echo "Beginner Plyo Generated";
    case 4:
        generateIntermediatePlyo($conn);
        echo "Intermediate Plyo Generated";
    case 5:
        generateExtremePlyo($conn);
        echo "Extreme Plyo Generated";
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

function generateDeadliftWorkout($conn, $drpm, $srpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep){
    $dWarmUp1 = calculateWarmUp1($drpm, $lp);
    $dWarmUp2 = calculateWarmUp2($drpm, $lp);
    $dWorking1 = calculateWorking1($drpm, $lp);
    $dWorking2 = calculateWorking2($drpm, $lp);

    echo "Set 1: ". $set1_rep."<br>". "Set 2: ". $set2_rep. "<br>". "Set 3: ". $set3_rep."<br>". "Set 4: ".$set4_rep. "<br>";

    echo "<br>Deadlift<br>". $dWarmUp1. "<br>". $dWarmUp2."<br>". $dWorking1. "<br>". $dWorking2;

    $sWarmUp1 = calculateWarmUp1($srpm, $lp);
    $sWarmUp2 = calculateWarmUp2($srpm, $lp);
    $sWorking1 = calculateWorking1($srpm, $lp);
    $sWorking2 = calculateWorking2($srpm, $lp);

    echo "<br>Shoulder Press<br>". $sWarmUp1. "<br>". $sWarmUp2."<br>". $sWorking1. "<br>". $sWorking2;

    $cWarmUp1 = calculateWarmUp1($crpm, $lp);
    $cWarmUp2 = calculateWarmUp2($crpm, $lp);
    $cWorking1 = calculateWorking1($crpm, $lp);
    $cWorking2 = calculateWorking2($crpm, $lp);

    echo "<br>Chest Press<br>". $cWarmUp1. "<br>". $cWarmUp2."<br>". $cWorking1. "<br>". $cWorking2;

    $bWarmUp1 = calculateWarmUp1($brpm, $lp);
    $bWarmUp2 = calculateWarmUp2($brpm, $lp);
    $bWorking1 = calculateWorking1($brpm, $lp);
    $bWorking2 = calculateWorking2($brpm, $lp);

    echo "<br>Back Row<br>". $bWarmUp1. "<br>". $bWarmUp2."<br>". $bWorking1. "<br>". $bWorking2;
}

function generateBackSquatWorkout($conn, $bsrpm, $crpm, $brpm, $lp, $set1_rep, $set2_rep, $set3_rep, $set4_rep){
    $bsWarmUp1 = calculateWarmUp1($bsrpm, $lp);
    $bsWarmUp2 = calculateWarmUp2($bsrpm, $lp);
    $bsWorking1 = calculateWorking1($bsrpm, $lp);
    $bsWorking2 = calculateWorking2($bsrpm, $lp);

    echo "Set 1: ". $set1_rep."<br>". "Set 2: ". $set2_rep. "<br>". "Set 3: ". $set3_rep."<br>". "Set 4: ".$set4_rep. "<br>";

    echo "<br>Back Squat<br>". $bsWarmUp1. "<br>". $bsWarmUp2."<br>". $bsWorking1. "<br>". $bsWorking2;

    $cWarmUp1 = calculateWarmUp1($crpm, $lp);
    $cWarmUp2 = calculateWarmUp2($crpm, $lp);
    $cWorking1 = calculateWorking1($crpm, $lp);
    $cWorking2 = calculateWorking2($crpm, $lp);

    echo "<br>Chest Press<br>". $cWarmUp1. "<br>". $cWarmUp2."<br>". $cWorking1. "<br>". $cWorking2;

    $bWarmUp1 = calculateWarmUp1($brpm, $lp);
    $bWarmUp2 = calculateWarmUp2($brpm, $lp);
    $bWorking1 = calculateWorking1($brpm, $lp);
    $bWorking2 = calculateWorking2($brpm, $lp);

    echo "<br>Back Row<br>". $bWarmUp1. "<br>". $bWarmUp2."<br>". $bWorking1. "<br>". $bWorking2;
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

    $sql = "SELECT idv_iso_name FROM isoExercise WHERE iso_id=$iso and idv_iso=$rand";
    $result = ($conn->query($sql))->fetch_assoc();
    $workout = $result["idv_iso_name"];

    return $workout;
}

$conn->close();
?>