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

$conn->close();
?>
