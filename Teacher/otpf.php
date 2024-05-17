<?php
session_start();
include '../conn.php';
include 'otp_functions.php';

if(isset($_SESSION['teacher_loggedin'])){
    header("location:dashboard.php");
}

if (!isset($_SESSION['email']) || !isset($_SESSION['generated_otp'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['verify'])) {
    $enteredOTP = $_POST['otp'];
    $storedOTP = $_SESSION['generated_otp'];
    $oldtime = $_SESSION['time'] + 120;
    $current_time = time();

    if (!empty($storedOTP) && $oldtime >= $current_time) {
        // otp verifiaction logic
        if ($enteredOTP == $storedOTP) {
            
            unset($_SESSION['generated_otp']);
            unset($_SESSION['otp_expiry']);
            // if otp verifies let the teacher login
            $_SESSION['teacher_loggedin'] = true;
            deleteOTP($_SESSION['email']);
            header("location:dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid OTP. Please try again.";
        }
    } else {
        $_SESSION['error_message'] = "OTP has expired. Please request a new one.";
    }
}
if (isset($_POST['resend_otp'])) {
    $email = $_SESSION['email'];
    $otp = generateOTP();

    if (insertOTP($email, $otp)) {
        $_SESSION['resent_message'] = "OTP resent successfully";
        $_SESSION['generated_otp'] = $otp;
        $_SESSION['time'] = time();
    } else {
        echo "Failed to resend OTP. Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>school ERP</title>
    <style>
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            padding: 140px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-content {
            text-align: center;
        }

        #redder:hover {
            background: white !important;
            border: 1px solid red !important;
            color: red !important;
            cursor: pointer;
        }

        #greener:hover {
            background: white !important;
            border: 1px solid green !important;
            color: green !important;
            cursor: pointer;
        }
    </style>
</head>

<body style="background-color:#FDBF60;">
    <div class="card-container">
        <div class="card">
            <div class="card-content">
                <h2 style="margin-right: 100px;">Enter OTP</h2>
                <?php if (isset($_SESSION['error_message'])) { ?>
                    <p style="color: red; margin-right:100px;">
                        <?php echo $_SESSION['error_message']; ?>
                    </p>
                    <?php unset($_SESSION['error_message']); ?>
                <?php } ?>

                <?php if (isset($_SESSION['resent_message'])) { ?>
                    <p style="color: green; margin-right:100px;">
                        <?php echo $_SESSION['resent_message']; ?>
                    </p>
                    <?php unset($_SESSION['resent_message']); ?>
                <?php } ?>

                <form method="POST" style="display: flex; gap: 12px; margin-bottom: 10px;">
                    <input type="text" name="otp" placeholder="Enter One Time Password" required
                        style="outline: none; padding: 10px;">
                    <input type="submit" name="verify" value="Verify OTP" id="greener"
                        style="padding: 10px; border-radius: 5px; border: 1px solid green; outline: none; color:white; font-weight:700; background:green;">
                </form>
                <div class="resend-timer-container" style="display: flex; gap: 64px;">
                    <div id="timer" style="margin-top: 10px; font-weight:700; margin-left:35px;"></div>
                    <form method="POST">
                        <input type="submit" name="resend_otp" value="Resend OTP" id="redder"
                            style="padding: 10px 4px; border-radius: 5px; border: 1px solid red; outline: none; color:white; background:red; font-weight:700; display:none;"
                            onclick="resendOTP()">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // logic for otp timer
        let timerOn = true;

        function startTimer(remaining) {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;

            document.getElementById('timer').innerHTML = 'Time Left: ' + m + ':' + s;
            document.getElementById('timer').style.color = 'red';

            remaining -= 1;

            if (remaining >= 0 && timerOn) {
                setTimeout(function () {
                    startTimer(remaining);
                }, 1000);

                sessionStorage.setItem('remainingTime', remaining);
                return;
            }

            if (!timerOn) {
                return;
            }
            document.getElementById('redder').style.display = 'block';
        }

        function initializeTimer() {
            let remainingTime = sessionStorage.getItem('remainingTime');
            if (remainingTime !== null) {
                startTimer(parseInt(remainingTime));
            } else {
                startTimer(120);
            }
        }

        function resetTimer() {
           
            alert('vedya');
        }

        function resendOTP() {
            startTimer(120);
        }

        window.onload = initializeTimer;
        

    </script>

</body>

</html>