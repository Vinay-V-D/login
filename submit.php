<?php
/*
  submit.php
  Backend Handler for Registration Form
  - Sanitizes and validates inputs
  - Displays confirmation or errors
*/

// Enable error reporting for debugging (Disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define variables and set to empty values
$name = $email = $phone = $dob = $gender = $course = $address = "";
$errors = [];

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 1. Sanitize & Retrieve Inputs ---
    // filter_input gets the variable and sanitizes it (removes/escapes chars)
    $name = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS); // Date string
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
    $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Checkbox is either set or not
    $terms = isset($_POST['terms']);

    // --- 2. Server-Side Validation ---
    
    // Name: Required, min 2 chars
    if (empty($name) || strlen(trim($name)) < 2) {
        $errors[] = "Full Name is required and must be at least 2 characters.";
    }

    // Email: Required, valid format
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid Email Address is required.";
    }

    // Phone: Required, 10 digits
    // Remove non-digits first to check length
    $digitsOnly = preg_replace('/\D/', '', $phone);
    if (empty($phone) || strlen($digitsOnly) !== 10) {
        $errors[] = "Phone Number must be exactly 10 digits.";
    }

    // Gender: Required
    $validGenders = ['Male', 'Female', 'Other'];
    if (empty($gender) || !in_array($gender, $validGenders)) {
        $errors[] = "Please select a valid Gender.";
    }

    // Course: Required
    if (empty($course)) {
        $errors[] = "Please select a Course.";
    }

    // Terms: Required
    if (!$terms) {
        $errors[] = "You must agree to the Terms & Conditions.";
    }

    // --- 3. Process Result ---

    if (empty($errors)) {
        // SUCCESS CASE: Show Confirmation Page
        // > [!NOTE] Here you would insert data into a MySQL database.
        /*
          // Example DB Code:
          $conn = new mysqli($servername, $username, $password, $dbname);
          $stmt = $conn->prepare("INSERT INTO registrations (name, email...) VALUES (?, ?...)");
          $stmt->bind_param("ss...", $name, $email...);
          $stmt->execute();
        */

        displayConfirmation($name, $email, $phone, $dob, $gender, $course, $address);
    } else {
        // ERROR CASE: Show Errors and Back Button
        displayErrors($errors);
    }

} else {
    // Not a POST request, redirect to form
    header("Location: index.html");
    exit();
}

// --- Helper Functions for HTML Output ---

function displayConfirmation($name, $email, $phone, $dob, $gender, $course, $address) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <!-- Reuse same stylesheet for consistency -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .success-icon { font-size: 3rem; color: #10B981; margin-bottom: 1rem; }
        .data-list { text-align: left; margin-top: 1.5rem; border-top: 1px solid #E5E7EB; padding-top: 1rem; }
        .data-item { margin-bottom: 0.5rem; }
        .data-label { font-weight: 600; color: #4B5563; }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-card" style="text-align: center;">
            <div class="success-icon">&#10004;</div>
            <header class="card-header">
                <h1>Registration Successful!</h1>
                <p>Thank you, <strong><?php echo $name; ?></strong>. We have received your details.</p>
            </header>

            <div class="data-list">
                <div class="data-item"><span class="data-label">Email:</span> <?php echo $email; ?></div>
                <div class="data-item"><span class="data-label">Phone:</span> <?php echo $phone; ?></div>
                <div class="data-item"><span class="data-label">DOB:</span> <?php echo $dob ? $dob : 'N/A'; ?></div>
                <div class="data-item"><span class="data-label">Gender:</span> <?php echo $gender; ?></div>
                <div class="data-item"><span class="data-label">Course:</span> <?php echo $course; ?></div>
                <div class="data-item"><span class="data-label">Address:</span> <?php echo $address ? nl2br($address) : 'N/A'; ?></div>
            </div>

            <div class="form-actions">
                <a href="index.html" style="text-decoration: none;">
                    <button type="button">Register Another Student</button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}

function displayErrors($errors) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Failed</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .error-icon { font-size: 3rem; color: #EF4444; margin-bottom: 1rem; }
        .error-list { text-align: left; background: #FEF2F2; padding: 1rem; border-radius: 8px; border: 1px solid #FECACA; color: #991B1B; }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-card" style="text-align: center;">
            <div class="error-icon">&#9888;</div>
            <header class="card-header">
                <h1>Submission Failed</h1>
                <p>Please fix the following errors and try again.</p>
            </header>

            <ul class="error-list">
                <?php foreach($errors as $err): ?>
                    <li><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>

            <div class="form-actions">
                <!-- Javascript history back to preserve inputs -->
                <button type="button" onclick="history.back()">Go Back & Fix</button>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
?>
