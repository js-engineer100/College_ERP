<?php
session_start();
include "../conn.php";

if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ERP</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-DfXdzADxJm3c6JRZo3KMpvSYOn5IyWy2AUoie5dPiYAoU4ns3jU7qE2+nJH9G8Sr" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <!-- jQuery and jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: oldlace;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 25%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 8px;
            border: none;
            outline: none;
            box-sizing: border-box;
            border-radius: 10px;
            border-color: #FDBF60;

        }

        #adder {
            background-color: #FDBF60;
            color: darkblue;
            padding: 10px 20px;
            border: 1px solid #FDBF60;
            cursor: pointer;
            font-weight: 600;
        }

        #adder:hover {
            background-color: oldlace;

            border: 1px solid darkblue;
        }

        .delete_row:hover {
            background-color: oldlace !important;
            border: 1px solid darkblue !important;

        }

        .upload-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-file-upload {
            border: 2px solid #FDBF60;
            color: #FDBF60;
            background-color: white;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .custom-file-upload:hover {
            background-color: #FDBF60;
            color: white;
        }

        .upload-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #FDBF60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-button:hover {
            background-color: #FFA500;
        }

        /* Assuming you're using Font Awesome for the upload icon */
        .fa-cloud-upload-alt {
            margin-right: 10px;
        }
    </style>
</head>

