<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_closed'])) {
    $pdo = pdo_connect_mysql();

    try {
        // Delete tickets that have a status of 'closed'
        $stmt = $pdo->prepare('DELETE FROM tickets WHERE status = ?');
        $status = 'closed';
        $stmt->execute([$status]);

        // Optionally, you might want to delete associated comments for the deleted tickets
        $stmtComments = $pdo->prepare('DELETE FROM tickets_comments WHERE ticket_id NOT IN (SELECT id FROM tickets)');
        $stmtComments->execute();

        // Redirect to the current page after deletion or any other desired location
        header('Location: delete_closed_tickets.php?success=true');
        exit;
    } catch (PDOException $e) {
        // Handle exception (e.g., log error, display error message)
        error_log('Failed to delete closed tickets: ' . $e->getMessage());
        // Display error message or handle the error as needed
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Closed Tickets</title>
    <!-- Add any necessary styles or scripts -->
</head>
<body>
    <h2>Delete Closed Tickets</h2>
    <form method="post">
        <input type="submit" name="delete_closed" value="Delete Closed Tickets">
    </form>
    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <p>Closed tickets successfully deleted.</p>
    <?php endif; ?>
</body>
</html>
