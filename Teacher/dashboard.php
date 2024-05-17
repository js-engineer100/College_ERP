<?php
session_start();
require_once "../conn.php";

if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ERP</title>
    <script type="text/javascript">
        document.addEventListener('keypress', function (e) {
            if (e.keyCode === 13 || e.which === 13) {
                e.preventDefault();
                return false;
            }

        });
    </script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <!-- jQuery and jQuery UI -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
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
            width: 100%;
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

        .pagination {
            justify-content: center;
        }
    </style>

</head>

<body style="background-color: cornsilk;">
    <section>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="justify-content: right;">
            <a href="support.php" class="btn btn-success fw-bold"
                style="margin-left: auto;margin-right: 1555px;padding: 10px 15px;gap: 10px;" <b>Support Panel</b></a>
            <a onclick="return confirm('Do you really want to logout?')" href="logout.php"
                class="btn btn-warning pull-right" style="margin-right: 25px; padding:10px 20px; border:none;"><b>Log
                    out!</b></a>


        </nav>
        <h1 style="text-align: center;margin: 60px 0; color:darkblue;"><u><b>STUDENT-RESULT</b></u></h1>
        <div class="container">
            <?php


            if (isset($_SESSION['multideletion-success'])) {
                echo $_SESSION['multideletion-success'];
                unset($_SESSION['multideletion-success']);
            }
            if (isset($_SESSION['singledeletion-success'])) {
                echo $_SESSION['singledeletion-success'];
                unset($_SESSION['singledeletion-success']);
            }
            if (isset($_SESSION['emailss'])) {
                echo $_SESSION['emailss'];
                unset($_SESSION['emailss']);
            }
            if (isset($_SESSION['failed_email'])) {
                echo $_SESSION['failed_email'];
                unset($_SESSION['failed_email']);
            }
            ?>
        </div>
    </section>
    <section style="margin: 30px 0;">
        <div class="container">
            <div class="masterbutton" style="margin: 10px 0; display:flex; gap:10px;">
                <form action="deletealldata.php" method="post" id="deleteForm">

                    <input type="hidden" id="selectedIds" name="checkbox">
                    <button id="deleteALL" type="submit" value="Delete All" name="delete" class="btn btn-danger"
                        style="margin: 0; padding:8px 20px;"
                        onclick="return confirm('Are you sure to delete the selected results?')"><b>Delete
                            All</b></button>

                </form>

                <a href="studentdetails.php" class="btn btn-secondary" style="padding:8px 16px;"><b>Student
                        Details</b></a>
            </div>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Select</th>
                        <th scope="col">S. No.</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Marks/100</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Email</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $loggedInTeacherSubjectID = $_SESSION['loggedInTeacher_SubjectId'];
                    // query to fetch all data from students ,subjects and matks table
                    $sql_query = "SELECT *
                            FROM students
                            INNER JOIN subjects ON students.department_id = subjects.department_id
                            INNER JOIN marks ON students.student_id = marks.student_id AND subjects.subject_id = marks.subject_id
                            WHERE subjects.subject_id = $loggedInTeacherSubjectID";

                    $result = $conn->query($sql_query);

                    if ($result->num_rows > 0) {
                        $sno = 1;
                        while ($row = $result->fetch_assoc()) {
                            $Id = $sno++;
                            $subject = $row['subject_name'];
                            $mark_id = $row['mark_id'];

                            ?>
                            <tr class="trow">
                                <td><input name="checkbox[]" type="checkbox" value="<?php echo $row['mark_id']; ?>"></td>
                                <td><?php echo $Id; ?></td>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['subject_name']; ?></td>
                                <td><?php echo $row['marks_obtained']; ?></td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary open-modal"
                                        data-marks="<?php echo $row['marks_obtained']; ?>"
                                        data-mark-id="<?php echo $row['mark_id']; ?>" style="padding: 8px 20px;">
                                        <b>Edit</b>
                                    </a>
                                </td>
                                <td><a onclick="return confirm('Are you sure to delete this result?')"
                                        href="deletedata.php?id=<?php echo $row['mark_id']; ?>" class="btn btn-danger"
                                        id="delta" style="padding: 8px 16px;"><b>Delete</b></a></td>
                                <td><a onclick="return confirm('Are you sure to email this result?')"
                                        href="emaildata.php?id=<?php echo $row['student_id']; ?>&mark_id=<?php echo $row['mark_id']; ?>"
                                        class="btn btn-success" style="padding: 8px 16px;"><b>Email</b></a></td>

                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="10" style="text-align: center;">Record Not Found.</td></tr>';
                    }
                    ?>


        </div>


    </section>
    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Student Details</h5>
                    <button type="button" id="closer" class="close" data-dismiss="modal" aria-label="Close"
                        style=" border: none;outline: none;background: oldlace;color: orangered;font-size: 25px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="post">
                    <div class="modal-body">

                        <input type="hidden" name="mark_id" id="mark_id" value="">
                        <div class="form-group">
                            <label for="grade">Subject</label>
                            <input type="text" id="name" name="subject_name" class="form-control"
                                value="<?php echo $subject ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="marks">Marks</label>
                            <input type="number" name="marks" id="editMarks" class="form-control" required maxlength="3"
                                oninput="validateMarks(this)">
                            <small id="marksError" style="color: red; display: none;">Marks cannot be more than
                                100</small>
                            <small id="marksError1" style="color: red; display: none;">Marks cannot be less than
                                0</small>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" id="saveChanges" class="btn"
                            style=" background-color: #FDBF60 !important;color: darkblue;padding: 10px 15px;font-weight: 700;border: 1px solid #FDBF60 !important;border-radius: 5px;">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
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
        $(document).ready(function () {


            $('.open-modal').click(function () {

                var marks = $(this).data('marks');
                var markId = $(this).data('mark-id');
                $('input[name="mark_id"]').val(markId);


                $("#student_id").val($(this).attr('value'));

                $('#editMarks').val(marks);
                $('#editModal').modal('show');
                $('#closer').modal('hide');
            });
            $('#saveChanges').click(function () {
                console.log("Save button clicked"); // Check if button click event is triggered
                var marks = $('#editMarks').val();
                var mark_id = $('input[name="mark_id"]').val();
                var student_id = $('#student_id').val();
                $.ajax({
                    url: 'update-results.php',
                    type: 'post',
                    data: {
                        marks: marks,
                        mark_id: mark_id
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log("AJAX success"); // Check if success function is executed
                        console.log(response); // Log the response for troubleshooting
                        if (response.status === true) {
                            alert(response.msg);
                            $('#editModal').modal('hide');
                            window.location.reload(1);
                        } else {
                            alert(response.msg);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", error); // Log any error messages for debugging
                    }
                });
            });
        });

        $('#closer').click(function () {
            $('#editModal').modal('hide');

        });




        document.getElementById("deleteForm").addEventListener("submit", function (event) {
            var all_location_id = document.querySelectorAll('input[name="checkbox[]"]:checked');
            var ds = [];
            for (var x = 0; x < all_location_id.length; x++) {
                ds.push(all_location_id[x].value);
            }
            document.getElementById("selectedIds").value = ds.join(',');
            console.log()
        });

        window.onload = function () {
            sessionStorage.removeItem('remainingTime');
        };


    </script>
</body>

</html>