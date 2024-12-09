
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>MFA</title>
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.0.2/tailwind.min.css"
    />
    <link rel="stylesheet" href="../forgot/forgot.css" />
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
    </ul>

    <div id="content">
      <div class="main_container">
        <form id="loginForm" method="post" action="send_pass.php">
          <h1>Admin Login</h1>
          <div class="form-group">
            <label for="email">Enter valid Email</label>
            <input type="email" id="email" name="email" required placeholder="abc@gmail.com" autocomplete="off" />
            <!-- <label for="password">Password</label>
            <input type="password" id="password" required placeholder="Password" autocomplete="off" /> -->
            <button type="submit" class="submitbtn">Send Code</button>
          </div>
        </form>
      </div>
    </div>
    <script src="forgot.js"></script>
  </body>
</html>
