<?php
session_start();
include "../conn.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");


// if student is not logged in throw him out
if (!isset($_SESSION['student_loggedin'])) {

    header("Location: ../index.php");
    exit();
}
$loggedInUserID = $_SESSION['student_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ERP</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <!-- jQuery and jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: cornsilk;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 160px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .container {
            background: linear-gradient(45deg, #efd4d4, #FDBF60);
        }

        .modal-content {
            background: linear-gradient(45deg, #efd4d4, #FDBF60);
        }




        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        h1 {
            text-align: center;
            /* margin: 60px 0; */
            color: darkblue;
        }



        /* Styles for the revaluation modal */
        .modal.revaluation-modal .modal-content {
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
        }

        .modal.revaluation-modal .modal-content h5.modal-title {
            color: darkblue;
            text-align: center;
            margin-bottom: 20px;
        }

        .modal.revaluation-modal .modal-content .form-group label {
            font-weight: bold;
        }

        .modal.revaluation-modal .modal-content .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .modal.revaluation-modal .modal-content button[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal.revaluation-modal .modal-content button[type="submit"]:hover {
            background-color: #218838;
        }

        /* Styles for the download modal */
        .modal.download-modal .modal {
            display: none;
            /* Hide modal by default */
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5) !important;
            /* Faded background */
        }

        .modal.download-modal .modal-content {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            margin: 16% auto;
            /* Center modal vertically and horizontally */
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal.download-modal .modal-content h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .modal.download-modal .modal-content button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 30px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal.download-modal .modal-content button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <section>
        <!-- Nvigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="justify-content: space-between;">
            <a href="studentprofile.php" class="btn btn-primary" style="margin-left:20px; padding:10px 15px"><b>Student
                    Profile</b></a>
            <a href="support_ticket.php" class="btn btn-success fw-bold"
                style="margin-left: auto;margin-right: 42px;padding: 10px 15px;gap: 10px;" <b>View Tickets</b></a>
            <a onclick="return confirm('Do you really want to logout?')" href="student_logout.php"
                class="btn btn-warning pull-right" style="margin-right: 25px; padding:10px 20px; border:none;"><b>Log
                    out!</b></a>

        </nav>
        <?php
        if (isset($_SESSION['emailss'])) {
            echo $_SESSION['emailss'];
            unset($_SESSION['emailss']);
        }
        if (isset($_SESSION['failed_email'])) {
            echo $_SESSION['failed_email'];
            unset($_SESSION['failed_email']);
        } ?>


        <h1 style="margin-top:80px;"><u><b>STUDENT-DASHBOARD</b></u></h1>

        </div>
        <div class="container">

            <!-- Student Result Table -->
            <h1>Student Result</h1>
            <div class="actionbtnr" style="display:flex; gap:12px;">
                <form id="downloadForm" action="download.php" method="POST">
                    <!-- Hidden input field to store the selected format -->
                    <input type="hidden" id="downloadFormat" name="format" value="">
                    <button type="button" class="btn btn-primary" onclick="openModal()"><b>Download Result</b></button>
                </form>
                <form action="emailer.php" method="POST">
                    <button type="submit" class="btn btn-primary"><b>Get Email</b></button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Subjects</th>
                        <th>Marks_obtained / 100</th>
                        <th>Action</th>

                    </tr>

                </thead>
                <tbody>
                    <?php



                    $sql_query = "SELECT *
                     FROM students
                     INNER JOIN subjects ON students.department_id = subjects.department_id
                     INNER JOIN marks ON students.student_id = marks.student_id AND subjects.subject_id = marks.subject_id
                     WHERE students.student_id = $loggedInUserID";

                    $result = $conn->query($sql_query);

                    if ($result->num_rows > 0) {
                        $sno = 1;
                        while ($row = $result->fetch_assoc()) {
                            $Id = $sno++;
                            $listno = $row['student_id'];
                            ?>
                            <tr class="trow">
                                <td><?php echo $Id; ?></td>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['subject_name']; ?></td>
                                <td><?php echo $row['marks_obtained']; ?></td>
                                <td>
                                    <button type="button" class="revaluationBtn btn btn-primary"
                                        data-subject-id="<?php echo $row['subject_id']; ?>"
                                        data-mark-id="<?php echo $row['mark_id']; ?>"><b>Revaluation</b></button>

                                </td>
                            <?php }
                    }

                    ?>
                </tbody>
        </div>
        </div>
        <!-- download modal -->
        <div id="myModal" class="modal download-modal">
            <!-- Modal content -->


            <div class="modal-content">
                <span class="close" onclick="closeModal()" style="
    color: orangered;
    font-size: 20px;
    font-weight: 900;
    cursor: pointer;
">&times;</span>
                <h2>Select Download Format</h2>
                <button onclick="setFormat('csv')" onblur="closeModal()">Download as CSV</button>
                <button onclick="setFormat('pdf')" onblur="closeModal()">Download as PDF</button>
            </div>
        </div>



        <!-- Revaluation Modal -->
        <div class="modal fade revaluation-modal" id="revaluationModal" tabindex="-1"
            aria-labelledby="revaluationModalLabel" aria-hidden="true">
            <!-- Modal content -->


            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="revaluationModalLabel" style="color:darkblue;">
                            Revaluation Ticket
                            Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closerbbb"
                            style="color:orangered;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="revaluationForm" method="post">
                            <div class="form-group">
                                <label for="ticketRefId"><b>Ticket Reference ID:</b></label>
                                <input type="text" class="form-control" id="ticketRefId" readonly
                                    style="background:white;">
                            </div>
                            <div class="form-group">
                                <label for="comment"><b>Comment:</b></label>
                                <textarea class="form-control" id="comment" name="comment"></textarea>
                            </div>

                            <input type="hidden" name="subject_id" value="">
                            <input type="hidden" name="student_id" value="<?php echo $listno ?>">
                            <input type="hidden" name="mark_id" value="">
                            <p style="margin-top:15px;"><b>if you want to have a recheck on your answersheet, click on
                                    the submit button, And raise this ticket...</b></p>
                            <!-- Other ticket details input fields -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>

        </script>


    </section>

    <script>
        // AJAX call for submitting support ticket request
        $(document).ready(function () {
            $('.revaluationBtn').click(function () {
                var subjectId = $(this).data('subject-id');
                var markId = $(this).data('mark-id');
                $('input[name="subject_id"]').val(subjectId);
                $('input[name="mark_id"]').val(markId);

                // Generate random reference ID (example)
                var ticketRefId = Math.random().toString(36).substring(7);
                $('#ticketRefId').val(ticketRefId);
                $('<input>').attr({
                    type: 'hidden',
                    name: 'ticketRefId',
                    value: ticketRefId
                }).appendTo('#revaluationForm');


                $('#revaluationModal').modal('show');
            });

            // Handle form submission
            $('#revaluationForm').submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                console.log(formData);

                $.ajax({
                    url: 'submit_ticket.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // alert(response);
                        if (response == 200) {
                            alert('Ticket submitted successfully!');
                            $('#revaluationModal').modal('hide');

                        } else {
                            alert('error');
                        }

                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });

            });
        });
        $('#closerbbb').click(function () {
            $('#revaluationModal').modal('hide');

        });

        //    code to  remove timer from session storage or clear the session storage
        window.onload = function () {
            sessionStorage.removeItem('remainingTime');
        };
        function openModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        function setFormat(format) {
            // Set the value of the hidden input field to the selected format
            document.getElementById('downloadFormat').value = format;

            // Submit the form
            document.getElementById('downloadForm').submit();
        }


    </script>

</body>

</html>