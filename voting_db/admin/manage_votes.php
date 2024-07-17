<?php
include('../includes/db.php');
include('../includes/header.php');

// Fetch Votes
$result = $conn->query("
    SELECT users.username, candidates.name AS candidate_name
    FROM votes
    JOIN users ON votes.user_id = users.id
    JOIN candidates ON votes.candidate_id = candidates.id
");
?>

<h2>View Votes</h2>

<table>
    <tr>
        <th>Voter</th>
        <th>Candidate</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['candidate_name']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('../includes/footer.php'); ?>