<body style="background-color: cornsilk;">
    <section>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="justify-content: space-between;">
            <a href="dashboard.php" class="btn btn-success" style="margin-left:17px; padding:10px 15px;"><b>Go
                    Back</b></a>
            <a onclick="return confirm('Do you really want to logout?')" href="logout.php"
                class="btn btn-warning pull-right" style="margin-right: 25px; padding:10px 20px; border:none;"><b>Log
                    out!</b></a>
        </nav>

        <?php if (isset($_SESSION['data_success']) && !empty($_SESSION['data_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="display: flex; justify-content: space-between;">
                <?php echo $_SESSION['data_success']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    style="border: none; outline: none; background: lightblue;">
                    <span aria-hidden="true" style="color: orangered;font-size: 25px;" id="cross">&times;</span>
                </button>
            </div>
            <?php
            // Clear the success message from session once displayed
            unset($_SESSION['data_success']);
        endif;

        if (isset($_SESSION['adderror'])) {
            echo $_SESSION['adderror'];
            unset($_SESSION['adderror']);
        }
        if (isset($_SESSION['csv-success'])) {
            echo $_SESSION['csv-success'];
            unset($_SESSION['csv-success']);
        }
        if (isset($_SESSION['not-allowed'])) {
            echo $_SESSION['not-allowed'];
            unset($_SESSION['not-allowed']);
        }
        if (isset($_SESSION['csv-error'])) {
            echo $_SESSION['csv-error'];
            unset($_SESSION['csv-error']);
        }
        if (isset($_SESSION['error-csvf'])) {
            echo $_SESSION['error-csvf'];
            unset($_SESSION['error-csvf']);
        }
        if (isset($_SESSION['not-allowed'])) {
            echo $_SESSION['not-allowed'];
            unset($_SESSION['not-allowed']);
        }
        if (isset($_SESSION['csv-empty'])) {
            echo $_SESSION['csv-empty'];
            unset($_SESSION['csv-empty']);
        }
        if (isset($_SESSION['csv-error'])) {
            echo $_SESSION['csv-error'];
            unset($_SESSION['csv-error']);
        }
        if (isset($_SESSION['data_error'])) {
            echo $_SESSION['data_error'];
            unset($_SESSION['data_error']);
        }
        ?>

        <h1 style="text-align: center;margin: 60px 0; color:darkblue"><u><b> STUDENT-DETAILS</b></u></h1>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close"
                    style=" margin-left: 396px;color: orangered;font-size: 25px;cursor: pointer;">&times;</span>
                <form id="addResultForm" action="adddata.php" method="post">
                    <input type="hidden" name="student_id" id="student_id">
                    <input type="hidden" name="subject_id" id="subject_id">
                    <div class="form-group">
                        <label for="grade">Subject</label>

                        <?php
                        $loggedInTeacherSubjectID = $_SESSION['loggedInTeacher_SubjectId'];
                        $sql_query = "SELECT * FROM subjects WHERE subject_id = $loggedInTeacherSubjectID";
                        if ($result = $conn->query($sql_query)) {
                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {

                                    $subject = $row['subject_name'];
                                }
                            }
                        }
                        ?>
                        <input type="text" id="name" name="subject_name" class="form-control"
                            value="<?php echo $subject; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="marks">Marks</label>
                        <input type="number" name="marks" id="marks" class="form-control" required maxlength="3"
                            oninput="validateMarks(this)">
                        <small id="marksError" style="color: red; display: none;">Marks cannot be more than 100</small>
                        <small id="marksError1" style="color: red; display: none;">Marks cannot be less than 0</small>
                    </div>

                    <button type="submit" class="btn" id="adder">Add Result</button>
                </form>
            </div>
        </div>

        <div class="container">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                <label for="csv" class="custom-file-upload">
                    <i class="fas fa-cloud-upload-alt"></i> <span id="file-name">Choose CSV File</span>
                </label>
                <input type="file" id="csv" name="csv" accept=".csv" style="display: none;"
                    onchange="updateFileName(this)" />
                <input type="submit" name="submit" value="Upload" class="upload-button" />
            </form>
            <table class="table mx-auto">
                <thead style="color: darkblue; background-color:#FDBF60;">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Action</th>


                    </tr>
                </thead>
                <tbody style="background-color: oldlace;">
                    <?php
                    // sql query to fetch details from the database
                    $sql_query = "SELECT *FROM students
                                  INNER JOIN subjects ON students.department_id = subjects.department_id
                                  WHERE subjects.subject_id = $loggedInTeacherSubjectID";
                    if ($result = $conn->query($sql_query)) {
                        if ($result->num_rows > 0) {
                            $sno = 1;
                            while ($row = $result->fetch_assoc()) {
                                $Id = $sno++;
                                ?>
                                <tr class="trow">
                                    <td>
                                        <?php echo $Id; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['student_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['phone']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['email']; ?>
                                    </td>
                                    <td><button class="btn open-modal" id="adder" data-value1="<?php echo $row['student_id']; ?>"
                                            data-value2="<?php echo $row['subject_id']; ?>">Add Result</button>
                                    </td>

                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="10" style="text-align: center;">Record Not Found.</td></tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        // opening of marks adding modal
        var modal = document.getElementById("myModal");
        var btns = document.querySelectorAll(".open-modal");
        var span = document.getElementsByClassName("close")[0];
        btns.forEach(function (btn) {
            btn.onclick = function () {
                var sid = this.getAttribute('data-value1');

                var subject_id = this.getAttribute('data-value2');
                console.log(subject_id);
                var row = this.parentNode.parentNode;
                var cells = row.getElementsByTagName("td");
                console.log(cells);
                document.getElementById("student_id").value = sid;
                document.getElementById("subject_id").value = subject_id;
                modal.style.display = "block";
            }
        });
        span.onclick = function () {
            modal.style.display = "none";
        }
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        //marks validation function
        function validateMarks(input) {
            var marks = parseInt(input.value);
            var marksError = document.getElementById('marksError');

            if (marks > 100) {
                marksError.style.display = 'block';
                marksError1.style.display = 'none';

                input.value = 100;
            } else if (marks < 0) {
                marksError1.style.display = 'block';
                marksError.style.display = 'none';
                input.value = 0;
            } else {
                marksError.style.display = 'none';
                marksError1.style.display = 'none';
            }
        }


        function updateFileName(input) {
            var fileName = input.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        }


    </script>
</body>

</html>