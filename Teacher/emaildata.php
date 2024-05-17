<?php

session_start();
if (!isset($_SESSION['teacher_loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once "../conn.php";

if (isset($_GET['id']) && isset($_GET['mark_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['id']);
    $mark_id = mysqli_real_escape_string($conn, $_GET['mark_id']);

    $sql_query = "SELECT students.*, subjects.subject_name, marks.marks_obtained
    FROM students
    JOIN marks ON students.student_id = marks.student_id
    JOIN subjects ON marks.subject_id = subjects.subject_id
    WHERE students.student_id = '$student_id' AND marks.mark_id = '$mark_id';";

    $result = $conn->query($sql_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['student_name'];
        $subjectName = $row['subject_name'];
        $marks = $row['marks_obtained'];
        $email = $row['email'];

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
              background-color: cornsilk !important;
              max-width: 600px;
              margin: 20px auto;
              background-color: #ffffff;
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
              transition: color 0.3s ease-in-out important;
            }
            .footer a:hover {
              color: #e60000;
            }
            .result:hover {
              transform: scale(1.03);
              transition: 0.3s ease-in-out;
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
              <p><strong>Name:</strong> ' . $name . '</p>
              <p><strong>Subject:</strong> ' . $subjectName . '</p>
              <p><strong>Marks:</strong> ' . $marks . '%</p>
            </div>
            <div class="footer" style="margin-top: 5em; justify-content: left; display: flex; flex-direction: column;">
              <p style="color: black;"><b>Warm regards from Berry College.....<b></p>
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
        if (mail($email, $subject, $html_message, $headers)) {
            $_SESSION['emailss'] = "<h3>Email sent successfully!</h3><br>";
            header("location:dashboard.php");
        } else {
            $_SESSION['failed_email'] = "<h3>Failed to send email.</h3>";
            header("location:dashboard.php");
        }
    } else {
        echo "Student not found.";
    }
} else {
    echo "Student ID not provided.";
}
?>


