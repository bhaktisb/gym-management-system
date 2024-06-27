<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "bhandebh@123";
$dbname = "Gymmanagement";

// Function to handle database connection
function connectToDatabase($servername, $username, $password, $dbname) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to handle form submission
function handleFormSubmission($conn) {
    // Prepare and bind the statement for inserting data into muscle_building_registration table
    $stmt_insert = $conn->prepare("INSERT INTO muscle_building_registration (name, email, phone, age, gender, experience, goals, current_training, dietary_preferences, injuries, preferred_training_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("sssisssssss", $name, $email, $phone, $age, $gender, $experience, $goals, $current_training, $dietary_preferences, $injuries, $preferred_training_time);

    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $experience = $_POST['experience'];
    $goals = $_POST['goals'];
    $current_training = $_POST['current_training'];
    $dietary_preferences = $_POST['dietary_preferences'];
    $injuries = $_POST['injuries'];
    $preferred_training_time = $_POST['preferred_training_time'];

    // Execute the insertion statement
    if ($stmt_insert->execute()) {
        echo "Registration successful!<br>";
    } else {
        echo "Error: " . $stmt_insert->error . "<br>";
    }

    // Close the insertion statement
    $stmt_insert->close();
}

// Function to create or update the view
function createOrUpdateView($conn) {
    // Create or update the muscle_building_registration_view
    $sql_create_view = "CREATE OR REPLACE VIEW muscle_building_registration_view AS SELECT id, name, email, age, gender, goals FROM muscle_building_registration";
    if ($conn->query($sql_create_view) === TRUE) {
        echo "View created or updated successfully!<br>";
    } else {
        echo "Error creating or updating view: " . $conn->error . "<br>";
    }
}

// Function to display registered users
function displayRegisteredUsers($conn) {
    // Query the view to display registered users
    $sql_view = "SELECT * FROM muscle_building_registration_view";
    $result_view = $conn->query($sql_view);

    // Check if there are any rows returned from the view query
    if ($result_view->num_rows > 0) {
        // Output data of each row
        echo "<h2>Registered Users:</h2>";
        echo "<div class='user-list'>";
        while($row = $result_view->fetch_assoc()) {
            echo "<div class='user-item'>";
            echo "<p><strong>Name:</strong> " . $row["name"]. "</p>";
            echo "<p><strong>Email:</strong> " . $row["email"]. "</p>";
            // You can add more fields here
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No registrations found.</p>";
    }
}

// Main logic
$conn = connectToDatabase($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handleFormSubmission($conn);
}

createOrUpdateView($conn);
displayRegisteredUsers($conn);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <style>
        /* Internal CSS Styles */
        .user-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .user-item {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-item p {
            margin: 0;
            padding: 5px 0;
        }

        .user-item p strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Your HTML form for muscle building registration goes here -->
</body>
</html>
