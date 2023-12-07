<?php
include 'functions.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete the ticket with the specified ID
    delete_ticket($id);

    // Redirect back to the index page or any other appropriate page
    header("Location: index.php");
    exit();
} else {
    echo "Invalid ticket ID.";
}
?>
