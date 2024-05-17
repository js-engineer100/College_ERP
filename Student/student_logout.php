<?php
session_start();

if (!isset($_SESSION['student_loggedin'])) {

    header("Location: ../index.php");
    exit();
}
// Unset student session variables
unset($_SESSION['student_loggedin']);
unset($_SESSION['student_id']);


if (empty($_SESSION)) {
    session_destroy();
}

header('Location: ../index.php');
exit;
?>