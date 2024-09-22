<?php 

session_start(); 

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

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }

    $email = validate($_POST['email']);

    $pass = validate($_POST['password']);

    if (empty($email)) {

        header("Location: Donor login page.php?error=Email is required");

        exit();

    }else if(empty($pass)){

        header("Location: Donor login page.php?error=Password is required");

        exit();

    }else{

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $email && $row['password'] === $pass) {

                echo "Logged in!";

                $_SESSION['email'] = $row['email'];

                $_SESSION['fname'] = $row['fname'];

                $_SESSION['lname'] = $row['lname'];

                $_SESSION['id'] = $row['donor_id'];

                header("Location: donor profile page.php");

                exit();

            }else{

                header("Location: Donor login page.php?error=Incorect User name or password");

                exit();

            }

        }else{

            header("Location: Donor login page.php?error=Incorect User name or password");

            exit();

        }

    }

}else{

    header("Location: Donor login page.php?error=hii");

    exit();

}
// Close the database connection
$conn->close();
?>