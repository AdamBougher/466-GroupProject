<?php
// Database connection file
include 'db_connect.php';

// Get the search term from the form
$searchTerm = $_POST['search'];

// SQL query to search for songs
// $query = "SELECT SongName, ArtistName FROM Song JOIN Artist ON Song.ArtistID = Artist.ArtistID WHERE SongName LIKE :searchTerm OR ArtistName LIKE :searchTerm";
/*$query = "SELECT Song.SongName, Artist.ArtistName, Contributor.ContributorName 
          FROM Song 
          JOIN Artist ON Song.ArtistID = Artist.ArtistID 
          JOIN SongContributor ON Song.SongID = SongContributor.SongID 
          JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID 
          WHERE Song.SongName LIKE :searchTerm 
          OR Artist.ArtistName LIKE :searchTerm 
          OR Contributor.ContributorName LIKE :searchTerm";
*/

$query = "
SELECT Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
LEFT JOIN SongContributor ON Song.SongID = SongContributor.SongID
LEFT JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
LEFT JOIN Role ON Contributor.RoleID = Role.RoleID
WHERE Song.SongName LIKE :searchTerm 
OR Artist.ArtistName LIKE :searchTerm 
OR Contributor.ContributorName LIKE :searchTerm
OR Genre.GenreName LIKE :searchTerm
OR VersionOfSong.VersionName LIKE :searchTerm
OR Role.RoleName LIKE :searchTerm
GROUP BY Song.SongID, VersionOfSong.VersionName;
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
    <link rel="icon" href="icon.png" type="image/x-icon">
</head>

<body>
    <div class="admin-body">
        <h1 class="header">Search Results</h1>
        <?php if (empty($results)) : ?>
            <p class="form-label">No songs were found that match your search.</p>
        <?php else : ?>
            <p class="form-label">Here are the songs that match your search:</p>
            <p class = "form-label">Click on the column headers to sort the table.</p>
            <br>
            <div class="table-container2">
                <table id="searchTable">
                    <tr>
                        <th onclick="sortTable(0)">Song</th>
                        <th onclick="sortTable(1)">Artist</th>
                        <th onclick="sortTable(2)">Genre</th>
                        <th onclick="sortTable(3)">Version</th>
                        <th onclick="sortTable(4)">Contributors</th>
                        <th onclick="sortTable(5)">Roles</th>
                    </tr>
                    <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><?php echo $result['SongName']; ?></td>
                            <td><?php echo $result['ArtistName']; ?></td>
                            <td><?php echo $result['GenreName']; ?></td>
                            <td><?php echo $result['VersionName']; ?></td>
                            <td><?php echo $result['Contributors']; ?></td>
                            <td><?php echo $result['Roles']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                
            </div>
        <?php endif; ?>
    </div>
    <a href="user.php" class="back-button">Back</a>
</body>

</html>
