<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("Connection failes: ".$conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS puerzadb";

if ($conn->query($sql) === TRUE) {
    // echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

$dbname = "puerzadb";

//Reconnect
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS workout (
    workout_id INT AUTO_INCREMENT PRIMARY KEY,
    workout_type INT,
    date DATE,
    lp DOUBLE(4,2),
    drpm DOUBLE(10,2),
    crpm DOUBLE(10,2),
    srpm DOUBLE(10,2),
    brpm DOUBLE(10,2),
    iso_id INT,
    idv_iso INT,
    status BOOLEAN
)";

$conn->query($sql);

// Users Table
$sql = "CREATE TABLE IF NOT EXISTS users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(40) NOT NULL,
    password VARCHAR(75) NOT NULL,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL, 
    nickname VARCHAR(20) NOT NULL,
    birthdate DATE NOT NULL,
    weight INT,
    height INT,
    picture VARCHAR(40)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS user_workout(
    user_id INT NOT NULL,
    workout_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (workout_id) REFERENCES workout(workout_id)
)";

$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS strengthWorkout (
    workout_id INT,
    exercise VARCHAR(40),
    wu_weight1 INT,
    wu_rep1 INT,
    wu_weight2 INT,
    wu_rep2 INT,
    work_weight1 INT,
    work_rep1 INT,
    work_weight2 INT,
    work_rep2 INT,
    FOREIGN KEY (workout_id) REFERENCES workout(workout_id)
)";

$conn->query($sql);

// Plyometrics Exercises
$sql = "CREATE TABLE IF NOT EXISTS plyoExercise(
    plyo_set INT NOT NULL,
    plyo_name VARCHAR(40),
    sets INT NOT NULL,
    reps INT NOT NULL
)";

$conn->query($sql);

$sql_plyoValues = "INSERT INTO `plyoExercise` (`plyo_set`, `plyo_name`, `sets`, `reps`)
    VALUES
    (3, 'Jumping Jacks', 1, 50),
    (3, 'Jump Squat', 3, 10),
    (3, 'Forward Jump', 3, 5),
    (3, 'Reverse Jump', 3, 5),
    (3, 'Decline Push', 3, 5),
    (3, 'Side Jump', 3, 5),
    (3, 'Calf Jump', 1, 50),
    (3, 'Power Push Up', 3, 5),
    (3, 'Forward Squat to Jump Squat', 2, 5),
    (3, 'Jump Squat to Reverse Squat', 2, 5),
    (3, 'Burpees', 3, 6),
    (3, 'Squat Ball', 3, 10),
    (4, 'Jumping Jacks', 1, 80),
    (4, 'Jump Squat', 3, 12),
    (4, 'Forward Jump', 3, 8),
    (4, 'Reverse Jump', 3, 8),
    (4, 'Decline Push', 3, 8),
    (4, 'Side Jump', 3, 8),
    (4, 'Calf Jump', 1, 70),
    (4, 'Power Push Up', 3, 10),
    (4, 'Forward Squat to Jump Squat', 2, 8),
    (4, 'Jump Squat to Reverse Squat', 2, 8),
    (4, 'Burpees', 3, 10),
    (4, 'Squat Ball', 3, 12),
    (5, 'Jumping Jacks', 1, 100),
    (5, 'Jump Squat', 3, 15),
    (5, 'Forward Jump', 3, 10),
    (5, 'Reverse Jump', 3, 10),
    (5, 'Decline Push', 3, 12),
    (5, 'Side Jump', 3, 10),
    (5, 'Calf Jump', 1, 90),
    (5, 'Power Push Up', 3, 15),
    (5, 'Forward Squat to Jump Squat', 2, 12),
    (5, 'Jump Squat to Reverse Squat', 2, 12),
    (5, 'Burpees', 3, 15),
    (5, 'Squat Ball', 3, 15)
    ";

    $query = "SELECT count(*) as count FROM plyoExercise";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if($row['count'] == 0){
        $conn->query($sql_plyoValues);
    }

$sql = "CREATE TABLE IF NOT EXISTS strengthRepetitions(
    set_num INT NOT NULL,
    lp INT NOT NULL,
    reps INT NOT NULL
)";

$conn->query($sql);

$sql_strengthRepsValues = "INSERT INTO `strengthRepetitions` (`set_num`, `lp`, `reps`)
    VALUES
    (1, 75, 15),(1, 80, 15),(1, 85, 13),(1, 90, 12),(1, 95, 10),(1, 100, 10),
    (2, 75, 15),(2, 80, 13),(2, 85, 12),(2, 90, 10),(2, 95, 10),(2, 100, 8),
    (3, 75, 13),(3, 80, 12),(3, 85, 10),(3, 90, 8),(3, 95, 8),(3, 100, 6),
    (4, 75, 12),(4, 80, 12),(4, 85, 10),(4, 90, 8),(4, 95, 6),(4, 100, 5)
    ";


    $query = "SELECT count(*) as count FROM strengthRepetitions";
    $result1 = $conn->query($query);
    $row1 = $result1->fetch_assoc();

    if($row1['count'] == 0){
        $conn->query($sql_strengthRepsValues);
    }

$sql = "CREATE TABLE IF NOT EXISTS isolation(
    iso_id INT PRIMARY KEY,
    iso_part VARCHAR(40)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS isoExercise(
        iso_id INT,
        idv_iso INT,
        idv_iso_name VARCHAR(40),
        FOREIGN KEY(iso_id) REFERENCES isolation(iso_id)
)";

$conn->query($sql);

$sql_insert_iso = "INSERT INTO `isolation`(`iso_id`, `iso_part`)
    VALUES
    (1, 'Biceps and Triceps'), (2, 'Shoulders'), (3, 'Abs, Core and Side Obliques'), (4, 'Calves'), (5, 'None')
";

    $query = "SELECT count(*) as count FROM isolation";
    $result2 = $conn->query($query);
    $row2 = $result2->fetch_assoc();

    if($row2['count'] == 0){
        $conn->query($sql_insert_iso);
    }

$sql_insert_iso_ex = "INSERT INTO `isoExercise`(`iso_id`, `idv_iso`, `idv_iso_name`)
    VALUES
    (1, 1, 'Bicep Curl and Tricep Push Down'), (1, 2, 'Hammer Curl and Close Grip Tricep Press'), (1, 3, 'Tricep Dip'), (1, 4, 'Tricep Kickback'),
    (2, 1, 'Lateral Raise'), (2, 2, 'Front Raise'), (2, 3, 'Upright Row'), (2, 4, 'Side Deltoid Raise'),
    (3, 1, 'Crunches and Plank'), (3, 2, 'Russian Twist'), (3, 3, 'Leg Raises'), (3, 4, 'Decline and Side Decline Crunches'),
    (4, 1, 'Calf Raises'), (4, 2, 'Seated Calf Raise'), (4, 3, 'Box Jumps'), (4, 4, 'Jump Rope')
    ";

    $query = "SELECT count(*) as count FROM isoExercise";
    $result3 = $conn->query($query);
    $row3 = $result3->fetch_assoc();

    if($row3['count'] == 0){
        $conn->query($sql_insert_iso_ex);
    }

$sql = "CREATE TABLE IF NOT EXISTS contact(
        name VARCHAR(40),
        email VARCHAR(40),
        phone VARCHAR(20),
        subject VARCHAR(100),
        message VARCHAR(255)
)";

$conn->query($sql);

?>