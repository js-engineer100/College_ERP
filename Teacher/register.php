<?php
require_once "../conn.php";
session_start();


if (empty($_POST['name']) || empty($_POST['register-email']) || empty($_POST['register-password']) || empty($_POST['department_id']) || empty($_POST['subject_id'])) {
  header("location:../index.php");
    exit;
}


if (isset($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['register-email'];
    $password = $_POST['register-password'];
    $department_id = $_POST['department_id'];
    $subject_id = $_POST['subject_id'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);


    // new entry insertion into database(new registration)
    $sql = "INSERT INTO teachers (`teacher_name`, `email`, `password`, `department_id`, `subject_id`) VALUES ('$name', '$email', '$hashed_password', '$department_id', '$subject_id')";

    if (mysqli_query($conn, $sql)) {

        header("location: ../index.php?registered-successfully=1");
    } else {
        echo "Something went wrong. Please try again later.";
    }
}
?>