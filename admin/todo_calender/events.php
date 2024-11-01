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
    exit; // Terminate the script on connection failure
}

// Handle GET request to retrieve events
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT DAY(event_date) AS day, MONTH(event_date) AS month, YEAR(event_date) AS year, title, event_time_from AS time_from, event_time_to AS time_to FROM events WHERE MONTH(event_date) = ? AND YEAR(event_date) = ?");
    
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    $stmt->bind_param('ii', $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $events = [];

    while ($row = $result->fetch_assoc()) {
        $events[] = [
            "day" => $row["day"],
            "month" => $row["month"],
            "year" => $row["year"],
            "title" => $row["title"],
            "time" => $row["time_from"] . " - " . $row["time_to"]
        ];
    }

    echo json_encode($events);
    $stmt->close();
}

// Handle POST request to save an event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["error" => "Invalid JSON data"]);
        exit; // Terminate on JSON error
    }

    // Validate input data
    if (!isset($data['year'], $data['month'], $data['day'], $data['title'], $data['time_from'], $data['time_to'])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit; // Terminate on missing data
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
