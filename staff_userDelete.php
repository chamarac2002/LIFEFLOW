<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect to the login page or any other appropriate action
  header("Location: staff login page.php");
  exit;
}

// Set up the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve user information from the session or request parameters
$email = $_SESSION["email"];

// Validate user credentials or conditions, if necessary


// Execute the statement
$stmt->execute();
$stmt->bind_result($imageFilename);
$stmt->fetch();

$stmt->free_result();

// Delete the user's account
$deleteAccountStmt = $conn->prepare("DELETE FROM staff_user WHERE email = ?");
$deleteAccountStmt->bind_param("s", $email);



// Start a transaction for atomicity
$conn->begin_transaction();

// Delete the account and image within the same transaction
if ($deleteAccountStmt->execute()) {
  // Account and image deleted successfully
  // Perform any additional actions or feedback as needed
  $conn->commit();
  session_destroy(); // Destroy the session after deleting the account
  echo "Account deleted successfully.";
  header("Location: staff login page.php");
} else {
  // Error deleting the account or image
  // Perform any error handling or feedback as needed
  $conn->rollback();
  echo "Error deleting account.";
}

// Close the statements
$deleteAccountStmt->close();

// Close the database connection
$conn->close();
?>
