<?php

session_start();
include "../conn.php";
if (!isset($_SESSION['student_loggedin'])) {
  header("location:../index.php");
  exit;
}

$loggedInUserID = $_SESSION['student_id'];

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
    $student_email = $row['email'];


    $data[] = array(
      $Id,
      $row['student_name'],
      $row['email'],
      $row['phone'],
      $row['subject_name'],
      $row['marks_obtained']
    );
  }

  $subject = "Your Result Information";

  // HTML email template content with Berry College logo
  $html_message = '<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Exciting Academic Results Await!</title>
      <style>
      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 600px;
        margin: 20px auto;
        background-color: cornsilk;
        border-radius: 15px;
        border: 2px solid darkblue;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .header img {
        width: 180px;
        height: auto;
        margin-right: 10px;
        vertical-align: middle;
        transition: transform 0.3s ease-in-out;
    }
    .header img:hover {
        transform: scale(1.05);
    }
    .result {
        margin-top: 20px;
        padding: 20px;
        background-color: #ffcccc;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .result p {
        color: #333;
        margin: 5px 0;
        line-height: 1.6;
    }
    .footer {
        margin-top: 30px;
        color: #666;
        text-align: center;
    }
    .footer p {
        margin: 5px 0;
    }
    .footer a {
        color: #ff3333;
        text-decoration: none;
        transition: color 0.3s ease-in-out;
    }
    .footer a:hover {
        color: #e60000;
    }
    .result:hover {
        transform: scale(1.03);
        transition: 0.3s ease-in-out;
    }
    table {
        width: calc(100% - 20px); /* Adjusted width to prevent exceeding container */
        border-collapse: collapse;
        border: 2px solid darkblue; /* Changed border color */
    }
    th, td {
        border: 2px solid darkblue; /* Changed border color */
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
        color: #333;
    }
    
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <img src="https://www.eduopinions.com/wp-content/uploads/2018/09/berry-college-logo2-350x450.png" alt="Berry College Logo">
        </div>
        <h1 style="text-align: center; color: #333; font-size: 28px; margin-bottom: 20px;">Your Result Information!</h1>
        <div class="result">
          <h2 style="text-align: center; color: #333; margin-bottom: 10px;">Academic Results</h2>
          <table>
            <tr>
              <th>S.no</th>
              <th>Name</th>
             
              <th>Subject</th>
              <th>Marks Obtained</th>
            </tr>';

  foreach ($data as $row) {
    $html_message .= '<tr>
              <td>' . $row[0] . '</td>
              <td>' . $row[1] . '</td>
             
              <td>' . $row[4] . '</td>
              <td>' . $row[5] . '</td>
          </tr>';
  }

  $html_message .= '</table>
        </div>
        <div class="footer">
          <p><b>Warm regards from Berry College.....<b></p>
          <p>Adam Smith(Senior Chancellor)</p>
          <p>For any queries regarding result, please contact:</p>
          <p>Email: <a href="mailto:support@berrycollege.edu">support@berrycollege.edu</a></p>
          <p>Phone: <a href="tel:+15551234567">+1 (555) 123-4567</a></p>
        </div>
      </div>
    </body>
    </html>';

  // Set email headers
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= "From: studentresultphp@gmail.com\r\n";
  $headers .= "Reply-To: studentresultphp@gmail.com\r\n";

  // Send email
  if (mail($student_email, $subject, $html_message, $headers)) {
    $_SESSION['emailss'] = "<h3>Email sent successfully!</h3><br>";
    header("location:studentdashboard.php");
  } else {
    $_SESSION['failed_email'] = "<h3>Failed to send email.</h3>";
    header("location:studentdashboard.php");
  }
} else {
  echo "Student not found.";
}

?>