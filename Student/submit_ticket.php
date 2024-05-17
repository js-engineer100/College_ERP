<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['student_loggedin'])) {
    header("Location: ../index.php");
    exit();
}
// submission of newly raised revaluation ticket by the student.. 
$ticketRefId = $_POST['ticketRefId'];
$studentId = $_POST['student_id'];
$subjectId = $_POST['subject_id'];
$comment = $_POST['comment'];
$mark_id = $_POST['mark_id'];

$sql = "INSERT INTO ticket (ticket_ref_id, student_id, subject_id, ticket_status, created_at , comment, mark_id) 
            VALUES ('$ticketRefId', '$studentId', '$subjectId', 'open', NOW(),'$comment','$mark_id')";

if (mysqli_query($conn, $sql)) {
    echo 200;
} else {
    echo 500;
}


?>