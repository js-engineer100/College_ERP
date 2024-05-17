<?php
session_start();
include '../conn.php';
include 'student_otpfunctions.php';



if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    //    Authentication logic for student
    $sql = "SELECT student_id, password FROM students WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        // Logic to verify encrypted password for student
        if (password_verify($password, $hashed_password)) {

            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['email'] = $email;
            $otp = generateStudentOTP();
            $_SESSION['generated_otp'] = $otp;
            $_SESSION['time'] = time();
            $insertResult = insertStudentOTP($email, $otp);
            if (!$insertResult) {
                // keep student_loggedin variable false until the otp is not verified
                $_SESSION['student_loggedin'] = false;

                header("Location: ../index.php?error=Error storing OTP in the database");
                exit();
            }

            header("Location: student_otpf.php");
            exit();
        } else {
            $_SESSION['credentials'] = "<h3><b>Invalid credentials....</b></h3>";
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['user_not_found'] = "<h3><b>User not found....</b></h3>";
        header("Location: ../index.php?error=User not found");
        exit();
    }


} else {

    header("Location: ../index.php");
    exit();
}



