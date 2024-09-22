<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $reportId = $_POST["reportid"];
    $patient_name = $_POST["patient_name"];

    // You should validate user input here.

    // Connect to the database (replace with your credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Blood_Donation";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $query = "SELECT * FROM reports WHERE report_id = '$reportId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reportText = $row["report_text"];

        // Display the health report on the page
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "    <meta charset='UTF-8'>";
        echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "    <title>Health Reports Page</title>";
        echo "    <link rel='stylesheet' href='Health Reports page style.css'>";
        echo "</head>";
        echo "<body>";
        echo "    <h1>Health Reports</h1>";
        echo "    <div class='report-text'>";
        echo "        <p>Health Report for Report ID: $reportId</p>";
        echo "        <p>$reportText</p>";
        echo "    </div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Health report not found.";
    }

    $conn->close();
}
?>
