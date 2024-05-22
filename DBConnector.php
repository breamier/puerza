<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("Connection failes: ".$conn->connect_error);
} else {
    echo "Connected successfully!";
}

$sql = "CREATE DATABASE IF NOT EXISTS puerzaDB";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

$dbname = "puerzaDB";

//Reconnect
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "\nConnected to Puerza";
}

$sql_users = "CREATE TABLE IF NOT EXISTS workout (
    workout_id INT AUTO_INCREMENT PRIMARY KEY,
    workout_type INT,
    date DATE,
    lp DOUBLE(4,2),
    drpm DOUBLE(10,2),
    crpm DOUBLE(10,2),
    srpm DOUBLE(10,2),
    brpm DOUBLE(10,2)
)";

if ($conn->query($sql_users) === TRUE) {
    echo "Workout table created successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// Stores Strength Training workouts
$sql_strength = "CREATE TABLE IF NOT EXISTS strengthWorkout (
    workout_id INT,
    exercise VARCHAR(40),
    wu_weight1 INT,
    wu_rep1 INT,
    we_weight2 INT,
    wu_rep2 INT,
    work_weight1 INT,
    work_rep1 INT,
    work_weight2 INT,
    work_rep2 INT,
    FOREIGN KEY (workout_id) REFERENCES workout(workout_id)
)";

if ($conn->query($sql_strength) === TRUE) {
    echo "Strength table created successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// Table for individual plyo exercises
$sql = "CREATE TABLE IF NOT EXISTS plyoExercise(
    plyo_id INT NOT NULL PRIMARY KEY,
    plyo_name VARCHAR(40),
    sets INT
)";

if ($conn->query($sql) === TRUE) {
    echo "Plyo table created successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// Stores plyo workouts
$sql_plyo = "CREATE TABLE IF NOT EXISTS plyoWorkout (
    workout_id INT NOT NULL,
    plyo_id INT NOT NULL,
    reps INT NOT NULL,
    FOREIGN KEY (workout_id) REFERENCES workout(workout_id)
)";

if ($conn->query($sql_plyo) === TRUE) {
    echo "\nPlyoWorkout table created successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// $sql_plyoValues = "INSERT INTO `plyoExercise` (`plyo_id`, `plyo_name`, `sets`)
//     VALUES
//     (1, 'Jumping Jacks', 1),
//     (2, 'Jump Squat', 3),
//     (3, 'Forward Jump', 3),
//     (4, 'Reverse Jump', 3),
//     (5, 'Decline Push', 3),
//     (6, 'Side Jump', 3),
//     (7, 'Calf Jump', 1),
//     (8, 'Power Push Up', 3),
//     (9, 'Forward Squat to Jump Squat', 2),
//     (10, 'Jump Squat to Reverse Squat', 2),
//     (11, 'Burpees', 3),
//     (12, 'Squat Ball', 3)
//     ";

// if ($conn->query($sql_plyoValues) === TRUE) {
//     echo "\nValues added successfully";
// } else {
//     echo "Error creating course table: " . $conn->error;
// }

$sql_strengthReps = "CREATE TABLE IF NOT EXISTS strengthRepetitions(
    set_num INT NOT NULL,
    lp INT NOT NULL,
    reps INT NOT NULL
)";

if ($conn->query($sql_strengthReps) === TRUE) {
    echo "\nValues added successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// $sql_strengthRepsValues = "INSERT INTO `strengthRepetitions` (`set_num`, `lp`, `reps`)
//     VALUES
//     (1, 75, 15),(1, 80, 15),(1, 85, 13),(1, 90, 12),(1, 95, 10),(1, 100, 10),
//     (2, 75, 15),(2, 80, 13),(2, 85, 12),(2, 90, 10),(2, 95, 10),(2, 100, 8),
//     (3, 75, 13),(3, 80, 12),(3, 85, 10),(3, 90, 8),(3, 95, 8),(3, 100, 6),
//     (4, 75, 12),(4, 80, 12),(4, 85, 10),(4, 90, 8),(4, 95, 6),(4, 100, 5)
//     ";


// if ($conn->query($sql_strengthRepsValues) === TRUE) {
//     echo "\nValues added successfully";
// } else {
//     echo "Error creating course table: " . $conn->error;
// }
?>