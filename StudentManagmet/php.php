<?php
session_start();

// Ceck if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit;
}

$studentId = $_SESSION['student_id'];  // Use the logged-in student's ID

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "StudentManagement";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT full_name, email, phone, address FROM Students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <hr>
    <!-- navbar -->
    <nav class="navbar">
        <ul>
            <li><a href="php.php">View Profile</a></li>
            <li><a href="grades.php">Grades</a></li>
            <li><a href="index.html">Timetable</a></li>
            <li><a href="attendance.html">Attendance</a></li>
            <li><a href="academicRecord.php">Academic Record</a></li>
        </ul>
    </nav>
    <hr>

    <!-- Main Container -->
    <div class="container">
        <h2>Student Profile</h2>
        <div id="student-details" class="student-details">
            <?php
            if ($result->num_rows > 0) {
                $student = $result->fetch_assoc();
                echo "<table>";
                echo "<tr><th>Name</th><td>" . htmlspecialchars($student['full_name']) . "</td></tr>";
                echo "<tr><th>Email</th><td>" . htmlspecialchars($student['email']) . "</td></tr>";
                echo "<tr><th>Phone</th><td>" . htmlspecialchars($student['phone']) . "</td></tr>";
                echo "<tr><th>Address</th><td>" . htmlspecialchars($student['address']) . "</td></tr>";
                echo "</table>";
            } else {
                echo "<p>No student found with that ID.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
