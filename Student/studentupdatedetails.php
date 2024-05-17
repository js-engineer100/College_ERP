<?php
session_start();




if (!isset($_SESSION['student_loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require_once "../conn.php";
if (empty($_POST["phone"])) {
    $_SESSION["empty_phone"] = "<h3>Please enter your phone number</h3>";
    header("location:studentprofile.php");
}
if (empty($_POST["email"])) {
    $_SESSION["empty_email"] = "<h2>please enter your email address</h2>";
    header("location:studentprofile.php");
}
$email = $_POST["email"] ?? '';
$phone = $_POST["phone"] ?? '';
$student_id = $_POST["student_id"] ?? '';

if (!empty($email) && !empty($phone) && !empty($student_id)) {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $id = $_POST['student_id'];
    // updating student details when the student want to update the details from his profile section

    $sql = "UPDATE students SET email = '$email', phone = $phone WHERE student_id = '$id'";


    if (mysqli_query($conn, $sql)) {
        $_SESSION["psuccess"] = "<h2>profile updated successfully</h2>";
        header("location:studentprofile.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }

}

