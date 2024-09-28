
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Recruitment Portal - Login</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container form-page">
        <div class="left-section">
            <img src="./skill-scape-high-resolution-logo-black-transparent.png" alt="Company Logo" class="logo" width="180px">
        </div>

        <div class="right-section">
            <div class="form-container">
                <h2>Login</h2>
                <form id="login-form" action="login.php" method="post">
                    <div class="form-group">
                        <label for="login-email">Email:</label>
                        <input type="email" id="login-email" class="input-field" placeholder="Enter your email" name="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password:</label>
                        <input type="password" id="login-password" class="input-field" placeholder="Enter your password" name="login-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Login</button>
                </form>
                <p>Don't have an account? <a href="signup.php" class="form-link">Sign up here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
require 'db.php'; 
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];
    $login_query = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($login_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];

  
        header("Location: jobs.html"); 
        exit();
    } else {
        $error = "Invalid email or password!"; 
    }
    $stmt->close();
}
?>