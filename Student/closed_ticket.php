<?php
include "../conn.php";
session_start();
// To update ticket status to cancelled from student side
$id = $_GET["id"];

$ec = $_SERVER['HTTP_REFERER'];
$query = "UPDATE ticket SET ticket_status = 'cancelled', closed_at = NOW() WHERE ticket_id = '$id'";




if (mysqli_query($conn, $query)) {
    $_SESSION['ticket-close'] = "<h3><b>Ticket cancelled successfully....</b></h3>";

    header("Location: support_ticket.php");
    exit;
} else {
    echo "Something went wrong. Please try again later.";
}

?>