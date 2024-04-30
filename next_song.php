<?php
include 'db_connect.php';

session_start();


// best
// Check if the playlist is not empty
/*if (!empty($_SESSION['playlist'])) {
    // Remove the first song from the playlist and set it as the current song
    $_SESSION['current_song'] = array_shift($_SESSION['playlist']);
    // Save the updated playlist back into the session variable
    $_SESSION['playlist'] = array_values($_SESSION['playlist']);
} else {
    // If the playlist is empty, set the current song to null
    $_SESSION['current_song'] = null;
    echo "No more songs in the playlist.";
}*/


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


