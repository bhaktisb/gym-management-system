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

// Retrieve form data and sanitize it
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// SQL query to insert data into database
$sql_insert = "INSERT INTO gym_registration (name, email, phone)
        VALUES ('$name', '$email', '$phone')";

if ($conn->query($sql_insert) === TRUE) {
    $message = "Registration successful!";
} else {
    $message = "Error: " . $sql_insert . "<br>" . $conn->error;
}

// SQL query to create or update the view
$sql_create_view = "CREATE OR REPLACE VIEW gym_registration_view AS SELECT id, name, email, phone FROM gym_registration";
if ($conn->query($sql_create_view) === TRUE) {
    $message .= "<br>View created or updated successfully!";
} else {
    $message .= "<br>Error creating or updating view: " . $conn->error;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Membership Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="text-center">Gym Membership Registration</h3>
                </div>
                <div class="card-body">
                    <p><?php echo $message; ?></p>
                    <div class="text-center">
                        <a href="index.html" class="btn btn-primary">Return to Home</a>
                        <a href="#" class="btn btn-secondary">Done</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
