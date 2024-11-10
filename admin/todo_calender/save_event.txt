<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crm_dm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$event_date = $data['event_date'];
$event_time_from = $data['event_time_from'];
$event_time_to = $data['event_time_to'];
$title = $data['title'];

$sql = "INSERT INTO events (event_date, event_time_from, event_time_to, title) VALUES ('$event_date', '$event_time_from', '$event_time_to', '$title')";

if ($conn->query($sql) === TRUE) {
  echo json_encode(["success" => true, "message" => "Event added successfully."]);
} else {
  echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
