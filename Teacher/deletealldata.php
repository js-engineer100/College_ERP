<?php
session_start();

if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once "../conn.php";

// Check if checkboxes are submitted

if (!empty($_POST['checkbox'])) {
    $ids = ($_POST['checkbox']);

    // multideletion with the help of the checkboxes
    $deleteTicketQuery = "DELETE FROM ticket WHERE mark_id IN ($ids)";
    if (mysqli_query($conn, $deleteTicketQuery)) {

        $deleteMarksQuery = "DELETE FROM marks WHERE mark_id IN ($ids)";
        if (mysqli_query($conn, $deleteMarksQuery)) {
            $_SESSION['multideletion-success'] = "<h3><b>Results deleted successfully.</b></h3>";
        } else {
            echo "Something went wrong while deleting records from the database. Please try again later.";
        }
    } else {
        echo "Something went wrong while deleting records from the database. Please try again later.";
    }

    $ec = $_SERVER['HTTP_REFERER'];
    header("Location: $ec");
    exit;
} else {

    header("Location: dashboard.php");
    exit;
}
?>