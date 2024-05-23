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
    brpm DOUBLE(10,2),
    iso_id INT,
    idv_iso INT
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
    plyo_set INT NOT NULL,
    plyo_name VARCHAR(40),
    sets INT NOT NULL,
    reps INT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "<br>Plyo table for exercise created successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// $sql_plyoValues = "INSERT INTO `plyoExercise` (`plyo_set`, `plyo_name`, `sets`, `reps`)
//     VALUES
//     (1, 'Jumping Jacks', 1, 50),
//     (1, 'Jump Squat', 3, 10),
//     (1, 'Forward Jump', 3, 5),
//     (1, 'Reverse Jump', 3, 5),
//     (1, 'Decline Push', 3, 5),
//     (1, 'Side Jump', 3, 5),
//     (1, 'Calf Jump', 1, 50),
//     (1, 'Power Push Up', 3, 5),
//     (1, 'Forward Squat to Jump Squat', 2, 5),
//     (1, 'Jump Squat to Reverse Squat', 2, 5),
//     (1, 'Burpees', 3, 6),
//     (1, 'Squat Ball', 3, 10),
//     (2, 'Jumping Jacks', 1, 80),
//     (2, 'Jump Squat', 3, 12),
//     (2, 'Forward Jump', 3, 8),
//     (2, 'Reverse Jump', 3, 8),
//     (2, 'Decline Push', 3, 8),
//     (2, 'Side Jump', 3, 8),
//     (2, 'Calf Jump', 1, 70),
//     (2, 'Power Push Up', 3, 10),
//     (2, 'Forward Squat to Jump Squat', 2, 8),
//     (2, 'Jump Squat to Reverse Squat', 2, 8),
//     (2, 'Burpees', 3, 10),
//     (2, 'Squat Ball', 3, 12),
//     (3, 'Jumping Jacks', 1, 100),
//     (3, 'Jump Squat', 3, 15),
//     (3, 'Forward Jump', 3, 10),
//     (3, 'Reverse Jump', 3, 10),
//     (3, 'Decline Push', 3, 12),
//     (3, 'Side Jump', 3, 10),
//     (3, 'Calf Jump', 1, 90),
//     (3, 'Power Push Up', 3, 15),
//     (3, 'Forward Squat to Jump Squat', 2, 12),
//     (3, 'Jump Squat to Reverse Squat', 2, 12),
//     (3, 'Burpees', 3, 15),
//     (3, 'Squat Ball', 3, 15)
//     ";

// if ($conn->query($sql_plyoValues) === TRUE) {
//     echo "<br>Exercises for Plyo added successfully";
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

$sql_iso_table = "CREATE TABLE IF NOT EXISTS isolation(
    iso_id INT PRIMARY KEY,
    iso_part VARCHAR(40)
)";

if ($conn->query($sql_iso_table) === TRUE) {
    echo "\n Isolation Table added successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

$sql_iso_ex = "CREATE TABLE IF NOT EXISTS isoExercise(
        iso_id INT,
        idv_iso INT,
        idv_iso_name VARCHAR(40),
        FOREIGN KEY(iso_id) REFERENCES isolation(iso_id)
)";

if ($conn->query($sql_iso_ex) === TRUE) {
    echo "\nIso Exercise Table added successfully";
} else {
    echo "Error creating course table: " . $conn->error;
}

// $sql_insert_iso = "INSERT INTO `isolation`(`iso_id`, `iso_part`)
//     VALUES
//     (1, 'Biceps and Triceps'), (2, 'Shoulders'), (3, 'Abs, Core and Side Obliques'), (4, 'Calves'), (5, 'None')
// ";

// if ($conn->query($sql_insert_iso) === TRUE) {
//     echo "\nIso Exercise Table added successfully";
// } else {
//     echo "Error creating course table: " . $conn->error;
// }


// $sql_insert_iso_ex = "INSERT INTO `isoExercise`(`iso_id`, `idv_iso`, `idv_iso_name`)
//     VALUES
//     (1, 1, 'Bicep Curl and Tricep Push Down'), (1, 2, 'Hammer Curl and Close Grip Tricep Press'), (1, 3, 'Tricep Dip'), (1, 4, 'Tricep Kickback'),
//     (2, 1, 'Lateral Raise'), (2, 2, 'Front Raise'), (2, 3, 'Upright Row'), (2, 4, 'Side Deltoid Raise'),
//     (3, 1, 'Crunches and Plank'), (3, 2, 'Russian Twist'), (3, 3, 'Leg Raises'), (3, 4, 'Decline and Side Decline Crunches'),
//     (4, 1, 'Calf Raises'), (4, 2, 'Seated Calf Raise'), (4, 3, 'Box Jumps'), (4, 4, 'Jump Rope')
//     ";

// if ($conn->query($sql_insert_iso_ex) === TRUE){
//     echo "\nValues for Isolation added successfully";
// } else {
//     echo "Error creating course table: " . $conn->error;
// }


?>