<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "school_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $student_id => $details) {
    $status = $details['status'];
    $remarks = $details['remarks'];
    $date = date('Y-m-d');
    
    $sql = "INSERT INTO attendance (student_id, date, status, remarks)
            VALUES ('$student_id', '$date', '$status', '$remarks')";
    
    if (!$conn->query($sql)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

echo json_encode(["message" => "Attendance recorded successfully"]);
$conn->close();
?>
