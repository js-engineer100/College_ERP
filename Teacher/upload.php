<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['teacher_loggedin'])) {
    header("location:../index.php");
    exit; 
}

$loggedInTeacherSubjectID = $_SESSION['loggedInTeacher_SubjectId'];



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Check if file was uploaded without errors and it's not empty
    if ($_FILES["csv"]["error"] == 0 && $_FILES["csv"]["size"] > 0) {
        // Check file extension
        $fileExtension = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);
        if (strtolower($fileExtension) != 'csv') {
            $_SESSION['not-allowed'] = "<h3>Only CSV files are allowed.</h3><br>";
            header("location:studentdetails.php");
            exit;
        }

        $filename = $_FILES["csv"]["tmp_name"];
        $file = fopen($filename, "r");

        // Check if file is not empty
        if (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            // If not empty, continue processing
            fgetcsv($file); 

            $fileIsEmpty = true; 

            // looping through csv file for data
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $fileIsEmpty = false; // File is not empty
                $student_id = $data[0];
                $marks_obtained = $data[2];

                $check_query = "SELECT * FROM marks WHERE student_id = '$student_id' AND subject_id = '$loggedInTeacherSubjectID'";
                $check_result = mysqli_query($conn, $check_query);
                if (mysqli_num_rows($check_result) > 0) {
                    $_SESSION['error-csvf'] = "<h3>Data for some  students exists for this subject.</h3>";
                    $allDataImportedSuccessfully = false;
                    continue;
                }

                $query = "INSERT INTO marks (student_id, marks_obtained, subject_id) 
                          VALUES ('$student_id', '$marks_obtained', '$loggedInTeacherSubjectID')";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    $_SESSION['error-csvf'] = "<h3>Error: </h3>" . mysqli_error($conn);
                    $allDataImportedSuccessfully = false;
                }
            }

            fclose($file);
            $_SESSION['csv-success'] = "<h3>CSV data imported successfully.</h3>";

            header("Location: studentdetails.php");
            exit;
        } else {
            $_SESSION['csv-empty'] = "<h3>The uploaded CSV file is empty.</h3>";
            header("location:studentdetails.php");
            exit;
        }
    } else {
        $_SESSION['csv-error'] = "<h3>Please select a file first.</h3>";
        header("location:studentdetails.php");
        exit;
    }
}
?>