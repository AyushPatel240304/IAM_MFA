<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = mysqli_real_escape_string($conn, $_GET['email']);
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.0.2/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl mb-4 text-center">Edit User</h2>
        <form action="update_user.php" method="post">
            <input type="hidden" name="original_email" value="<?php echo htmlspecialchars($user['email']); ?>">
            
            <div class="mb-4">
                <label class="block mb-2">Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Role</label>
                <select name="role" class="w-full px-3 py-2 border rounded">
                    <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="manager" <?php echo ($user['role'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Gender</label>
                <div class="flex">
                    <label class="mr-4">
                        <input type="radio" name="gender" value="male" 
                               <?php echo ($user['gender'] == 'male') ? 'checked' : ''; ?>>
                        Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" 
                               <?php echo ($user['gender'] == 'female') ? 'checked' : ''; ?>>
                        Female
                    </label>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Contact Number</label>
                <input type="tel" name="contact_no" value="<?php echo htmlspecialchars($user['contact_no']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <button type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Update User
            </button>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>