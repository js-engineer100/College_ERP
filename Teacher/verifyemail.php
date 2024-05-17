<?php
session_start();

include '../conn.php';

if (isset($_POST['verify-email'])) {
    $email = $_POST['verify-email'];
    // mail verification of teacher so that he can reset password if their mail exixts in db
    $query = "SELECT * FROM teachers WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;
        

        header("Location:forgetpassword.php");
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