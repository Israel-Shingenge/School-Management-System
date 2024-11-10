<?php

$host = 'localhost'; 
$dbname = 'management'; 
$username = 'root'; 
$password = ''; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] == "signup") {
        // Handle Sign Up form submission
        $firstName = htmlspecialchars(trim($_POST["first_name"]));
        $lastName = htmlspecialchars(trim($_POST["last_name"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $repeatPassword = htmlspecialchars(trim($_POST["repeat_password"]));
        $role = $_POST['role']; 
        $phone = htmlspecialchars(trim($_POST["phone"])); 
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($repeatPassword) || empty($role) || empty($phone)) {
            echo "All fields are required.";
        } elseif ($password !== $repeatPassword) {
            echo "Passwords do not match.";
        } else {
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "Email already exists. Please use a different email.";
            } else {
                
                if ($role == 'admin') {
                    $stmt = $conn->prepare("INSERT INTO admins (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                } elseif ($role == 'teacher') {
                    $stmt = $conn->prepare("INSERT INTO teachers (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                } else {
                    $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, email, phone, grade, parent_name, parent_contact, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $grade = htmlspecialchars(trim($_POST["grade"]));  
                    $parentName = htmlspecialchars(trim($_POST["parent_name"])); 
                    $parentContact = htmlspecialchars(trim($_POST["parent_contact"])); 
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
                if ($role == 'student') {
                    $stmt->bind_param("ssssssss", $firstName, $lastName, $email, $phone, $grade, $parentName, $parentContact, $hashedPassword);
                } else {
                    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $hashedPassword);
                }

                if ($stmt->execute()) {
                    echo "Sign Up successful! Welcome, " . $firstName;
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
            $stmt->close();
        }
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == "signin") {
        // Handle Sign In form submission
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars(trim($_POST["password"]));

        if (empty($email) || empty($password)) {
            echo "Both fields are required.";
        } else {
            
            $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            // Verify the password
            if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
                echo "Sign In successful! Welcome back.";
            } else {
                echo "Invalid email or password.";
            }
            $stmt->close();
        }
    }
}


$conn->close();
?>
