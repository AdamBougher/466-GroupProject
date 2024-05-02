<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();



if (isset($_POST['song']) && isset($_POST['artist']) && isset($_POST['queueId'])) {
    // Add the song to the session playlist
    $_SESSION['playlist'][] = array('song' => $_POST['song'], 'artist' => $_POST['artist']);

    // If no song is currently playing, start playing the added song
    if ($_SESSION['current_song'] === null) {
        $_SESSION['current_song'] = end($_SESSION['playlist']);
    }

    // Remove the song from the queue
    $queueId = $_POST['queueId'];
    $stmt = $pdo->prepare("DELETE FROM Queue WHERE QueueID = :queueId");
    $stmt->execute(['queueId' => $queueId]);
}

