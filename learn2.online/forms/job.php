<?php

// Define the path to the log file and upload directory
$basePah = '/var/www/html/websites/files/learn2.online/job/' . time();
mkdir($basePah, 0777,true);
$logFile = $basePah . '/id.log'; // Specify the log file path
$uploadDir = $basePah . '/'; // Specify the directory for file uploads

// Function to safely get form data
function getPostData($key) {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : '';
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = getPostData('firstName');
    $lastName = getPostData('lastName'); // Assuming 'name' is for the last name
    $email = getPostData('email'); // Assuming 'phone' is for the email
    $phone = getPostData('phone');
    // Prepare the log entry
    $logEntry = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'phone' => $phone,
    ];

    // Write to log file
    file_put_contents($logFile, json_encode($logEntry), FILE_APPEND | LOCK_EX);

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $identityFile = $_FILES['resume']['name'];
        $tempName = $_FILES['resume']['tmp_name'];
        $path = $uploadDir . basename($identityFile);

        // Move the file to the upload directory
        if (move_uploaded_file($tempName, $path)) {
            echo 'OK';
        } else {
            echo 'No file uploaded or file upload error.';
        }
    } else {
        echo 'No file uploaded or file upload error.';
    }

    // Redirect or send a response here if needed
    // header('Location: thank_you_page.php'); // Redirect to a thank you page
    exit;
}
?>
