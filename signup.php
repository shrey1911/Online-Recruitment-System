
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Recruitment Portal - Signup</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    
    <div class="container form-page">
        <div class="left-section">
            <img src="./skill-scape-high-resolution-logo-black-transparent.png" alt="Company Logo" class="logo" width="180px">
        </div>

        <div class="right-section">
            <div class="form-container">
                <h2>Signup</h2>
                <form id="signup-form" action="signup.php" method="post">
                    <div class="form-group">
                        <label for="signup-name">Full Name:</label>
                        <input type="text" id="signup-name" class="input-field" placeholder="Enter your full name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email:</label>
                        <input type="email" id="signup-email" class="input-field" placeholder="Enter your email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password:</label>
                        <input type="password" id="signup-password" class="input-field" placeholder="Create a password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-confirmpassword">Confirm Password:</label>
                        <input type="password" id="signup-confirmpassword" class="input-field" placeholder="Confirm your password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Signup</button>
                </form>
                <p>Already have an account? <a href="login.php" class="form-link">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
require 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate that the passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $check_email_query = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
        } else {
            // Insert user data into the database
            $signup_query = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($signup_query);
            $stmt->bind_param("sss", $full_name, $email, $hashed_password);
            
            if ($stmt->execute()) {
                // Redirect to the personal details page after successful signup
                header("Location: personal_details.php"); // Ensure this page exists
                exit();
            } else {
                echo "<script>alert('Signup failed: " . $conn->error . "');</script>";
            }
        }
        $stmt->close();
    }
}
?>