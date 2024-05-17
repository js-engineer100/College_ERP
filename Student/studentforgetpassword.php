<?php
session_start();

include '../conn.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
} 

if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $new_password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    // Logic to make sure both passwords are same
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match";
    }

    if (!isset($error)) {
        $new_password = mysqli_real_escape_string($conn, $new_password);
        $email = $_SESSION['email'];
        //  update new password n the database
        $sql = "UPDATE students SET password='$hashed_password' WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_affected_rows($conn) > 0) {
                header("Location: ../index.php?reset-password=1");
                exit;
            } else {
                $error = "No rows were affected. Email address not found.";
            }
        } else {
            $error = "Error updating password: " . mysqli_error($conn);
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body,
        html {
            height: 100%;
        }

        .vertical-center {
            min-height: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
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
    <!-- reset password form -->
    <div class="vertical-center">
        <div class="container" style="margin-left:35%;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="color:#333A73;">
                            <strong>Reset your password</strong>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="email" value="<?php echo $email; ?>">
                                <div class="form-group">
                                    <label for="password" style="color:#333A73;">New Password</label>
                                    <input type="password" class="form-control passo" id="password" name="password"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" style="color:#333A73;">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                        name="confirm_password" required onkeyup="check()">
                                    <p id="Messagei"></p>
                                </div>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- password input validation -->
                <div class="col-md-6">
                    <div class="card" style="width: 450px; height:212px; display:none; margin-top:6%;" id="message">
                        <div class="card-body">
                            <h2 style="color:#333A73; font-size:22px; border-radius:5px;  margin-bottom:10px;">
                                <b>Password must contain the following:</b>
                            </h2>
                            <p id="letter" class="invalid" style="margin-left:90px;">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid" style="margin-left:90px;">A <b>capital (uppercase)</b>
                                letter</p>
                            <p id="number" class="invalid" style="margin-left:90px;">A <b>number</b></p>
                            <p id="length" class="invalid" style="margin-left:90px;">Minimum <b>8 characters</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // password validation in the case of forgotten password for student
        var check = function () {
            if (document.getElementById('password').value ==
                document.getElementById('confirm_password').value) {
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


    </script>
</body>

</html>