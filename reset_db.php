<?php
include 'db_connect.php';

function resetDatabase($pdo)
{
    // SQL statements to drop existing tables
    $dropStatements = [
        "DROP TABLE IF EXISTS Queue;",
        "DROP TABLE IF EXISTS PriorityQueue;",
        "DROP TABLE IF EXISTS KaraokeFiles;",
        "DROP TABLE IF EXISTS Song;",
        "DROP TABLE IF EXISTS Contributor;", 
    ];

    // Execute each DROP statement
    foreach ($dropStatements as $statement) {
        $pdo->exec($statement);
    }

    // Path to sql file
    $filePath = '/home/hopper/z2012420/public_html/create.sql';

    // Read the SQL file
    $sql = file_get_contents($filePath);

    // Execute the SQL commands
    $pdo->exec($sql);

    echo '<div class="admin-body">';
    echo '<h2 class="success-message">Database has been reset.</h2>';
    echo '</div>';
}

// Call the function to reset the database
resetDatabase($pdo);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Database</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <a href="ind.php" class="back-button">Go Back</a>
</body>

</html>
