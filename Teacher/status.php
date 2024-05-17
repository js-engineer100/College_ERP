<?php
include "../conn.php";
session_start();
if(!isset($_SESSION['teacher_loggedin'])){
    header("location:../index.php");
}
$id = $_GET["id"];
// ticket status updation logic

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'close') {
    $query = "UPDATE ticket SET ticket_status = 'closed', closed_at = NOW() WHERE ticket_id = '$id'";
    $successMessage = "Ticket closed successfully.";
} elseif ($action == 'pending') {
    $query = "UPDATE ticket SET ticket_status = 'pending' WHERE ticket_id = '$id'";
    $successMessage = "Ticket put on pending successfully.";
} else {

    echo "Invalid action.";
    exit;
}

if (mysqli_query($conn, $query)) {
    $_SESSION['ticket-close'] = "<h3><b>$successMessage</b></h3>";
    header("Location: support.php");
    exit;
} else {
    echo "Something went wrong. Please try again later.";
}
?>