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

// v2
/*$query = "SELECT Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
          GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
          GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles
          FROM Song
          JOIN Artist ON Song.ArtistID = Artist.ArtistID
          JOIN Genre ON Song.GenreID = Genre.GenreID
          JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
          JOIN SongContributor ON Song.SongID = SongContributor.SongID
          JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
          JOIN Role ON Contributor.RoleID = Role.RoleID
          WHERE Song.SongName LIKE :searchTerm 
          OR Artist.ArtistName LIKE :searchTerm 
          OR Contributor.ContributorName LIKE :searchTerm
          OR Genre.GenreName LIKE :searchTerm
          OR VersionOfSong.VersionName LIKE :searchTerm
          OR Role.RoleName LIKE :searchTerm
          GROUP BY Song.SongID, VersionOfSong.VersionName";

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
<html>

<link rel="stylesheet" type="text/css" href="styles.css">

<head>
    <title>Search Results - Karaoke Event Application</title>
</head>

<body>
    <div class="admin-body">
        <h1 class="header">Search Results</h1>
        <?php if (empty($results)) : ?>
            <p class="form-label">No songs were found that match your search.</p>
        <?php else : ?>
            <p class="form-label">Here are the songs that match your search:</p>
            <br>
            <div class="table-container2">
                <table>
                    <tr>
                        <th>Song</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Version</th>
                        <th>Contributors</th>
                        <th>Roles</th>
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
    <div>
        <a href="user.php" class="back-button">Back</a>
    </div>
</body>

</html>
