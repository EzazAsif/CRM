<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crm_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$userid = $data['userid'];
$eventDate = $data['event_date'];
$eventTimeFrom = $data['event_time_from'];
$eventTimeTo = $data['event_time_to'];
$title = $data['title'];

$sql = "INSERT INTO events (userid, event_date, event_time_from, event_time_to, title) VALUES ($userid, '$eventDate', '$eventTimeFrom', '$eventTimeTo', '$title')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
