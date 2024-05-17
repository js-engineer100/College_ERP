<?php
include "../conn.php";

//To check already existing email in the database
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $query = mysqli_query($conn, "SELECT email FROM students WHERE email='$email'");

    if (mysqli_num_rows($query) != 0) {
        echo "exists";
    } else {
        echo "not_exists";
    }
} else {

    header("location:../index.php");
}
