<?php
session_start();
include '../conn.php';
//function to send and insert otp in the database
function insertStudentOTP($email, $otp)
{
    global $conn;
    $expiry_time = date('Y-m-d H:i:s', strtotime('+2 minutes'));
    $sql = "UPDATE students SET otp = '$otp', otp_expiry = '$expiry_time' WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        error_log("Error inserting OTP: " . mysqli_error($conn));
        return false;
    }
}
//function to delete otp from the database
function deleteStudentOTP($email)
{
    global $conn;
    $sql = "UPDATE students SET otp = NULL, otp_expiry = NULL WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        error_log("Error deleting OTP: " . mysqli_error($conn));
        return false;
    }
}
//function to generate random otp of 6 digits
function generateStudentOTP()
{
    // Generate a 6-digit OTP
    return rand(100000, 999999);
}
?>