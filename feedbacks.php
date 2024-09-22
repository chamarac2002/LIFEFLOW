<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION["email"])) {
    // Redirect to the login page or any other appropriate action
    header("Location: Donor login page.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "blood_donation");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the form data
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    // Check if the entry already exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM f_user WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->fetch_row()[0] > 0) {
        echo "Feedback already submitted. Thank you!";
        $checkStmt->close();
        mysqli_close($conn);
        header("Location: donor profile page.php");
        exit;
    }

    $checkStmt->close();

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO f_user (email, feedback) VALUES (?, ?)");
    $stmt->bind_param("sss", $email, $feedback);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Thank you for your feedback!";
        header("Location: donor profile page.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($conn);
}
?>

