<?php
include 'db_connect.php';

// Clear the queue
$pdo->query("DELETE FROM Queue");


// Redirect back to the dj page
header('Location: dj.php');
?>
