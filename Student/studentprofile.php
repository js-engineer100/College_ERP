<?php
session_start();
include "../conn.php";

if (!isset($_SESSION['student_loggedin'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentProfile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 500px;
            margin: 160px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        .container {
            background: linear-gradient(45deg, #efd4d4, #FDBF60);
        }
    </style>
</head>

<body style="background-color: cornsilk;">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="justify-content: space-between;">
        <a href="studentdashboard.php" class="btn btn-success" style="margin-left:17px; padding:10px 15px;"><b>Go
                Back</b></a>
        <a onclick="return confirm('Do you really want to logout?')" href="student_logout.php"
            class="btn btn-warning pull-right" style="margin-right: 25px; padding:10px 20px; border:none;"><b>Log
                out!</b></a>
    </nav>

    <?php

    if (isset($_SESSION['psuccess'])) {
        echo $_SESSION['psuccess'];
        unset($_SESSION['psuccess']);
    }
    if (isset($_SESSION['empty_email'])) {
        echo $_SESSION['empty_email'];
        unset($_SESSION['empty_email']);
    }
    if (isset($_SESSION['empty_phone'])) {
        echo $_SESSION['empty_phone'];
        unset($_SESSION['empty_phone']);
    }

    $loggedInUserID = $_SESSION['student_id'];
    // sql query to fetch student data from the student table
    $sql_query = "SELECT * FROM students WHERE student_id = $loggedInUserID";
    $result = mysqli_query($conn, $sql_query);
    if ($result) {

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $Id = $row['student_id'];

                $Name = $row['student_name'];
                $Phone = $row['phone'];
                $Email = $row['email'];
            }
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>

    <div class="container" style="margin-top:175px;">
        <div class="row justify-content-center">

            <div class="detailer" style="width: 354px;">
                <!-- student profile card -->

                <div class="text-center">
                    <h3 style="color: darkblue; margin-bottom:40px;"> <b><U>STUDENT-PROFILE</U></b></h3>
                </div>
                <form action="studentupdatedetails.php" method="post">
                    <input type='hidden' name='student_id' id='id' value="<?php echo $Id ?>" />
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $Name ?>"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $Phone ?>"
                            maxlength="10" onkeypress='validate(event)' onpaste='validate(event)'>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $Email ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Save</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // js function to make sure that the student only enter the numbers not the alphabet
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
    </script>

</body>

</html>