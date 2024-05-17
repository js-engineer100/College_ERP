<?php
session_start();

include '../conn.php';

if (isset($_POST['verify-email'])) {
    $email = $_POST['verify-email'];

    // student email verification so that if student's email exists it will redirect it to the forgetpassword page..
    $query = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;

        header("Location:studentforgetpassword.php");
        exit();
    } else {
        $_SESSION["no_email"] = "user not found";
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>