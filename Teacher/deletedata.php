<?php
session_start();


if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require_once "../conn.php";


$ec = $_SERVER['HTTP_REFERER'];


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    // single deletion logic
    $deleteTicketQuery = "DELETE FROM ticket WHERE mark_id = '$id'";

    if (mysqli_query($conn, $deleteTicketQuery)) {

        $deleteMarksQuery = "DELETE FROM marks WHERE mark_id = '$id'";
        if (mysqli_query($conn, $deleteMarksQuery)) {

            $_SESSION['singledeletion-success'] = "<h3><b>Result deleted successfully.</b></h3>";

            header("Location: $ec");
            exit;
        } else {

            echo "Something went wrong while deleting the record from the database. Please try again later.";
        }
    } else {
        echo "Something went wrong while deleting associated records from the database. Please try again later.";
    }
} else {

    echo "Invalid request.";
}
?>