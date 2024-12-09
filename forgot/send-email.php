<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php"; // Adjust the path as needed if you're not using Composer

$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $_SESSION["email"] = $email;

        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $otp = rand(100000, 999999);
            $_SESSION["otp"] = $otp;

            $query = "UPDATE users SET password_reset_code = '$otp' WHERE email = '$email'";
            mysqli_query($conn, $query);

            // Send OTP to user's email using PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'smtpserver133@gmail.com';                 // SMTP username
                $mail->Password   = 'xwab nztf utfd ggtq';                 // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption
                $mail->Port       = 587;                                    // TCP port to connect to

                // Recipients
                $mail->setFrom('smtpserver133@gmail.com', 'MFA');
                $mail->addAddress($email);     // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'OTP for Password Reset';
                $mail->Body    = 'Your OTP for password reset is: '. $otp;

                $mail->send();
                echo '<script>alert("OTP sent to your email. Please enter the OTP to reset your password."); window.location.href = "send-email.php";</script>';
            } catch (Exception $e) {
                echo '<script>alert("Failed to send OTP. Please try again."); window.location.href = "forgot.php";</script>';
            }
        } else {
            echo '<script>alert("Email not found in database."); window.location.href = "forgot.php";</script>';
        }
    } elseif (isset($_POST["number"])) {
        $email = $_SESSION["email"];
        $otp = $_POST["number"];

        $query = "SELECT password_reset_code FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_otp = $row["password_reset_code"];

            if ($otp == $db_otp) {
                // OTP matches, redirect to reset password page
                header("Location: reset_Pass.php");
                exit;
            } else {
                echo '<script>alert("OTP does not match. Please try again.");</script>';
            }
        } else {
            echo '<script>alert("Email not found in database."); window.location.href = "forgot.php";</script>';
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>BeatsBuddy</title>
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.0.2/tailwind.min.css"
    />
    <link rel="stylesheet" href="send-email.css" />
</head>
<body>
    <ul class="background">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div id="content">
        <div class="main_container">
            <form id="otpForm" method="post" action="send-email.php">
                <h1>Verify OTP</h1>
                <div class="form-group">
                    <label for="otp">Enter OTP Sent to your email</label>
                    <input type="number" id="otp" name="number" required placeholder="123456" autocomplete="off" autofocus />
                    <button type="submit" class="submitbtn">SUBMIT</button>
                </div>
            </form>
            <p id="otpMessage"></p>
        </div>
    </div>
    <script src="forgot.js"></script>
</body>
</html>
