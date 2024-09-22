<?php
// Define variables and initialize with empty values
$fname = $lname = $gender = $address = $weight = $nic = $phoneNumber = $email = $position = $dob = $password = $confirmPassword = "";
$fnameErr = $lnameErr = $genderErr = $addressErr = $weightErr = $nicErr = $phoneNumberErr = $emailErr = $positionErr = $dobErr = $passwordErr = $confirmPasswordErr = "";
$registrationSuccess = false;

// Check if the form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Retrieve and validate form data
    if (empty($_POST["fname"])) 
    {
        $fnameErr = "First name is required";
    } 
    else 
    {
        $fname = $_POST["fname"];
    }


    if (empty($_POST["lname"])) 
    {
        $lnameErr = "Last name is required";
    } 
    else 
    {
        $lname = $_POST["lname"];
    }


    if (empty($_POST["gender"])) 
    {
        $genderErr = "Gender is required";
    } 
    else 
    {
        $gender = $_POST["gender"];
    }


    if (empty($_POST["nic"])) 
    {
        $nicErr = "National Identity Number is required";
    } 
    else 
    {
        $nic = $_POST["nic"];
    }


    if (empty($_POST["pnumber"])) 
    {
        $phoneNumberErr = "Phone Number is required";
    } 
    else 
    {
        $phoneNumber = $_POST["pnumber"];
    }


    if (empty($_POST["email"])) 
    {
        $emailErr = "Email is required";
    } 
    else 
    {
        $email = $_POST["email"];
    }


    if (empty($_POST["address"])) 
    {
        $addressErr = "Address is required";
    } 
    else 
    {
        $address = $_POST["address"];
    }


    if (empty($_POST["weight"])) 
    {
        $weightErr = "Weight is required";
    } 
    else 
    {
        $weight = $_POST["weight"];
    }


    if (empty($_POST["position"])) 
    {
        $positionErr = "Position is required";
    } 
    else 
    {
        $position = $_POST["position"];
    }


    if (empty($_POST["dob"])) 
    {
        $dobErr = "Date of Birth is required";
    } 
    else 
    {
        $dob = $_POST["dob"];


        // Convert the date of birth to a timestamp
        $dobTimestamp = strtotime($dob);


        // Get the current timestamp
        $currentTimestamp = time();


        // Calculate the minimum and maximum timestamps based on the age range
        $minTimestamp = strtotime('-85 years', $currentTimestamp);
        $maxTimestamp = strtotime('-15 years', $currentTimestamp);


        // Check if the date of birth is within the allowed range
        if ($dobTimestamp < $minTimestamp || $dobTimestamp > $maxTimestamp) 
        {
            $dobErr = "Date of Birth should be between 15 and 85 years";
        }
    }


  if (empty($_POST["password"])) 
  {
    $passwordErr = "Password is required";
  } 
  else 
  {
    $password = $_POST["password"];
    

    // Validate password length
    if (strlen($password) < 6) 
    {
        $passwordErr = "Password should be at least 6 characters long";
    }


    // Validate password for at least 2 numbers
    $numCount = preg_match_all("/[0-9]/", $password);
    if ($numCount < 2) 
    {
        $passwordErr = "Password should contain at least 2 numbers";
    }
}


   if (empty($_POST["confirmpassword"])) 
    {
        $confirmPasswordErr = "Confirm Password is required";
    } 
    else 
    {
        $confirmPassword = $_POST["confirmpassword"];
    }

    // Check if the password and confirm password match
    if ($password !== $confirmPassword) 
    {
        $confirmPasswordErr = "Password and Confirm Password do not match";
    }



    // Validate the phone number
    if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) 
    {
        $phoneNumberErr = "Phone Number should be a 10-digit number";
    }


    // Validate the NIC
    if (!preg_match("/^[0-9]{12}$/", $nic)) 
    {
        $nicErr = "NIC should be a 12-digit number";
    }


    // If all input fields are valid, proceed with registration

    if (empty($fnameErr) && empty($lnameErr) && empty($genderErr) && empty($nicErr) && empty($phoneNumberErr) && empty($emailErr) && empty($dobErr) && empty($addressErr) && empty($weightErr) && empty($positionErr) && empty($passwordErr) && empty($confirmPasswordErr)) 
    {
        // Connect to the database and perform the registration process
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $database = "blood_donation";

        // Create a new connection

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

        // Check connection

        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the email already exists in the table

        $stmt = $conn->prepare("SELECT email FROM staff_user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) 
        {
            $emailErr = "Email already exists";
        }

        // Check if the NIC already exists in the table

        $stmt = $conn->prepare("SELECT nic FROM staff_user WHERE nic = ?");
        $stmt->bind_param("s", $nic);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) 
        {
            $nicErr = "NIC already exists";
        }

        // If there are no errors, proceed with inserting the user data

        if (empty($emailErr) && empty($nicErr) && empty($usernameErr)) 
        {
            // Prepare and execute the SQL statement to insert the user data into the table
            $stmt = $conn->prepare("INSERT INTO staff_user (fname, lname, gender, dob, nic, address, weight, position, pnumber, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $fname, $lname, $gender, $dob, $nic, $address, $weight, $position, $phoneNumber, $email, $password);


            if ($stmt->execute()) 
            {
                $registrationSuccess = true;
            }
        }

        // Close the prepared statements
        $stmt->close();

        // Close the database connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>

    <link rel="stylesheet" href="staff_registration_styles.css">
</head>
<body>
    <img src="images\logo.png" class="logo" >
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
<h1 class="topic">Staff Registration</h1>

<form method="post" action="staff registration.php">
    <div class="split_left">
        <div class="left centerd">

            <p>First Name</p>
            <input type="text" placeholder="first name" name="fname"><span class="error"><?php echo $fnameErr; ?></span>
            
            <p>Gender</p>
            <input type="radio" name="gender" value="male">
                <label for="html">Male</label>
                <input type="radio" name="gender" value="female">
            <label for="html">Female</label>
            <span class="error"><?php echo $genderErr; ?></span>

                <p>NIC Number</p>
            <input type="text" placeholder="nic number" name="nic">
            <span class="error"><?php echo $nicErr; ?></span>

            <p>Weight</p>
            <input type="text" placeholder="50kg to -" name="weight">
            <span class="error"><?php echo $weightErr; ?></span>

            <p>Contact Number</p>
            <input type="text" placeholder="must be 10 characters" name="pnumber">
            <span class="error"><?php echo $phoneNumberErr; ?></span>

            <p>Password</p>
            <input type="text" placeholder="lettes,numbers,symbols" name="password">
            <span class="error"><?php echo $passwordErr; ?></span>
        </div>
    </div>

    <div class="split_right">    
        <div class="right centerd">
            <p>Last Name</p>
            <input type="text" placeholder="last name" name="lname">
            <span class="error"><?php echo $lnameErr; ?></span>

            <p>Date Of Birth</p>
            <input type="text" placeholder="DD/MM/YY" name="dob">
            <span class="error"><?php echo $dobErr; ?></span>

            <p>Address</p>
            <input type="text" placeholder="address" name="address">
            <span class="error"><?php echo $addressErr; ?></span>

            <p>Position</p>
            <input type="text" placeholder="enter the position" name="position">
            <span class="error"><?php echo $positionErr; ?></span>

            <p>E-mail</p>
            <input type="text" placeholder="email@gmail.com" name="email">
            <span class="error"><?php echo $emailErr; ?></span>

            <p>Confirm Password</p>
            <input type="text" placeholder="confirm password" name="confirmpassword">
            <span class="error"><?php echo $confirmPasswordErr; ?></span>

        </div>
    </div>    

    <input type="submit" id="submit_button" value="SUBMIT">
    <!-- <script>
        function showMessage () {
            alert("Submitted Successfully !");
        }

        document.getElementById
        ("submit_button").
        addEventListener("click",showMessage);
    </script>
 -->
</form>

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