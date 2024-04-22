<?php
include 'db_connect.php';

function resetDatabase($pdo)
{
    // SQL statements to drop existing tables
    $dropStatements = [
        "DROP TABLE IF EXISTS Queue;",
        "DROP TABLE IF EXISTS VersionOfSong;",
        "DROP TABLE IF EXISTS SongContributor;",
        "DROP TABLE IF EXISTS Contributor;",
        "DROP TABLE IF EXISTS Role;",
        "DROP TABLE IF EXISTS User;",
        "DROP TABLE IF EXISTS Song;",
        "DROP TABLE IF EXISTS Artist;",
        "DROP TABLE IF EXISTS Genre;"
    ];

    // Execute each DROP statement
    foreach ($dropStatements as $statement) {
        $pdo->exec($statement);
    }

    // Path to sql file
    $filePath = '/home/hopper/z2012420/public_html/script.sql';

    // Read the SQL file
    $sql = file_get_contents($filePath);

    // Execute the SQL commands
    $pdo->exec($sql);

    echo "Database reset successfully!";
}

// Call the function to reset the database
resetDatabase($pdo);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Database</title>
    <style>
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <a href="ind.php" class="back-button">Go Back</a>
</body>

</html>
