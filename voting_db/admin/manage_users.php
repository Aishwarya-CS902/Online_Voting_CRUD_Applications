<?php
include('../includes/db.php');
include('../includes/header.php');

// Handle Create User
if (isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    $conn->query($sql);
}

// Handle Update User
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = ($_POST['password'] != '') ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $role = $_POST['role'];

    // Construct SQL based on whether password is updated or not
    if ($password) {
        $sql = "UPDATE users SET username='$username', password='$password', role='$role' WHERE id=$id";
    } else {
        $sql = "UPDATE users SET username='$username', role='$role' WHERE id=$id";
    }
    $conn->query($sql);
}

// Handle Delete User
if (isset($_POST['delete_user'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
}

// Fetch Users
$result = $conn->query("SELECT * FROM users");
?>

<h2>Manage Users</h2>

<form method="POST" action="">
    Hidden field to store user ID -->
    <input type="hidden" name="id" value="">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password">
    <select name="role">
        <option value="admin">Admin</option>
        <option value="voter">Voter</option>
    </select>
    <button type="submit" name="create_user">Create User</button>
</form>

<h3>Existing Users</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
            <form method="POST" action="">
                <!-- Hidden field to store user ID -->
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                <input type="password" name="password" placeholder="New Password">
                <select name="role">
                    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="voter" <?php if($row['role'] == 'voter') echo 'selected'; ?>>Voter</option>
                </select>
                <button type="submit" name="update_user">Update</button>
                <button type="submit" name="delete_user">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('../includes/footer.php'); ?>


