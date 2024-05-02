<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection file
include 'db_connect.php';

// Get the search term from the form
$searchTerm = $_POST['search'];

// SQL query to search for songs
$query = "
SELECT Song.Title AS SongName, Contributor.ArtistName, Song.Genre AS GenreName, KaraokeFiles.Title AS VersionName
FROM Song
JOIN Contributor ON Song.ArtistName = Contributor.ArtistName
JOIN KaraokeFiles ON Song.SongID = KaraokeFiles.SongID
WHERE Song.Title LIKE :searchTerm 
OR Contributor.ArtistName LIKE :searchTerm 
OR Song.Genre LIKE :searchTerm
OR KaraokeFiles.Title LIKE :searchTerm
";

// Prepare the SQL statement
$stmt = $pdo->prepare($query);

// Bind the search term to the SQL statement
$stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');

// Execute the SQL statement
$stmt->execute();

// Fetch all the results
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Search Results - Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="main.js"></script>
</head>

<body>
    <div class="admin-body">
        <h1 class="header">Search Results</h1>
        <?php if (empty($results)) : ?>
            <p class="form-label">No songs were found that match your search.</p>
        <?php else : ?>
            <p class="form-label">Here are the songs that match your search:</p>
            <p class="form-label">Click on the column headers to sort the table.</p>
            <br>
            <div class="table-container2">
                <table id="searchTable">
                    <tr>
                        <th class="clickable-header" onclick="sortTable(0, 'searchTable')">Song</th>
                        <th class="clickable-header" onclick="sortTable(1, 'searchTable')">Artist</th>
                        <th class="clickable-header" onclick="sortTable(2, 'searchTable')">Genre</th>
                        <th class="clickable-header" onclick="sortTable(3, 'searchTable')">Version</th>
                    </tr>
                    <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><?php echo $result['SongName']; ?></td>
                            <td><?php echo $result['ArtistName']; ?></td>
                            <td><?php echo $result['GenreName']; ?></td>
                            <td><?php echo $result['VersionName']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>
        <?php endif; ?>
    </div>
    <a href="user.php" class="back-button">Back</a>
</body>

</html>
