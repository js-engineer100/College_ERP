<?php
require_once "../conn.php";
session_start();

if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}

// Validation of marks
if (empty($_POST['marks'])) {
    $_SESSION['adderror'] = "<h3><b>Subject and Marks cannot be empty....</b></h3>";
    header("location:studentdetails.php");
    exit;
}

if (isset($_POST)) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $marks = $_POST['marks'];

    // Check if marks already exist for the student and subject
    $check_query = "SELECT * FROM marks WHERE student_id = $student_id AND subject_id = $subject_id";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Marks already exist, you can handle this case as per your requirement
        $_SESSION['data_error'] = "<h3><b>Marks already exist for this student in this subject</b></h3>";
        header("location:studentdetails.php");
        exit;
    } else {
        // Insertion of marks into the database
        $sql_results = "INSERT INTO marks (student_id, subject_id, marks_obtained) VALUES ($student_id, $subject_id, $marks)";

        if ($conn->query($sql_results) === TRUE) {
            $_SESSION['data_success'] = "<h3><b>Result added successfully</b></h3>";
            header("location:studentdetails.php");
        } else {
            echo "Error: " . $sql_results . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>