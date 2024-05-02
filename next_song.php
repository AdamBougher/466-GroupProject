<?php
include 'db_connect.php';

session_start();

// Check if the playlist is not empty
if (!empty($_SESSION['playlist'])) {
    // Remove the first song from the playlist
    array_shift($_SESSION['playlist']);

    // If there are still songs in the playlist, set the next song as the current song
    if (!empty($_SESSION['playlist'])) {
        $_SESSION['current_song'] = $_SESSION['playlist'][0];
    } else {
        // If the playlist is empty, set the current song to null
        $_SESSION['current_song'] = null;
    }
}

// Redirect back to the DJ page
header('Location: dj.php');
?>


