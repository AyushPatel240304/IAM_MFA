<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.0.2/tailwind.min.css">
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white shadow-md rounded">
        <h1 class="text-2xl font-bold p-4 bg-blue-500 text-white">User Management</h1>
        
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-left">Gender</th>
                    <th class="p-3 text-left">Contact No</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr class="border-b">
                    <td class="p-3"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($row['role']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($row['contact_no']); ?></td>
                    <td class="p-3">
                        <a href="edit_user.php?email=<?php echo urlencode($row['email']); ?>" 
                           class="bg-blue-500 text-white px-3 py-1 rounded mr-2">Edit</a>
                        <a href="delete_user.php?email=<?php echo urlencode($row['email']); ?>" 
                           onclick="return confirm('Are you sure you want to delete this user?');"
                           class="bg-red-500 text-white px-3 py-1 rounded">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


<?php
mysqli_close($conn);
?>