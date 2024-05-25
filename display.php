<?php
include 'DBConnector.php';
// session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
// $current_date = date("Y-m-d");
$current_date = '2024-05-26';


echo $current_date;
$sql = "SELECT w.workout_id, w.workout_type
        FROM workout as w
        JOIN user_workout as uw ON uw.workout_id = w.workout_id
        WHERE uw.user_id = ? AND w.date = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $current_date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $type = $row['workout_type'];
        $workout_id = $row['workout_id'];
        echo '<div class = "card">';
        if($type == 1){
            echo '<table class="display-strength">
                <caption>Deadlift Set</caption>
                <tr>
                    <th></th><th colspan="3">Warm Up</th><th colspan="3">Working</th>
                </tr>
                <tr>
                    <td>Exercise</td>
                    <td>Set</td><td>Weight</td><td>Reps</td>
                    <td>Set</td><td>Weight</td><td>Reps</td>
                </tr>';
            $get_strength = "SELECT * FROM strengthWorkout WHERE workout_id = $workout_id";
            $result_row = $conn->query($get_strength);
            while($str = $result_row->fetch_assoc()){
                echo '<tr>
                        <td rowspan="2">'.$str['exercise'].'</td><td>1</td><td>'.$str['wu_weight1'].'</td><td>'.$str['wu_rep1'].'</td><td>1</td><td>'.$str['work_weight1'].'</td><td>'.$str['work_rep1'].'</td>
                    </tr><tr>
                        <td>2</td><td>'.$str['wu_weight2'].'</td><td>'.$str['wu_rep2'].'</td><td>2</td><td>'.$str['work_weight2'].'</td><td>'.$str['work_rep2'].'</td>
                    </tr>';
            }
            echo '</table>';
            echo '<form method="post" action="delete_workout.php">';
            echo '<input type="hidden" name="workout_id" value="' . $workout_id . '"><input type="hidden" name="type" value="' . $type . '">';
            echo '<button type="submit" name="delete_workout" style="background-color: red;">Delete Workout</button>';
            echo '</form></div>';
        } elseif($type == 2){
            echo '<div class = "card">';
            echo '<table class="display-strength">
                <caption>Backsquat Set</caption>
                <tr>
                    <th></th><th colspan="3">Warm Up Set</th><th colspan="3">Working Sets</th>
                </tr>
                <tr>
                    <td>Exercise</td>
                    <td>Set</td><td>Weight(lbs)</td><td>Repetitions</td>
                    <td>Set</td><td>Weight(lbs)</td><td>Repetitions</td>
                </tr>';
            $get_strength = "SELECT * FROM strengthWorkout WHERE workout_id = $workout_id";
            $result_row = $conn->query($get_strength);
            while($str = $result_row->fetch_assoc()){
                echo '<tr>
                        <td rowspan="2">'.$str['exercise'].'</td><td>1</td><td>'.$str['wu_weight1'].'</td><td>'.$str['wu_rep1'].'</td><td>1</td><td>'.$str['work_weight1'].'</td><td>'.$str['work_rep1'].'</td>
                    </tr><tr>
                        <td>2</td><td>'.$str['wu_weight2'].'</td><td>'.$str['wu_rep2'].'</td><td>2</td><td>'.$str['work_weight2'].'</td><td>'.$str['work_rep2'].'</td>
                    </tr>';
            }
            echo '</table>';
            echo '<form method="post" action="delete_workout.php">';
            echo '<input type="hidden" name="workout_id" value="' . $workout_id . '"><input type="hidden" name="type" value="' . $type . '">';
            echo '<button type="submit" name="delete_workout" style="background-color: red;">Delete Workout</button>';
            echo '</form></div>';
        } elseif($type == 3 || $type == 4 || $type == 5){
            echo '<div class = "card">';
            echo '<table class="display-plyo">
                <caption>Plyometrics</caption>
                <tr>
                    <th>Exercise</th><th>Sets</th><th>Repetitions</th>
                </tr>';
            $get_plyo = "SELECT * FROM plyoExercise WHERE plyo_set = $type";
            $result_row = $conn->query($get_plyo);
            while($str_row = $result_row->fetch_assoc()){
                echo '<tr>
                    <td>'.$str_row['plyo_name'].'</td><td>'.$str_row['sets'].'</td><td>'.$str_row['reps'].'</td>
                </tr>';
            }
            echo '</table>';
            echo '<form method="post" action="delete_workout.php">';
            echo '<input type="hidden" name="workout_id" value="' . $workout_id . '"><input type="hidden" name="type" value="' . $type . '">';
            echo '<button type="submit" name="delete_workout" style="background-color: red;">Delete Workout</button>';
            echo '</form></div>';
        }
        
    }
} else {
    echo "0 results";
}


?>