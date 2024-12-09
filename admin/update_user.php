<?php
$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_email = mysqli_real_escape_string($conn, $_POST['original_email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);

    $query = "UPDATE users SET 
              name = '$name', 
              email = '$email', 
              role = '$role', 
              gender = '$gender', 
              contact_no = '$contact_no' 
              WHERE email = '$original_email'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('User updated successfully');
                window.location.href = 'a_dash.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating user');
                window.location.href = 'a_dash.php';
              </script>";
    }
}

mysqli_close($conn);
?>