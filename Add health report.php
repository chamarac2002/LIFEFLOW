<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $report_id = $_POST["report_id"];
    $patient_name = $_POST["patient_name"];
    $report_text = $_POST["report_text"];
    $report_date = $_POST["report_date"];

    // Connect to the database     
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Blood_Donation";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the health report into the database
    $sql = "INSERT INTO reports (report_id,patient_name, report_text, report_date) VALUES ('$report_id','$patient_name', '$report_text', '$report_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Health report added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Health Report</title>
</head>
<body>
    <h1>Add Health Report</h1>
    <form action="Add health report.php" method="post">
        <label for="report_id">Report ID:</label>
        <input type="text" name="report_id" required><br><br>

        <label for="patient_name">Patient Name:</label>
        <input type="text" name="patient_name" required><br><br>

        <label for="report_text">Report Text:</label>
        <textarea name="report_text" rows="5" required></textarea><br><br>

        <label for="report_date">Report Date:</label>
        <input type="date" name="report_date" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
