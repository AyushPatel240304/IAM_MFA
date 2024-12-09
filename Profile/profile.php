<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../user/login.php");
    exit();
}

include('../user/db.php');

// Function to fetch user details from the database
function fetchUserDetails($conn, $email) {
    $sql = "SELECT name, email, contact_no, role, gender FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Handle form submission and update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_email = $_SESSION['email'];
    $name = $conn->real_escape_string($_POST['name']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $role = $conn->real_escape_string($_POST['role']);
    $gender = $conn->real_escape_string($_POST['gender']);

    // Update user details in the database
    $sql = "UPDATE users SET name='$name', email='$new_email', contact_no='$contact_no', role='$role', gender='$gender' WHERE email='$old_email'";

    if ($conn->query($sql) === TRUE) {
        $update_success = "Profile updated successfully.";
        // Update the session email if it was changed
        if ($old_email !== $new_email) {
            $_SESSION['email'] = $new_email;
        }
    } else {
        $update_error = "Error updating profile: " . $conn->error;
    }
}

$email = $_SESSION['email'];
$userDetails = fetchUserDetails($conn, $email);
$conn->close();

$name = $userDetails['name'] ?? '';
$contact_no = $userDetails['contact_no'] ?? '';
$role = $userDetails['role'] ?? '';
$gender = $userDetails['gender'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>MFA</title>
    <link rel="stylesheet" href="prof.css">
    <script defer src="../home.js"></script>
    <script src="prof.js"></script>
</head>
<body>
    <div id="content">

        <!-- Heading -->
        <div class="heading">
            <h1><span>Profile</span></h1>
        </div>
        <div id="logout-button" style="position: absolute; top: 20px; right: 20px;">
        <form method="post" action="../../../index.html">
            <button type="submit" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">Logout</button>
        </form>
    </div>
        

        <!-- Details -->
        <form method="post" action="profile.php">
            <div class="main_cont">
                <div class="container">
                    <input required="" type="text" name="name" class="input" value="<?php echo htmlspecialchars($name); ?>">
                    <label class="label">Name</label>
                </div>
                <div class="container">
                    <input required="" type="email" name="email" class="input" value="<?php echo htmlspecialchars($email); ?>">
                    <label class="label">Email</label>
                </div>
                <div class="container">
                    <input required="" type="number" name="contact_no" class="input" value="<?php echo htmlspecialchars($contact_no); ?>">
                    <label class="label">Contact No.</label>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="main_cont">
                <div class="container">
                    <select name="role" class="input">
                        <option value="">Select an option</option>
                        <option value="Admin" <?php echo $role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="User" <?php echo $role == 'User' ? 'selected' : ''; ?>>User</option>
                    </select>
                    <label class="label">Define your role</label>
                </div>
                <div class="container">
                    <select name="gender" class="input">
                        <option value="">Select an option</option>
                        <option value="Male" <?php echo $gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                    <label class="label">Gender</label>
                </div>
            </div>

            <!-- Button -->
            <div class="main_cont">
                <button type="submit" class="button">
                    <div class="outline"></div>
                    <div class="state state--default">
                        <div class="icon">
                            <!-- SVG Icon -->
                        </div>
                        <p>
                            <span style="--i:0">U</span>
                            <span style="--i:1">P</span>
                            <span style="--i:2">D</span>
                            <span style="--i:3">A</span>
                            <span style="--i:4">T</span>
                            <span style="--i:5">E</span>
                        </p>
                    </div>
                    <div class="state state--sent">
                        <div class="icon">
                            <!-- SVG Icon -->
                        </div>
                        <p>
                            <span style="--i:5">D</span>
                            <span style="--i:6">O</span>
                            <span style="--i:7">N</span>
                            <span style="--i:8">E</span>
                        </p>
                    </div>
                </button>
            </div>
        </form>
        <!-- Display success or error message -->
        <?php if (isset($update_success)): ?>
            <p class="success"><?php echo $update_success; ?></p>
        <?php elseif (isset($update_error)): ?>
            <p class="error"><?php echo $update_error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
