<?php
session_start();

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validation
        $errors = [];

        if (empty($name)) {
            $errors[] = "Name is required";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) ||!preg_match("/@(gmail|yahoo|outlook)\.com$/", $email)) {
            $errors[] = "Invalid email. Only gmail.com, yahoo.com, or outlook.com allowed";
        }

        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/", $password)) {
            $errors[] = "Password must be at least 8 characters long and contain at least one number, one uppercase letter, one lowercase letter, and one special character";
        }

        if (empty($errors)) {
            // Encrypt password using password_hash()
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit();
            } else {
                echo "Error: ". $sql. "<br>". $conn->error;
            }
        } else {
            foreach ($errors as $error) {
                echo $error. "<br>";
            }
        }
    } elseif (isset($_POST['l_email']) && isset($_POST['l_pass'])) {
        $email = $_POST['l_email'];
        $password = $_POST['l_pass'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashed_password = $user['password'];

            // Verify password using password_verify()
            if (password_verify($password, $hashed_password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id']; // Assuming 'id' is the primary key in your users table
                header("Location:../../Profile/profile.php");
                exit();
            } else {
                echo "Invalid email or password";
            }
        } else {
            echo "Invalid email or password";
        }
    }
}
?>

<!-- HTML goes here -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="login.css">
</head>
<body class="anima" >
  <div class="fade-zoom-in-effect">

    <form id="regi" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
    <div class="section">
        <div class="container">
          <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
              <div class="section pb-5 pt-5 pt-sm-2 text-center">
                <h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
                <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
                <label for="reg-log"></label>
                <div class="card-3d-wrap mx-auto">
                  <div class="card-3d-wrapper">
                    <div class="card-front">
                      <div class="center-wrap">
                        <div class="section text-center">
                          <h4 class="mb-4 pb-3">Log In</h4>
                          <div class="form-group">
                            <input type="email" id="loginEmail" class="form-style" placeholder="Email" autocomplete="off" autofocus name="l_email">
                            <div id="LoginMassage"></div>
                            <i class="input-icon uil uil-at"></i>
                          </div>  
                          <div class="form-group mt-2">
                            <input type="password" id="loginPassword" class="form-style" placeholder="Password" autocomplete="off" name="l_pass">
                            <i class="input-icon uil uil-lock-alt"></i>
                            <div id="passwordMessage"></div> <!-- Placeholder for password validation message -->
                          </div>
                          <button class="btn mt-4" type="submit" id="btn24">Login</button>
                          <p class="mb-0 mt-4 text-center"><a href="../forgot/forgot.php" class="link">Forgot your password?</a></p>
                        </div>
                      </div>
                    </div>
                    <div class="card-back">
                      <div class="center-wrap">
                        <div class="section text-center">
                          <h4 class="mb-3 pb-3">Sign Up</h4>
                          <div class="form-group">
                            <input type="text" id="fullName" class="form-style" placeholder="Full Name" name="name">
                            <div id="fname"></div>
                            <i class="input-icon uil uil-user"></i>
                          </div>  
                          <!-- <div class="form-group mt-2">
                            <input type="tel" id="phoneNumber" class="form-style" placeholder="Phone Number" name="phone">
                            <i class="input-icon uil uil-phone"></i>
                            <div id="phoneMessage"></div> Placeholder for phone number validation message
                          </div>   -->
                          <div class="form-group mt-2">
                            <input type="email" id="signupEmail" class="form-style" placeholder="Email" name="email">
                            <div id="signupmessage"></div>
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="password" id="signupPassword" class="form-style" placeholder="Password" name="password">
                            <div id="rpass"></div>
                            <i class="input-icon uil uil-lock-alt"></i>
                          </div>
                          <button class="btn mt-4" type="submit" name="register">Register</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <script src="regi.js"></script>
</body>
</html>
