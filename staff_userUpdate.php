<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: staff login page.php");
    exit;
}

$fname = $lname = $gender = $address = $weight = $nic = $phoneNumber = $email = $position = $dob = $password = "";
$fnameErr = $lnameErr = $genderErr = $addressErr = $weightErr = $nicErr = $phoneNumberErr = $emailErr = $positionErr = $dobErr = $passwordErr = "";

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "blood_donation";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Retrieve the user data from the database
$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, retrieve the data
    $row = $result->fetch_assoc();
    $fname = $row["fname"];
    $lname = $row["lname"];
    $did = $row["staff_id"];
    $phoneNumber = $row["pnumber"];
    $email = $row["email"];
    $gender = $row["gender"];
    $address = $row["address"];
    $weight = $row["weight"];
    $nic = $row["nic"];
    $position = $row["position"];
    $dob = $row["dob"];
    $password = $row["password"];
} else {
    echo "User not found.";
    exit;
}

// Update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $fname = validate($_POST["fname"]);
    $lname = validate($_POST["lname"]);
    $gender = validate($_POST["gender"]);
    $nic = validate($_POST["nic"]);
    $phoneNumber = validate($_POST["phoneNumber"]);
    $email = validate($_POST["email"]);
    $address = validate($_POST["address"]);
    $weight = validate($_POST["weight"]);
    $position = validate($_POST["position"]);
    $dob = validate($_POST["dob"]);
    $password = validate($_POST["password"]);

    // Validate phone number length
    if (strlen($phoneNumber) !== 10) {
        $phoneNumberErr = "Phone number should be exactly 10 digits.";
    }

    // Validate the NIC
    if (!preg_match("/^[0-9]{12}$/", $nic)) {
        $nicErr = "NIC should be a 12-digit number";
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required";
    } elseif (strlen($password) < 6) {
        $passwordErr = "Password should be at least 6 characters long";
    } elseif (preg_match_all("/[0-9]/", $password) < 2) {
        $passwordErr = "Password should contain at least 2 numbers";
    }

    // Prepare and execute the SQL update query if there are no errors
    if (empty($fnameErr) && empty($lnameErr) && empty($phoneNumberErr) && empty($nicErr) && empty($passwordErr)) {
        $updateQuery = "UPDATE users SET fname = ?, lname = ?, gender = ?, nic = ?, pnumber = ?, email = ?, address = ?, weight = ?, position = ?, dob = ?, password = ? WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssssssssss", $fname, $lname, $gender, $nic, $phoneNumber, $email, $address, $weight, $position, $dob, $password, $email);
        if ($stmt->execute()) {
            // Redirect to the profile page or any other appropriate action
            header("Location: staff profile page.php");
            exit;
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }
}

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
        <a href="staff registration.php">Staff REG</a>
        <span></span>
    </nav>

<hr class="topic_line">

<h1 class="dp"> staff Profile Update </h1>

<div class="qs"> 
    <form method="post" action="">   
        <p>First Name :</p>
        <input type="text" class="name" name="fname" value="<?php echo $fname; ?>" placeholder="First name">

        <p>Last Name :</p>
        <input type="text" class="" name="lname" value="<?php echo $lname; ?>" placeholder="Last name">

        <p>Gender :</p>
        <input type="text" class="gender" name="gender" value="<?php echo $gender; ?>" placeholder="Gender">

        <p>Date Of Birth :</p>
        <input type="text" class="dob" name="dob" value="<?php echo $dob; ?>" placeholder="Date Of Birth">

        <p>NIC Number :</p>
        <input type="text" class="nic" name="nic" value="<?php echo $nic; ?>" placeholder="NIC">

        <p>Weight :</p>
        <input type="text" class="weight" name="weight" value="<?php echo $weight; ?>" placeholder="Weight">

        <p>Position :</p>
        <input type="text" class="position" name="position" value="<?php echo $position; ?>" placeholder="Position">

        <p>Address :</p>
        <input type="text" class="address" name="address" value="<?php echo $address; ?>" placeholder="Address">

        <p>Contact Number :</p>
        <input type="text" class="pnumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>" placeholder="Contact Number">

        <p>E-mail :</p>
        <input type="text" class="email" name="email" value="<?php echo $email; ?>" placeholder="E-mail">

        <p>Password :</p>
        <input type="text" class="password" name="password" value="<?php echo $password; ?>" placeholder="Password"><br><br>

        <input type="submit" value="Update">
    </form>
</div>

<img src="images/prfile.png" class="profile_image">

<div class="buttons">

    <a href="put a link" target="_blank">
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