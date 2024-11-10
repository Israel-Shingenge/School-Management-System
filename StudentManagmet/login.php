<?php
//This login page is just for testing fr
session_start();  // Start a session to manage login state

// Database connection details
$servername = "localhost";
$username = "root";        // se your database username
$password = "";            // Use your database password
$dbname = "StudentManagement";

// Establishing connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = intval($_POST['studentId']);

    // Check if the student exists
    $sql = "SELECT id FROM Students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Set session to store logged-in student's ID
        $_SESSION['student_id'] = $studentId;
        header('Location: home.php');  // Redirect to home page or dashboard
        exit;
    } else {
        $error_message = "Invalid student ID.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <form action="login.php" method="post">
        <label for="studentId">Student ID:</label>
        <input type="number" id="studentId" name="studentId" min="1" max="4" required>
        <input type="submit" value="Login">
    </form>
    <?php
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
