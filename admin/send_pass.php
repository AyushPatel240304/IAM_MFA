<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

$conn = mysqli_connect("localhost", "root", "", "adm");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function generateRandomPassword($length = 8) {
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $special = '!@#$%^&*()_+';
    
    $allCharacters = $lowercase . $uppercase . $numbers . $special;
    
    $password = '';
    $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
    $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
    $password .= $numbers[rand(0, strlen($numbers) - 1)];
    $password .= $special[rand(0, strlen($special) - 1)];
    
    for ($i = 4; $i < $length; $i++) {
        $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
    }
    
    // Shuffle the password to randomize character positions
    $passwordArray = str_split($password);
    shuffle($passwordArray);
    return implode('', $passwordArray);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $_SESSION["email"] = $email;

        $query = "SELECT email FROM admin WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $new_password = generateRandomPassword();
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $query = "UPDATE admin SET password = '$hashed_password' WHERE email = '$email'";
            mysqli_query($conn, $query);

            // Send new password to user's email using PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'smtpserver133@gmail.com';
                $mail->Password   = 'xwab nztf utfd ggtq';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('smtpserver133@gmail.com', 'Password Reset');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your New Password';
                $mail->Body    = 'Your new password is: ' . $new_password . '. Please change it after logging in.';

                $mail->send();
                echo '<script>alert("New password sent to your email."); window.location.href = "send_pass.php";</script>';
            } catch (Exception $e) {
                echo '<script>alert("Failed to send new password. Please try again."); window.location.href = "admin.php";</script>';
            }
        } else {
            echo '<script>alert("Email not found in database."); window.location.href = "admin.php";</script>';
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>MFA</title>
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.0.2/tailwind.min.css"
    />
    <link rel="stylesheet" href="../forgot/send-email.css" />
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
    </ul>

    <div id="content">
        <div class="main_container">
            <form id="passwordForm" method="post" action="a_dash.php">
                <h1>Verify Password</h1>
                <div class="form-group">
                    <label for="password">Enter Password Sent to Your Email</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Enter your password" 
                        autocomplete="off" 
                        autofocus 
                    />
                    <button type="submit" class="submitbtn">SUBMIT</button>
                </div>
            </form>
            <p id="passwordMessage"></p>
        </div>
    </div>
    <script src="forgot.js"></script>
</body>
</html>
