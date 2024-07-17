<?php
include('../includes/db.php');
include('../includes/header.php');

// Start session to track user
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>Please <a href='../login.php'>login</a> to vote.</p>";
    include('../includes/footer.php');
    exit();
}

// Handle Vote Submission
if (isset($_POST['vote'])) {
    $user_id = $_SESSION['user_id'];
    $candidate_id = $_POST['candidate_id'];

    // Check if user has already voted
    $checkVote = $conn->query("SELECT * FROM votes WHERE user_id = '$user_id'");
    if ($checkVote->num_rows > 0) {
        echo "<p>You have already voted.</p>";
    } else {
        $sql = "INSERT INTO votes (user_id, candidate_id) VALUES ('$user_id', '$candidate_id')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Vote successfully cast!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
}

// Fetch Candidates
$candidates = $conn->query("SELECT * FROM candidates");
?>

<h2>Vote for Your Candidate</h2>
<?php if ($candidates->num_rows > 0): ?>
    <form method="POST" action="">
        <label for="candidate">Choose a candidate:</label>
        <select name="candidate_id" id="candidate" required>
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote">Vote</button>
    </form>
<?php else: ?>
    <p>No candidates available.</p>
<?php endif; ?>

<?php include('../includes/footer.php'); ?>
