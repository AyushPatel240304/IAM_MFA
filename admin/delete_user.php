<?php
$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);

    $query = "DELETE FROM users WHERE email = '$email'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('User deleted successfully');
                window.location.href = 'a_dash.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting user');
                window.location.href = 'a_dash.php';
              </script>";
    }
}

mysqli_close($conn);
?>