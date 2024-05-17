<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once '../conn.php';
// include autoloader
require_once '../dompdf/autoload.inc.php';

// Reference the Dompdf namespace 
use Dompdf\Dompdf;

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
$loggedInUserID = $_SESSION['student_id'];
// Check if the download format is specified
if (isset($_POST['format'])) {
    $format = $_POST['format'];

    // Fetch data from the database
    $sql_query = "SELECT *
              FROM students
              INNER JOIN subjects ON students.department_id = subjects.department_id
              INNER JOIN marks ON students.student_id = marks.student_id AND subjects.subject_id = marks.subject_id
              WHERE students.student_id = $loggedInUserID";
    $result = $conn->query($sql_query);

    $data = array();

    if ($result->num_rows > 0) {
        $sno = 1;
        while ($row = $result->fetch_assoc()) {
            $Id = $sno++;
            $data[] = array(
                $Id,
                $row['student_name'],
                $row['email'],
                $row['phone'],
                $row['subject_name'],
                $row['marks_obtained']
            );
        }
    }

    switch ($format) {
        case 'csv':
            generateCSV($data);
            break;
        case 'pdf':
            generatePDF($data);
            break;
        default:
            // Invalid format
            echo "Invalid download format";
            break;
    }
} else {
    // No format specified
    echo "Download format not specified";
}

// Function to generate CSV file
function generateCSV($data)
{
    $filename = 'result.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no.', 'Name', 'Email', 'Phone', 'Subject', 'Marks Obtained'));
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}


function ImageToDataUrl(string $filename): string
{
    if (!file_exists($filename))
        throw new Exception('File not found.');

    $mime = mime_content_type($filename);
    if ($mime === false)
        throw new Exception('Illegal MIME type.');

    $raw_data = file_get_contents($filename);
    if (empty($raw_data))
        throw new Exception('File not readable or empty.');

    return "data:{$mime};base64," . base64_encode($raw_data);
}

function generatePDF($data)
{

    $html = '<html>
    <title>Student Result</title>
    <head>
    <style>
    body {
        font-family: Arial, sans-serif;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        color: #333;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .logo {
        text-align: center; /* Center align the content */
    }
    .logo img {
        max-width: 200px; /* Limit maximum width */
        height: auto; /* Maintain aspect ratio */
        display: block; /* Ensure image is centered properly */
        margin: 0 auto; /* Center the image horizontally */
    }

    </style>
    </head>
    <body>
    <div class="logo">
    <img src="' . ImageToDataUrl("../logos/Crestmark_st_281Blue_RGB_600.png") . '" alt="berry college logo" >
</div>
    <h1 align="center"><b>Student Result</b></h1>
    <table>
        <tr>
            <th>S.no</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Subject</th>
            <th>Marks Obtained</th>
        </tr>';

    foreach ($data as $row) {
        $html .= '<tr>
            <td>' . $row[0] . '</td>
            <td>' . $row[1] . '</td>
            <td>' . $row[2] . '</td>
            <td>' . $row[3] . '</td>
            <td>' . $row[4] . '</td>
            <td>' . $row[5] . '</td>
        </tr>';
    }

    $html .= '</table>
        </body>
        </html>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("result_" . rand(10, 1000) . ".pdf", array("Attachment" => true));
}
