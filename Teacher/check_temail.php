<?php
session_start();
include "../conn.php";
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    // to check if the email address is already registered in the database for teacher
    $query = mysqli_query($conn, "SELECT email FROM teachers WHERE email='$email'");
    if (mysqli_num_rows($query) != 0) {
        echo "exists";
    } else {
        echo "not_exists";
    }
} else {

    header("location:../index.php");
}
