<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name_with_initials = $_POST["name_with_initials"];
    $donor_id = $_POST["donor_id"];
    $phone_number = $_POST["phone_number"];
    $donation_date = $_POST["donation_date"];
    $center = $_POST["center"];

    // Connect to your database (replace with your credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Blood_Donation";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the appointment data into the database (you should add proper error handling)
    $sql = "INSERT INTO appointments (name_with_initials, donor_id, phone_number, donation_date, center) VALUES ('$name_with_initials', '$donor_id', '$phone_number', '$donation_date', '$center')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Appointment reserved successfully!");</script>';
}
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

?>
