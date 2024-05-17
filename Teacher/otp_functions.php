<?php
session_start();

include '../conn.php';

if(isset($_SESSION['email'])){

// function to insert otp into the database.
function insertOTP($email, $otp)
{
    global $conn;
    $expiry_time = date('Y-m-d H:i:s', strtotime('+2 minutes'));
    $sql = "UPDATE teachers SET otp = '$otp', otp_expiry = '$expiry_time' WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        error_log("Error inserting OTP: " . mysqli_error($conn));
        return false;
    }
}
// function to delete otp after the verification
function deleteOTP($email)
{
    global $conn;
    $sql = "UPDATE teachers SET otp = NULL, otp_expiry = NULL WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        error_log("Error deleting OTP: " . mysqli_error($conn));
        return false;
    }
}
// function to generate otp of 6 digits
function generateOTP()
{
    // Generate a 6-digit OTP
    return rand(100000, 999999);
}
}else{
    header("location:../index.php");
}
?>