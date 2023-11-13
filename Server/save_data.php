<?php
// Get sensor data from the HTTP request (assuming it's sent as parameters)
$humidity = $_GET['humidity'];
$temperature = $_GET['temperature'];

// Define the file path
$filePath = "sensor_data.txt";

// Read existing content from the file
$existingContent = file_get_contents($filePath);
$sensorDataArray = json_decode($existingContent, true);

// Ensure $sensorDataArray is an array
if (!is_array($sensorDataArray)) {
    $sensorDataArray = [];
}

// Add the new sensor data to the array
$newData = [
    'humidity' => $humidity,
    'temperature' => $temperature,
    'timestamp' => date('Y-m-d H:i:s'), // Add a timestamp for each record
];

// Add the new data to the end of the array
array_push($sensorDataArray, $newData);

// Keep only the last 9 records
$sensorDataArray = array_slice($sensorDataArray, -9);

// Encode the array as JSON
$jsonData = json_encode($sensorDataArray, JSON_PRETTY_PRINT);

// Write the JSON data to the file
if (file_put_contents($filePath, $jsonData, LOCK_EX) !== false) {
    echo "Data saved to file successfully";
} else {
    echo "Error writing to file";
}
?>
