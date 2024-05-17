<?php
require_once "../conn.php";

if (empty($_POST['name']) || empty($_POST['register-email']) || empty($_POST['register-password'])) {
    header("location:../index.php");
    exit;
}
// students details that is required to register
if (isset($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['register-email'];
    $password = $_POST['register-password'];
    $phoneno = $_POST['phone'];
    $department_id = $_POST['department_id'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    // Inserting new students details in the database

    $sql_student = "INSERT INTO students (`student_name`, `email`, `password`, `phone`, `department_id`) VALUES ('$name', '$email', '$hashed_password', '$phoneno','$department_id')";

    if (mysqli_query($conn, $sql_student)) {
        header("location: ../index.php?registered-successfully=1");
    } else {
        echo "Something went wrong. Please try again later.";
    }
}
?>