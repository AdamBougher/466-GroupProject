<?php
include 'db_connect.php';

// Clear the playlist
session_start();
$_SESSION['playlist'] = array();
$_SESSION['current_song'] = null;

// Redirect back to the dj page
header('Location: dj.php');
?>
