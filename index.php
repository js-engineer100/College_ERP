<?php
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Hello, errors!" );

session_start();
include 'conn.php';
if (isset($_SESSION['teacher_loggedin'])) {

    header("Location:Teacher/dashboard.php");
    exit();
}
if (isset($_SESSION['student_loggedin'])) {

    header("Location:Student/studentdashboard.php");
    exit();
}
// successful registration
if (isset($_GET['registered-successfully']) && $_GET['registered-successfully'] == 1) {
    echo '<div class="alert alert-success" role="alert">
    <strong>REGISTERED SUCCESSFULLY, LOGIN BACK AGAIN TO CONTINUE</strong>!
  </div>';
    header("Refresh:0; url=index.php");
}
// successful reset password
if (isset($_GET['reset-password']) && $_GET['reset-password'] == 1) {
    echo '<div class="alert alert-success" role="alert">
    <strong>RESET PASSWORD SUCCESSFULLY, LOGIN BACK AGAIN TO CONTINUE</strong>!
  </div>';
    header("Refresh:0; url=index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>College ERP</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Fixed height for the card */
        .card {
            height: 700px;
            width: 800px;
        }

        body {

            background-color: #FDBF60;

            color: #fff;

        }

        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>
</head>

<body>
    <?php
    // to show user's credentials are invalid
    if (isset($_SESSION['credentials'])) {
        echo $_SESSION['credentials'];
        unset($_SESSION['credentials']);
    }
    // to show user not found error
    if (isset($_SESSION['user_not_found'])) {
        echo $_SESSION['user_not_found'];
        unset($_SESSION['user_not_found']);
    }
    ?>


    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card shadow-lg" style=" margin-top: 60px;">

                    <div class="card-body text-center" id="cardContent" style="margin-top: 120px;">
                        <img src="logos/Crestmark_st_281Blue_RGB_600.png" alt="University Logo" id="universityLogo"
                            style="width:200px;">
                        <h1 class="mt-5 font-weight-bold" style="color: darkblue;">Enterprise Resource Planning
                            (ERP)
                        </h1>
                        <p class="mt-3">
                            <a href="javascript:void(0)" style="font-size: 20px;"
                                onclick="showTeacherLoginForm()"><b>Teacher's Section</b></a>
                            <img src="logos/book_logo.jpg" alt="Book Logo" style="width:120px; height:120px;">
                            <a href="javascript:void(0)" style="font-size:20px;"
                                onclick="showStudentLoginForm()"><b>Student's Section</b></a>
                        </p>
                    </div>
                    <!-- Teacher Login -->


                    <div id="teacherLoginForm" style="display:none; margin-top:70px;">
                        <div class="row justify-content-center">
                            <div class="col-md-6" style="margin-top: 100px;">
                                <h1 id="loginTitle" class="mb-4 font-weight-bold" style="color: #333A73;"><u>Teacher's
                                        Login</u></h1>
                                <form id="loginForm" action="Teacher/authenticate.php" method="post">
                                    <div class="form-group">
                                        <label for="email" style="color: darkblue;">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="e.g. mspaceman@example.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" style="color:darkblue">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="********" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                                    <p class="mt-3" style="color: #333A73;">Don't have an account? <a
                                            href="javascript:void(0)" onclick="showRegisterForm()">Register now</a>.</p>
                                    <a href="javascript:void(0)" onclick="showVerifyEmail()"> forgotten your
                                        password?</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Teacher register -->
                    <div class="col-md-10" style="display:none; margin-left: 62px;" id="registerSection">
                        <div class="row justify-content-center" style="margin-top: 20px;">

                            <h1 id="registerTitle" class="mb-4 font-weight-bold" style="color: #333A73;"><u>Teacher's
                                    Register</u></h1>

                            <form id="registerForm" action="Teacher/register.php" method="post">
                                <div class="form-group" style="width: 350px;">
                                    <label for="name" style="color: darkblue;">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="e.g. Mark spaceman" required maxlength="100"
                                        oninput="validateName(this)">
                                    <small id="nameError" class="nameError" style="color: red; display: none;">Please
                                        enter your full name.</small>
                                </div>
                                <div class="form-group">
                                    <label for="register-email" style="color: darkblue;">Email:</label>
                                    <input type="email" class="form-control" id="register-Temail" name="register-email"
                                        placeholder="e.g. spaceman@example.com" required oninput="validateEmail(this)">
                                    <small id="emailError" class="emailError" style="color: red; display: none;">Please
                                        enter a valid email address.</small>
                                    <small id="emailError2" style="color: red; display: none;">Email address already
                                        registered.</small>
                                </div>
                                <label for="department_id" style="color:darkblue; display:flex;">Department:</label>
                                <select id="department_id" name="department_id" required
                                    style="outline:none;margin-bottom: 15px;width: 12rem;padding: 5px 3px;">
                                    <option value="">Select Department</option>
                                    <?php
                                    // Query to fetch department details
                                    $sql = "SELECT department_id, department_name FROM departments";
                                    $result = $conn->query($sql);

                                    // Check if there are any rows returned
                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['department_id'] . "'>" . $row['department_name'] . "</option>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                                </select><br>
                                <label for="subject_id" style="color:darkblue;display:flex;">
                                    Speciality Subject:</label>
                                <select id="subject_id" name="subject_id" required
                                    style="outline:none;margin-bottom: 15px;width: 12rem;padding: 5px 3px; ">
                                    <option value="">Select Subject</option>
                                    <?php

                                    $sql = "SELECT subject_id, subject_name FROM subjects";
                                    $result = $conn->query($sql);

                                    // Check if there are any rows returned
                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
                                        }
                                    } else {
                                        echo '<option value="">Country not available</option>';
                                    }


                                    ?>
                                </select>

                                <div class=" form-group">
                                    <label for="register-password" style="color: darkblue;">Password:</label>
                                    <input type="password" class="form-control passo pwds" id="register-password"
                                        name="register-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                        placeholder="********" required onkeyup="check()">
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password" style="color: darkblue;">Confirm Password:</label>
                                    <input type="password" class="form-control pwds" id="confirm-password"
                                        name="confirm-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                        placeholder="********" required onkeyup="check()">
                                    <p id="Messagei"></p>
                                </div>

                                <button type="submit" class="btn btn-primary">Register</button>
                                <p class="mt-3" style="color: #333A73;">Already have an account? <a
                                        href="javascript:void(0)" onclick="showTeacherLoginForm()">Login here</a>.</p>
                            </form>

                        </div>
                    </div>
                    <!-- reset password for teacher -->
                    <div class="container">
                        <div class="row justify-content-center mt-5">
                            <div class="col-md-8">


                                <div class="col-md-10"
                                    style="display: none; color:#333A73; margin:auto; padding-top: 110px; margin-top:100px;"
                                    id="verifyEmailSection">

                                    <h1 id="verifyemail" class="mb-4 font-weight-bold"><u>Reset password </u></h1>
                                    <form id="verifyEmailForm" action="Teacher/verifyemail.php" method="post">
                                        <div class="form-group">
                                            <label for="verify-email">Email:</label>
                                            <input type="email" class="form-control" id="verify-email"
                                                name="verify-email" placeholder="e.g. spaceman@example.com" required
                                                oninput="validateEmail(this)">
                                            <small id="emailError" style="color: red; display: none;">Please enter a
                                                valid email address.</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Verify email</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- student login -->
                    <div id="studentLoginForm" style="display:none;">
                        <div class="row justify-content-center" style="margin-top:112px;">
                            <div class="col-md-6">
                                <h1 id="loginTitle" class="mb-4 font-weight-bold" style="color: #333A73;"><u>Student's
                                        Login</u></h1>
                                <form id="loginForm" action="Student/studentauthenticate.php" method="post">
                                    <div class="form-group">
                                        <label for="email" style="color: darkblue;">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="e.g. student@example.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" style="color:darkblue">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="********" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                                    <p class="mt-3" style="color: #333A73;">Don't have an account? <a
                                            href="javascript:void(0)" onclick="showStudentRegisterForm()">Register
                                            now</a>.</p>
                                    <a href="javascript:void(0)" onclick="showStudentVerifyEmail()"> forgotten your
                                        password?</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Student Register -->

                    <div class="col-md-10" style="display:none; margin-left: 62px; position:absolute; margin-top: 35px;"
                        id="StudentregisterSection">
                        <div class="row justify-content-center" style="margin-top: 50px;">

                            <h1 id="registerTitle" class="mb-4 font-weight-bold" style="color: #333A73;"><u>Student's
                                    Register</u></h1>

                            <form id="registerForm" action="Student/studentregister.php" method="post">
                                <div class="form-group" style="width:350px;">
                                    <label for="name" style="color: darkblue;">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="e.g. student name" required maxlength="100"
                                        oninput="validateName(this)">
                                    <small id="nameError" class="nameError" style="color: red; display: none;">Please
                                        enter your full name.</small>
                                </div>
                                <div class="form-group">
                                    <label for="register-email" style="color: darkblue;">Email:</label>
                                    <input type="email" class="form-control" id="register-email" name="register-email"
                                        placeholder="e.g. student@example.com" required oninput="validateEmail(this)">
                                    <small id="emailError" class="emailError" style="color: red; display: none;">Please
                                        enter a valid email address.</small>
                                    <small id="emailError1" style="color: red; display: none;">Email address already
                                        registered.</small>
                                </div>
                                <div class="form-group">
                                    <label for="phone-number" style="color: darkblue;">Phone-no:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        placeholder="e.g., 1234567890" maxlength="10" required
                                        onkeypress='validate(event)' onpaste='validate(event)'>
                                </div>
                                <label for="department_id" style="color:darkblue; display:flex;">Branch:</label>
                                <select id="department_id" name="department_id" required
                                    style="outline:none;margin-bottom: 15px;width: 12rem;padding: 5px 3px;">
                                    <option value="">Select Branch</option>
                                    <?php
                                    // Query to fetch department details
                                    $sql = "SELECT department_id, department_name FROM departments";
                                    $result = $conn->query($sql);

                                    // Check if there are any rows returned
                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['department_id'] . "'>" . $row['department_name'] . "</option>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                                </select><br>
                                <div class="form-group">
                                    <label for="register-password" style="color: darkblue;">Password:</label>
                                    <input type="password" class="form-control passo" name="register-password"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                        placeholder="********" required>

                                </div>
                                <button type="submit" class="btn btn-primary">Register</button>
                                <p class="mt-3" style="color: #333A73;">Already have an account? <a
                                        href="javascript:void(0)" onclick="showStudentLoginForm()">Login here</a>.</p>
                            </form>

                        </div>
                    </div>
                    <!-- password Reset for student register -->
                    <div class="col-md-10" style="display: none; color:#333A73; margin-left:180px; padding-top:90px;"
                        id="StudentverifyEmailSection">
                        <h1 id="verifyemail" class="mb-4 font-weight-bold" style="margin-top:90px;"><u>Reset
                                password</u></h1>
                        <form id="verifyEmailForm" action="Student/studentverifymail.php" method="post">
                            <div class="form-group">
                                <label for="verify-email">Email:</label>

                                <input type="email" class="form-control" id="verify-email" name="verify-email"
                                    style="width: 380px;" placeholder="e.g. spaceman@example.com" required
                                    oninput="validateEmail(this)">
                                <small id="emailError" style="color: red; display: none;">Please enter a valid email
                                    address.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Verify email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- password Input Validation -->

        <div class="row justify-content-center mt-5">
            <div class="card" style="width: 440px; height:210px; display:none;" id="message">
                <div class="card-body">
                    <h2 style="color:#333A73; font-size:22px; border-radius:5px; margin-bottom:10px;">
                        <b>Password must contain the following:</b>
                    </h2>
                    <p id="letter" class="invalid" style="margin-left:90px;">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid" style="margin-left:90px;">A <b>capital (uppercase)</b> letter
                    </p>
                    <p id="number" class="invalid" style="margin-left:90px;">A <b>number</b></p>
                    <p id="length" class="invalid" style="margin-left:90px;">Minimum <b>8 characters</b></p>
                </div>
            </div>
        </div>

    </div>





    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function showRegisterForm() {
            document.getElementById("teacherLoginForm").style.display = "none";
            document.getElementById('registerSection').style.display = 'block';
            document.getElementById('verifyEmailSection').style.display = 'none';
            document.getElementById("studentLoginForm").style.display = "none";
            document.getElementById("StudentregisterSection").style.display = "none";
        }

        function showStudentRegisterForm() {
            document.getElementById("teacherLoginForm").style.display = "none";
            document.getElementById("studentLoginForm").style.display = "none";
            document.getElementById('registerSection').style.display = 'none';
            document.getElementById('verifyEmailSection').style.display = 'none';
            document.getElementById('StudentregisterSection').style.display = 'block';

        }



        function showVerifyEmail() {
            document.getElementById("teacherLoginForm").style.display = "none";
            document.getElementById('registerSection').style.display = 'none';
            document.getElementById('verifyEmailSection').style.display = 'block';
        }

        function showStudentVerifyEmail() {
            document.getElementById("studentLoginForm").style.display = "none";
            document.getElementById("StudentregisterSection").style.display = "none";
            document.getElementById("StudentverifyEmailSection").style.display = "block";
            document.getElementById("teacherLoginForm").style.display = "none";
            document.getElementById('registerSection').style.display = 'none';
        }

        function showTeacherLoginForm() {
            document.getElementById("cardContent").style.display = "none";
            document.getElementById("teacherLoginForm").style.display = "block";
            document.getElementById('registerSection').style.display = 'none';
        }

        function showStudentLoginForm() {
            document.getElementById("cardContent").style.display = "none";
            document.getElementById("teacherLoginForm").style.display = "none";
            document.getElementById('registerSection').style.display = 'none';
            document.getElementById("studentLoginForm").style.display = "block";
            document.getElementById('StudentregisterSection').style.display = 'none';
        }

        // Validation for name (full name)
        function validateName(input) {
            var regName = /^[a-zA-Z]+ [a-zA-Z]+$/;
            var name = input.value.trim();
            console.log(name);

            var nameError = input.parentNode.querySelector('.nameError');

            if (!regName.test(name)) {
                nameError.style.display = 'block';
                input.setCustomValidity('Invalid name format. Please enter your full name (first & last name).');
            } else {
                nameError.style.display = 'none';
                input.setCustomValidity('');
            }
        }


        // validation for email
        function validateEmail(emailInput) {
            // Regular expression for email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            var emailError = emailInput.parentNode.querySelector('.emailError');

            if (emailRegex.test(emailInput.value)) {
                // Check if the domain name is present
                var atIndex = emailInput.value.indexOf('@');
                var dotIndex = emailInput.value.lastIndexOf('.');
                if (atIndex != -1 && dotIndex > atIndex) {
                    // Valid email format
                    emailError.style.display = 'none';
                    return true;
                }
            }

            // Invalid email format
            emailError.style.display = 'block';
            return false;
        }

        function validate(num) {
            var theEvent = num || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                var key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
        //ANIMATED PASSWORD VALIDATION 

        var check = function () {
            if (document.getElementById('register-password').value ==
                document.getElementById('confirm-password').value) {
                document.getElementById('Messagei').style.color = 'green';
                document.getElementById('Messagei').innerHTML = 'matching';
            } else {
                document.getElementById('Messagei').style.color = 'red';
                document.getElementById('Messagei').innerHTML = 'not matching';
            }
        }

        var passos = document.getElementsByClassName("passo");

        for (var i = 0; i < passos.length; i++) {
            passos[i].addEventListener("input", function () {
                var myInput = this;
                var message = document.getElementById("message");
                var letter = document.getElementById("letter");
                var capital = document.getElementById("capital");
                var number = document.getElementById("number");
                var length = document.getElementById("length");
                console.log("hello");

                message.style.display = "block";

                // Validate lowercase letters
                var lowerCaseLetters = /[a-z]/g;
                if (myInput.value.match(lowerCaseLetters)) {
                    letter.classList.remove("invalid");
                    letter.classList.add("valid");
                } else {
                    letter.classList.remove("valid");
                    letter.classList.add("invalid");
                }

                // Validate capital letters
                var upperCaseLetters = /[A-Z]/g;
                if (myInput.value.match(upperCaseLetters)) {
                    capital.classList.remove("invalid");
                    capital.classList.add("valid");
                } else {
                    capital.classList.remove("valid");
                    capital.classList.add("invalid");
                }

                // Validate numbers
                var numbers = /[0-9]/g;
                if (myInput.value.match(numbers)) {
                    number.classList.remove("invalid");
                    number.classList.add("valid");
                } else {
                    number.classList.remove("valid");
                    number.classList.add("invalid");
                }

                // Validate length
                if (myInput.value.length >= 8) {
                    length.classList.remove("invalid");
                    length.classList.add("valid");
                } else {
                    length.classList.remove("valid");
                    length.classList.add("invalid");
                }
            });

            passos[i].addEventListener("blur", function () {
                var message = document.getElementById("message");
                message.style.display = "none";
            });
        }

        //AJAX call to check if a email address is already registered in database for student
        $(document).on('focusout', '#register-email', function () {
            var email = $(this).val();
            console.log(email);
            $.ajax({
                type: "POST",
                url: "Student/check_email.php",
                data: {
                    email: email
                },
                success: function (response) {
                    if (response.trim() === 'exists') {
                        $('#emailError1').show();


                    } else {
                        $('#emailError1').hide();
                    }
                }
            });
        });

        // AJAX call to check if a email address is already registered in database for teacher
        $(document).on('focusout', '#register-Temail', function () {
            var email = $(this).val();
            console.log(email);
            $.ajax({
                type: "POST",
                url: "Teacher/check_temail.php",
                data: {
                    email: email
                },
                success: function (response) {
                    if (response.trim() === 'exists') {

                        $('#emailError2').show();
                    } else {
                        $('#emailError2').hide();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    console.error(status);
                    console.error(error);
                }
            });

        });


    </script>


</body>

</html>