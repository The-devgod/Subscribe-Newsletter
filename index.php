<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/8fe8b7673b.js" crossorigin="anonymous"></script>
</head>
<body>

  <input type="checkbox" id="toggle">
  <label for="toggle" class="show-btn">Show Modal</label>
  <div class="wrapper">
    <label for="toggle">
    <i class="cancel-icon fas fa-times"></i>
    </label>
    <div class="icon">
      <i class="far fa-envelope"></i>
    </div>
    <div class="content">
      <header>Become a Subscriber</header>
      <p>Subscribe to our blog and get the latest updates straight to your inbox.</p>
    </div>

    <form action="index.php" method="POST">

    <?php
$name = "";
//Include Mail Function
require './includes/Mail/index.php';

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "subscriber";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = ""; // First, we leave the email field blank

if (isset($_POST['subscribe'])) { // If subscribe button clicked
    $email = $_POST['email']; // Getting the user-entered email

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email already exists
        $checkStmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // Email already exists, show a message
            ?>
            <div class="alert success-alert">
                <?php echo "You are already subscribed. Thank you!" ?>
            </div>
            <?php
            $email = ""; // Reset the email variable
        } else {
            // Save the email to the database
            $insertStmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
            $insertStmt->bind_param("s", $email);
            $insertStmt->execute();
            $insertStmt->close();

            // Send email
            $subject = "Thanks for Subscribing to us - Thedevgod_";
            $message = "Thanks for subscribing to our blog. You'll always receive updates from us. And we won't share and sell your information.";
            $sender = "From: kingsleychibueze16@gmail.com";

            if (SendMail($email, $subject, $message, $name)) {
                // Show success message once the email is sent successfully
                ?>
                <!-- show success message once email sent successfully -->
                <div class="alert success-alert">
                    <?php echo "Thanks for Subscribing to us." ?>
                </div>
                <?php
                $email = ""; // Reset the email variable
            } else {
                // Show error message if somehow the mail can't be sent
                ?>
                <!-- show error message if somehow mail can't be sent -->
                <div class="alert error-alert">
                    <?php echo "Failed while sending your mail!" ?>
                </div>
                <?php
            }
        }
    } else {
        // Show error message if the user entered email is not valid
        ?>
        <!-- show error message if the user entered email is not valid -->
        <div class="alert error-alert">
            <?php echo "$email is not a valid email address!" ?>
        </div>
        <?php
    }
}
?>
      <div class="field">
        <input type="text" class="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
      </div>
      <div class="field btn">
        <div class="layer"></div>
        <button type="submit" name="subscribe">Subscribe</button>
      </div>
    </form>
    <div class="text">We do not share your information.</div>
  </div>

</body>
</html>
