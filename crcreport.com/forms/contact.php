<?php
$logEntry = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'subject' => $_POST['subject'],
    'message' => $_POST['message'],
];
$basePah = '/var/www/html/websites/files/crcreport.com/contact/' . time();
mkdir($basePah, 0777, true);
$logFile = $basePah . '/contact.log'; // Specify the log file path
file_put_contents($logFile, json_encode($logEntry), FILE_APPEND | LOCK_EX);
echo "OK";
?>
