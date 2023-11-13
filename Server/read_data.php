<?php
// Define the file path
$filePath = "sensor_data.txt";

// Read existing content from the file
$existingContent = file_get_contents($filePath);

// Decode the JSON data
$sensorDataArray = json_decode($existingContent, true);

// Ensure $sensorDataArray is an array
if (!is_array($sensorDataArray)) {
    $sensorDataArray = [];
}

// Set the character encoding and allow CORS
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // Adjust this based on your security requirements
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Output the JSON response
echo json_encode($sensorDataArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
