<?php
require 'db.php'; 
session_start(); 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full-name'];
    $phone_no = $_POST['phone-no'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $id_type = $_POST['id-type'];
    $government_id = $_POST['government-id'];
    $skills = $_POST['skills'];
    $work_experience = $_POST['work-experience'];
    $role = $_POST['role'];
    $location = $_POST['location'];
    $city = isset($_POST['city']) ? $_POST['city'] : null;

   
    $personal_details_query = "INSERT INTO personal_details (user_id, full_name, phone, email, education, govt_id_type, govt_id_number, skills, work_experience, applying_for, location, city) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($personal_details_query);
    $stmt->bind_param("issssssssss", $user_id, $full_name, $phone_no, $email, $education, $id_type, $government_id, $skills, $work_experience, $role, $location, $city);
    
    if ($stmt->execute()) {
       
        header("Location: jobs.html");
        exit();
    } else {
        echo "<script>alert('Failed to submit details: " . $conn->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details - Job Recruitment Portal</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header id="main-header">
        <div class="container">
            <div class="index_header">
                <div class="logo-container">
                    <img src="./skill-scape-high-resolution-logo-white-transparent.png" alt="Company Logo" class="logo" width="180px">
                </div>
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li><a href="index.html" class="nav-link">Home</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="personal-details">
        <h2>Personal Details</h2>
        <form id="personal-details-form" action="personal_details.php" method="post">
            <div class="form-group">
                <label for="full-name">Full Name:</label>
                <input type="text" id="full-name" name="full-name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="phone-no">Phone Number:</label>
                <input type="tel" id="phone-no" name="phone-no" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="education">Education Qualification:</label>
                <select id="education" name="education" required>
                    <option value="" disabled selected>Select your qualification</option>
                    <option value="btech">B.Tech/B.E</option>
                    <option value="mtech">M.Tech/M.E</option>
                    <option value="bca">BCA</option>
                    <option value="mca">MCA</option>
                    <option value="diploma">Diploma</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id-type">Government ID Type:</label>
                <select id="id-type" name="id-type" required>
                    <option value="" disabled selected>Select your ID type</option>
                    <option value="aadhaar">Aadhaar Card</option>
                    <option value="pan">PAN Card</option>
                    <option value="driving_license">Driving License</option>
                    <option value="voter_id">Voter ID</option>
                    <option value="passport">Passport</option>
                </select>
            </div>
            <div class="form-group">
                <label for="government-id">ID Proof Number:</label>
                <input type="text" id="government-id" name="government-id" placeholder="Enter your ID proof number" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills:</label>
                <textarea id="skills" name="skills" rows="4" placeholder="List your skills" required></textarea>
            </div>
            <div class="form-group">
                <label for="work-experience">Work Experience:</label>
                <select id="work-experience" name="work-experience" required>
                    <option value="" disabled selected>Select your experience level</option>
                    <option value="fresher">Fresher</option>
                    <option value="1-2_years">1-2 years</option>
                    <option value="2-5_years">2-5 years</option>
                    <option value="above_5_years">Above 5 years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Applying For Role:</label>
                <input type="text" id="role" name="role" placeholder="Enter the role you are applying for" required>
            </div>
            <div class="form-group">
                <label for="location">Preferred Location:</label>
                <select id="location" name="location" required onchange="showCityDropdown()">
                    <option value="">Select an option</option>
                    <option value="WFH">Work From Home</option>
                    <option value="selected-location">Selected Location</option>
                    <option value="any-location">Any Location</option>
                </select>
            </div>
            
            <div class="form-group" id="city-dropdown" style="display: none;">
                <label for="city">Select City:</label>
                <select id="city" name="city">
                    <option value="" disabled selected>Select your city</option>
                    <option value="ahmedabad">Ahmedabad</option>
                    <option value="gandhinagar">Gandhinagar</option>
                    <option value="pune">Pune</option>
                    <option value="bengaluru">Bengaluru</option>
                    <option value="mumbai">Mumbai</option>
                    <option value="delhi">Delhi</option>
                    <option value="noida">Noida</option>
                    <option value="kolkata">Kolkata</option>
                </select>
            </div>    
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Online Recruitment System. All rights reserved.</p>
        <nav>
            <ul>
                <li><a href="terms.html">Terms & Conditions</a></li>
                <li><a href="privacy.html">Privacy Policy</a></li>
            </ul>
        </nav>
    </footer>
    <script>
        function showCityDropdown() {
            var locationSelect = document.getElementById("location");
            var cityDropdown = document.getElementById("city-dropdown");
            
            if (locationSelect.value === "selected-location") {
                cityDropdown.style.display = "block"; 
            } else {
                cityDropdown.style.display = "none"; 
            }
        }
    </script>

</body>
</html>
