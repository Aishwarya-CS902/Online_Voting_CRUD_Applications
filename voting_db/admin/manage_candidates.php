<?php
include('../includes/db.php');
include('../includes/header.php');

// Handle Create Candidate
if (isset($_POST['create_candidate'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO candidates (name, description) VALUES ('$name', '$description')";
    $conn->query($sql);
}

// Handle Update Candidate
if (isset($_POST['update_candidate'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE candidates SET name='$name', description='$description' WHERE id=$id";
    $conn->query($sql);
}

// Handle Delete Candidate
if (isset($_POST['delete_candidate'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM candidates WHERE id=$id";
    $conn->query($sql);
}

// Fetch Candidates
$result = $conn->query("SELECT * FROM candidates");
?>

<h2>Manage Candidates</h2>

<form method="POST" action="">
    <input type="hidden" name="id" value="">
    <input type="text" name="name" placeholder="Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <button type="submit" name="create_candidate">Create Candidate</button>
</form>

<h3>Existing Candidates</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                <textarea name="description" required><?php echo $row['description']; ?></textarea>
                <button type="submit" name="update_candidate">Update</button>
                <button type="submit" name="delete_candidate">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('../includes/footer.php'); ?>
