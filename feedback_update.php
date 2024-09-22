<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "blood_donation");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $feedback_id = $_POST['feedback_id'];
    $new_feedback = $_POST['new_feedback'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE f_user SET feedback = ? WHERE id = ?");
    $stmt->bind_param("si", $new_feedback, $feedback_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Feedback updated successfully!";
        header("Location: feedback.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($conn);
}
?>