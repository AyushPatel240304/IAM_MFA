<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $email = $_SESSION["email"];

    if ($new_password === $confirm_password) {
        // Hash the new password before storing it
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Password has been changed successfully."); window.location.href = "../user/login.php";</script>';
        } else {
            echo '<script>alert("Error updating password. Please try again."); window.location.href = "reset_Pass.php";</script>';
        }
    } else {
        echo '<script>alert("Passwords do not match. Please try again."); window.location.href = "reset_Pass.php";</script>';
    }
}

mysqli_close($conn);
?>


<html>
    <head>
        <title>BeatsBuddy</title>
    </head>
    <link rel="stylesheet" href="reset_pass.css">
    <body>


    <div class="container">
  <input type="checkbox" id="register_toggle">
  <div class="slider">
  <form class="form" id="resetForm" method="post" action="reset_Pass.php">
                <span class="title">Change Password</span>
                <div class="form_control">
                    <input type="password" class="input" name="new_password" required="">
                    <label class="label">Password</label>
                </div>
                <div class="form_control">
                    <input type="password" class="input" name="confirm_password" required="">
                    <label class="label">Confirm Password</label>
                </div>
                <button type="submit">Submit</button>
            </form>
    </div>
    </div>
    </body>
</html>