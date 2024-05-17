<?php
session_start();
include '../conn.php';
include 'otp_functions.php';


if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    // Authentication logic for teachers
    $sql = "SELECT teacher_id,subject_id, password FROM teachers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        //  password verification for teachers
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedInTeacher_SubjectId'] = $row['subject_id'];
            $_SESSION['email'] = $email;
            // generation of otp when the credentials are verified
            $otp = generateOTP();
            $_SESSION['generated_otp'] = $otp;
            $_SESSION['time'] = time();

            $insertResult = insertOTP($email, $otp);

            if (!$insertResult) {
                // keep the teacher_loggedin variable false until the 2fa is not done
                $_SESSION['teacher_loggedin'] = false;
                header("Location: ../index.php?error=Error storing OTP in the database");
                exit();
            }

            header("Location: otpf.php");
            exit();
        } else {
            $_SESSION['credentials'] = "<h3><b>Invalid credentials....</b></h3>";

            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['user_not_found'] = "<h3><b>User not found....</b></h3>";
        header("Location: ../index.php");
        exit();
    }

} else {

    header("Location: ../index.php");
    exit();
}
?>