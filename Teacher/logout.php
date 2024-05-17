<?php
session_start();

if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}

// Unset teacher session variables
unset($_SESSION['teacher_loggedin']);
unset($_SESSION['teacher_id']); 


if (empty($_SESSION)) {
    session_destroy();
}

header('Location: ../index.php');
exit;
?>
