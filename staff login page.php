<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eligibility Test Page</title>

    <link rel="stylesheet" href="staff login page style.css">
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

<section>
    <center>
    <div class="form-box">
        <div class="form value">
            <form action="staff_loginProcess.php" method="post">
                <?php if (isset($_GET['error'])) { ?>

            <p class="error">
                <?php echo $_GET['error']; ?></p>

                <?php } ?>
                <h1 class = header>Staff Loging</h1>
                
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" id="email" name="email" required>
                    <label for="email">  Email</label>

                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
        
                <button class="si" type="submit">Sign in</button>

            </form>
        </div>

    </div>
   </center>
    
</section>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

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