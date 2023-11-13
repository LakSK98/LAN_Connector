<?php
$servername = "192.168.8.192";
$username = "admin";
$password = "root";
$dbname = "lan_connector";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get sensor data from the HTTP request (assuming it's sent as parameters)
$humidity = $_GET['humidity'];
$temperature = $_GET['temperature'];

// Insert sensor data into the database
$sql = "INSERT INTO sensor_data (humidity, temperature) VALUES ('$humidity', '$temperature')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
