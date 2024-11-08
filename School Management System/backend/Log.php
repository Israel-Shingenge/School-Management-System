<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] == "signup") {
        // Handle Sign Up form submission
        $username = htmlspecialchars(trim($_POST["username"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $repeatPassword = htmlspecialchars(trim($_POST["repeat_password"]));

        if (empty($username) || empty($email) || empty($password) || empty($repeatPassword)) {
            echo "All fields are required.";
        } elseif ($password !== $repeatPassword) {
            echo "Passwords do not match.";
        } else {
            echo "Sign Up successful! Welcome, " . $username;
        }
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == "signin") {
        // Handle Sign In form submission
        $username = htmlspecialchars(trim($_POST["username"]));
        $password = htmlspecialchars(trim($_POST["password"]));

        if (empty($username) || empty($password)) {
            echo "Both fields are required.";
        } else {
            echo "Sign In successful! Welcome back, " . $username;
        }
    }
}
?>
