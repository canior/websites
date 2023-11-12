<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

$logEntry = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'subject' => $_POST['subject'],
];
$basePah = '/var/www/html/websites/files/crcreport.com/contact/' . time();
mkdir($basePah, 0777,true);
$logFile = $basePah . '/contact.log'; // Specify the log file path

file_put_contents($logFile, json_encode($logEntry), FILE_APPEND | LOCK_EX);
?>
