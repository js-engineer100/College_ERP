<?php
session_start();
if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require_once "../conn.php";

if (empty($_POST['marks'])) {
    echo json_encode(array('status' => false, 'msg' => 'Please enter your marks'));
    exit;
}
$id = $_POST['mark_id'];
$marks = $_POST['marks'];
// marks updation query
$res = mysqli_query($conn, "UPDATE marks SET marks_obtained = '" . $marks . "' WHERE mark_id = '" . $id . "'");
if ($res) {
    echo json_encode(array('status' => true, 'msg' => 'Results has been updated successfully.'));
    exit;
} else {
    echo json_encode(array('status' => false, 'msg' => 'Results not updated'));
}
$conn->close();
?>