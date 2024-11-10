<?php
session_start();

// Check if the user is logged in
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

// Query to get grades for the logged-in student
$sql = "SELECT Subjects.subject_name, Grades.year, Grades.grade
        FROM Grades
        INNER JOIN Subjects ON Grades.subject_id = Subjects.id
        WHERE Grades.student_id = ? AND Grades.year BETWEEN 2020 AND 2024
        ORDER BY Grades.year, Subjects.subject_name";
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
    <title>Grades</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <hr>
    <!-- navbarr -->
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

    <!-- main Containr -->
    <div class="container">
        <h2>Grades</h2>
        <table class="grades-table">
            <tr>
                <th>Subject</th>
                <th>Year</th>
                <th>Grade</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['subject_name']) . "</td>
                            <td>" . htmlspecialchars($row['year']) . "</td>
                            <td>" . htmlspecialchars($row['grade']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
