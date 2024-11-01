<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost'; // Database host
$user = 'root'; // Database username
$password = ''; // Database password
$dbname = 'crm_db';

// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Handle POST request to save an event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["error" => "Invalid JSON data"]);
        exit;
    }

    // Validate input data
    if (!isset($data['year'], $data['month'], $data['day'], $data['title'], $data['time_from'], $data['time_to'])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit;
    }

    $event_date = $data['year'] . '-' . str_pad($data['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($data['day'], 2, '0', STR_PAD_LEFT);
    $title = $data['title'];
    $time_from = $data['time_from'];
    $time_to = $data['time_to'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO events (event_date, title, event_time_from, event_time_to, created_at) VALUES (?, ?, ?, ?, NOW())");

    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    $stmt->bind_param('ssss', $event_date, $title, $time_from, $time_to);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => "Event added successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }
    $stmt->close();
}

$conn->close();
?>
