<?php
header("Content-Type: application/json");
$servername = "localhost";   // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "crm_db";   // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Retrieve events for a specific date
    $date = $_GET['date'];
    $sql = "SELECT * FROM events WHERE event_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    echo json_encode($events);
} elseif ($method === 'POST') {
    // Add a new event
    $data = json_decode(file_get_contents("php://input"), true);
    $event_date = $data['event_date'];
    $event_time_from = $data['event_time_from'];
    $event_time_to = $data['event_time_to'];
    $title = $data['title'];

    $sql = "INSERT INTO events (event_date, event_time_from, event_time_to, title) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $event_date, $event_time_from, $event_time_to, $title);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Event added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add event"]);
    }
}

$conn->close();
?>
