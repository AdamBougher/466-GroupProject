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

<head>
    <title>Search Results - Karaoke Event Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0d0c22;
            /* Dark background */
            color: #f5f5f5;
            /* Light text */
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #ff43a4;
            /* Neon pink for headers */
            text-align: center;
        }

        p {
            color: #f5f5f5;
            /* Light text */
            text-align: center;
        }

        .bold-center {
            font-weight: bold;
            text-align: center;
            color: #ff43a4;
            /* Neon pink for headers */
        }

        .back-button {
            bottom: 0;
            left: 0;
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #fff;
            background-color: #ff43a4;
            border: none;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 5px #ff43a4;
            /* Far outer glow */
        }

        .back-button:hover {
            background-color: #00ff41;
            /* Neon pink for button hover */
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 5px #00ff41;
            /* Far outer glow */
        }

        table {
            width: 100%;
            max-width: 600px;
            /* Adjust this value, preference */
            margin: 0 auto;
            /* This will center the table if smaller than parent container */
            border-collapse: collapse;
            box-shadow: 0px 0px 30px 2px #ff43a4;
            /* Neon pink shadow for the table */
        }

        th,
        td {
            width: 25%;
            /* Each cell 25% of the width of the table */
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: #00ff41;
            /* Neon green for table headers */
        }

        tr {
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
        }

        tr:hover {
            background-color: #27233a;
            /* Slightly lighter background for hover */
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 20px #00ff41;
            /* Far outer glow */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Search Results</h1>
        <?php if (empty($results)) : ?>
            <p>No songs were found that match your search.</p>
        <?php else : ?>
            <p>Here are the songs that match your search:</p>
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


        <?php endif; ?>
    </div>
    <div>
        <a href="user.php" class="back-button">Back to Dashboard</a>
    </div>
</body>

</html>
