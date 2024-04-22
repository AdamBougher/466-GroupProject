<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$form_data = $_POST;
include 'db_connect.php';


/*$Queue = $pdo->query("
    SELECT Queue.QueueID, User.UserName, Song.SongName, Artist.ArtistName, Song.KaraokeFileID
    FROM Queue
    JOIN User ON Queue.UserID = User.UserID
    JOIN Song ON Queue.SongID = Song.SongID
    JOIN Artist ON Song.ArtistID = Artist.ArtistID
")->fetchAll();*/


$Queue = $pdo->query("
SELECT Queue.QueueID, User.UserName, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles, Song.KaraokeFileID
FROM Queue
JOIN User ON Queue.UserID = User.UserID
JOIN Song ON Queue.SongID = Song.SongID
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
LEFT JOIN SongContributor ON Song.SongID = SongContributor.SongID
LEFT JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
LEFT JOIN Role ON Contributor.RoleID = Role.RoleID
GROUP BY Queue.QueueID;
")->fetchAll();



$songs = $pdo->query("SELECT * FROM Song")->fetchAll();

?>



<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard - Karaoke Event Application</title>
    <style>
        input[type="text"] {
            background-color: #1f1b33;
            /* Darker background for input */
            color: #00ff41;
            /* Neon green for input text */
            border: none;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 20px #00ff41;
            /* Far outer glow */
        }

        input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 20px #ff43a4;
            /* Far outer glow */
        }

        /*input[type="submit"] {
            background-color: #00ff41;
           
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            
            box-shadow: 0 0 5px #00ff41,
                
                0 0 10px #00ff41,
               
                0 0 15px #00ff41,
               
                0 0 20px #00ff41; } */


        input[type="submit"]:hover {
            background-color: #ff43a4;
            /* Neon pink for button hover */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 20px #ff43a4;
            /* Far outer glow */
        }

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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #00ff41;
            /* Neon green for headers */
            /* adjust padding */
            margin-bottom: 5px;
            margin-top: 20px;
        }

        .back-button {
            position: fixed;
            bottom: 0;
            left: 0;
            display: inline-block;
            padding: 15px 25px;
            margin-top: 20px;
            color: #fff;
            background-color: #ff43a4;
            font-size: 18px;
            /* Neon green for buttons */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 2px #ff43a4;
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
                0 0 2px #00ff41;
            /* Far outer glow */
        }

        .search-button {
            display: inline-block;
            padding: 15px 25px;
            margin: 10px 0;
            margin-left: 20px;
            color: #fff;
            background-color: #ff43a4;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 2px #ff43a4;
            /* Far outer glow */
        }



        input.button {
            display: inline-block;
            padding: 15px 25px;
            margin: 10px 0;
            color: #fff;
            background-color: #ff43a4;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 2px #ff43a4;
            /* Far outer glow */
        }




        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0px 0px 30px 2px #ff43a4;
            /* Neon pink shadow for the table */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #1f1b33;
            /* Darker background for table headers */
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


        p {
            color: #f5f5f5;
            /* Light text */
            text-align: center;
            margin-top: 3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User Dashboard</h1>
        <p>Welcome to the User Dashboard! Here, you can search for songs, sign up to sing, and view the queue of upcoming performances.</p>

        <h2>Search for Songs</h2>
        <p>Enter the artist name, song title, or contributor in the search box below:</p>
        <form action="search.php" method="post">
            <input type="text" name="search" placeholder="Search for songs...">
            <input type="submit" value="Search" class="search-button">
        </form>

        <h2>Sign Up to Sing</h2>
        <p>Found a song you want to sing? Great! Select the song and choose your queue:</p>
        <form action="signup.php" method="post">
            <input type="submit" value="Go to Sign Up" class="button">
        </form>

        <h2>View Queue</h2>
        <p>Check out the queue to see the list of upcoming performances:</p>
        <table>
            <tr>
                <th>User</th>
                <th>Song</th>
                <th>Artist</th>
                <th>Karaoke File ID</th>
                <th>Queue
            </tr>
            <?php foreach ($Queue as $performance) : ?>
                <tr>
                    <td><?php echo $performance['UserName']; ?></td>
                    <td><?php echo $performance['SongName']; ?></td>
                    <td><?php echo $performance['ArtistName']; ?></td>
                    <td><?php echo $performance['KaraokeFileID']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div>

        <a href="ind.php" class="back-button">Back</a>
    </div>

</body>

</html>
