<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['teacher_loggedin'])) {
    header("location:../index.php");

}
$loggedInTeacherSubjectID = $_SESSION['loggedInTeacher_SubjectId'];
//query to fetch all details from student,subjects and marks tables
$sql_query = "SELECT *
FROM students
INNER JOIN subjects ON students.department_id = subjects.department_id
INNER JOIN marks ON students.student_id = marks.student_id AND subjects.subject_id = marks.subject_id 
LEFT JOIN ticket ON students.student_id = ticket.student_id AND subjects.subject_id = ticket.subject_id 
WHERE subjects.subject_id = $loggedInTeacherSubjectID AND marks.mark_id=ticket.mark_id
AND (ticket.ticket_status = 'open' OR ticket.ticket_status = 'pending' OR ticket.ticket_status = 'closed');
";


$result = $conn->query($sql_query);
if (!$result) {
    die("Error: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Style the table */
        table {
            border-collapse: collapse;
            width: 100%;
            /* background: linear-gradient(45deg, #efd4d4, #FDBF60); */
        }

        /* Style table header */
        th {
            border: 3px solid orangered;
            text-align: left;
            padding: 8px;
        }

        /* Style table data */
        td {
            border: 2px solid orangered;
            text-align: left;
            padding: 8px;
        }
    </style>

</head>

<body style="background:cornsilk;">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="justify-content: right;">
        <a href="dashboard.php" class="btn btn-success fw-bold"
            style="margin-left: auto;margin-right: 1600px;padding: 10px 15px;gap: 10px;" <b>Go Back</b></a>
        <a onclick="return confirm('Do you really want to logout?')" href="logout.php"
            class="btn btn-warning pull-right" style="margin-right: 25px; padding:10px 20px; border:none;"><b>Log
                out!</b></a>


    </nav>
    <?php if (isset($_SESSION['ticket-close'])) {
        echo $_SESSION['ticket-close'];
        unset($_SESSION['ticket-close']);
    }
    ?>
    <h1 class="font-weight-bold text-center mt-5" style="color:darkblue; display:flex; justify-content:center;">
        <u>SUPPORT-PANEL</u>
    </h1>

    <div style="margin: auto; width: 50%;">
        <h1 style="margin-left:2%; margin-top:10%;"><u>Tickets Raised</u></h1>
        <table class="text-center" style="background-color: #333; color: #fff; border-collapse: collapse; width: 100%;">
            <thead>
                <tr style="color:orangered;">
                    <th style="padding: 10px;">S.No.</th>
                    <th style="padding: 10px;">Student Name</th>
                    <th style="padding: 10px;">Reference ID</th>
                    <th style="padding: 10px;">Subject</th>
                    <th style="padding: 10px;">Marks Obtained</th>
                    <th style="padding: 10px;">Comment</th>
                    <th style="padding: 10px;">Ticket status</th>
                    <th style="padding: 10px;">Raised_on</th>
                    <th style="padding: 10px;">Closed_on</th>
                    <th style="padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        $Id = $sno++;
                        ?>
                        <tr class="trow">
                            <td style="padding: 10px;"><?php echo $Id; ?></td>
                            <td style="padding: 10px;"><?php echo $row['student_name']; ?></td>
                            <td style="padding: 10px;"><?php echo $row['ticket_ref_id']; ?></td>
                            <td style="padding: 10px;"><?php echo $row['subject_name']; ?></td>
                            <td style="padding: 10px;"><?php echo $row['marks_obtained']; ?></td>

                            <td style="padding: 10px;"><?php echo $row['comment']; ?></td>
                            <td style="padding: 10px;"><?php echo $row['ticket_status']; ?></td>
                            <td style="padding: 10px;"><?php echo $row['created_at']; ?></td>
                            <td style="padding: 10px;">
                                <?php echo ($row['closed_at'] !== null) ? $row['closed_at'] : "N/A"; ?>
                            </td>

                            <td style="display: flex; gap: 10px; margin-top: 15px; border: none;">
                                <?php if ($row['ticket_status'] == 'open'): ?>
                                    <a onclick="return confirm('Are you sure to close this ticket?')"
                                        href="status.php?id=<?php echo $row['ticket_id']; ?>&action=close" class="btn btn-danger"
                                        id="close" style="padding: 8px 16px;"><b>Close</b></a>

                                    <a onclick="return confirm('Are you sure to put this ticket on pending?')"
                                        href="status.php?id=<?php echo $row['ticket_id']; ?>&action=pending" class="btn btn-warning"
                                        id="pending" style="padding: 8px 16px;"><b>Pending</b></a>
                                <?php elseif ($row['ticket_status'] == 'pending'): ?>
                                    <a onclick="return confirm('Are you sure to close this ticket?')"
                                        href="status.php?id=<?php echo $row['ticket_id']; ?>&action=close" class="btn btn-danger"
                                        id="close" style="padding: 8px 16px;"><b>Close</b></a>
                                <?php else: ?>
                                    <p>Not Allowed..</p>
                                <?php endif; ?>
                            </td>



                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='10'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>


</html>