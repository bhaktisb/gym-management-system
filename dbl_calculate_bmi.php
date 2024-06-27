<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "bhandebh@123";
$dbname = "Gymmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$weight = $_POST['weight'];
$height = $_POST['height'];
$age = $_POST['age'];
$gender = $_POST['gender'];

// BMI Calculation
// Convert height from CM to meters
$height_meters = $height / 100;

// Calculate BMI
$bmi = $weight / ($height_meters * $height_meters);

// Prepare the SQL statement with placeholders
$sql = "INSERT INTO bmi_data (weight, height, age, gender, bmi)
        VALUES (?, ?, ?, ?, ?)";

// Prepare and bind the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ddiss", $weight, $height, $age, $gender, $bmi);

// Execute the statement
if ($stmt->execute()) {
    echo "BMI calculated and saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>


