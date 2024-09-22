<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["email"])) {
    // Redirect to the login page or any other appropriate action
    header("Location: staff login page.php");
    exit;
}

// Get the user details from the session or database
$email = $_SESSION["email"];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement to fetch user details based on the email
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows == 1) {
    // User exists, fetch the details
    $row = $result->fetch_assoc();

    $fname = $row["fname"];
    $lname = $row["lname"];
    $did = $row["donor_id"];
    $pn = $row["pnumber"];
    $email = $row["email"];
    $gender = $row["gender"];
    $address = $row["address"];
    $weight = $row["weight"];
    $nic = $row["nic"];
    $bloodgroup = $row["bloodgroup"];
    $dob = $row["dob"];
    

} else {
    // User not found, handle accordingly
    // Redirect, display an error message, or take any other appropriate action
    header("Location: staff login page.php");
    exit;
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Donar Profile Page</title>

    <link rel="stylesheet" href="donor profile page styles.css">
</head>

<body>

<img src="images/logo.png" class="logo" >

    <h1 class="logo_topic">LIFEFLOW</h1>
    <h2 class="logo_sub_topic">Blood Donation System</h2>

    <nav class="navbar">
        <a href="home page.html">Home</a>
        <a href="about us page.html">About Us</a>
        <a href="donor home page.html">Donor</a>
        <a href="donation procedure.html">Donations</a>
        <a href="login page.php">Login</a>
        <a href="FAQs page.html">FAQs</a>
        <span></span>
    </nav>

<hr class="topic_line">

<h1 class="dp"> Donor Profile </h1>

<div class="qs">    
    <p>First Name :</p>
    <input type="text" class="name" value="<?php echo $fname; ?>" placeholder="First name">

    <p>Last Name :</p>
    <input type="text" class="" value="<?php echo $lname; ?>" placeholder="Last name">

    <p>Gender :</p>
    <input type="text" class="gender" value="<?php echo $gender; ?>" placeholder="Gender">

    <p>Date Of Birth :</p>
    <input type="text" class="dob" value="<?php echo $dob; ?>" placeholder="Date Of Birth">

    <p>NIC Number :</p>
    <input type="text" class="nic" value="<?php echo $nic; ?>" placeholder="NIC">

    <p>Weight :</p>
    <input type="text" class="weight" value="<?php echo $weight; ?>" placeholder="Weight">

    <p>Blood Group :</p>
    <input type="text" class="bloodgroup" value="<?php echo $bloodgroup; ?>" placeholder="Blood group">

    <p>Address :</p>
    <input type="text" class="address" value="<?php echo $address; ?>" placeholder="Address">

    <p>Contact Number :</p>
    <input type="text" class="pnumber" value="<?php echo $pn; ?>" placeholder="Contact Number">

    <p>E-mail :</p>
    <input type="text" class="email" value="<?php echo $email; ?>" placeholder="E-mail">

</div>

<img src="images/prfile.png" class="profile_image">

<div class="buttons">
    <a href="staff_userUpdate.php">
        <button type="button" class="edit_profile">Edit Profile</button>
        </a>

    <a href="staff_userDelete.php">
        <button type="button" class="edit_profile">Delete profile</button>
        </a>
    
    <a href="staff logout.php">
        <button type="button" class="logout">Logout</button>
        </a>
</div>











<hr class="footer_line">

<div class="footer">
    <a href="https://www.who.int/" target="_blank">
    <button type="button" class="help_button">Help and Support</button>
    </a>

    <div class="fb_icon">
        <a href="https://www.facebook.com/" target="_blank"><img src="images/facebook.png"></a>
    </div>

    <div class="insta_icon">
        <a href="https://www.instagram.com/" target="_blank"><img src="images/insta.png"></a>
    </div>

    <div class="twitt_icon">
        <a href="https://www.twitter.com/" target="_blank"><img src="images/Twitter.png"></a>
    </div>

    <div class="yt_icon">
        <a href="https://www.youtube.com/watch?v=ku0zMBVjjAs" target="_blank"><img src="images/yt.png"></a>
    </div>
</div>

<div class="contacts">
    <h1 class="Genaral">Genaral: +94225 225 25</h1>
    <h1 class="Donor_section">Donor Section: +94522 522 52</h1>
</div>

</body>
</html>