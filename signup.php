<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$users = $pdo->query("SELECT * FROM User")->fetchAll();
/*$songs = $pdo->query("SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
JOIN SongContributor ON Song.SongID = SongContributor.SongID
JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
JOIN Role ON Contributor.RoleID = Role.RoleID
GROUP BY Song.SongID, VersionOfSong.VersionName;")->fetchAll();*/


$songs = $pdo->query("
SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
LEFT JOIN SongContributor ON Song.SongID = SongContributor.SongID
LEFT JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
LEFT JOIN Role ON Contributor.RoleID = Role.RoleID
GROUP BY Song.SongID, VersionOfSong.VersionName;
")->fetchAll();


$queues = $pdo->query("SELECT * FROM Queue")->fetchAll();
?>
<!DOCTYPE html>
<html>


<head>
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .bold-center {
            text-align: center;
            font-weight: bold;
            color: #ff43a4;
            /* Neon pink for headers */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0px 0px 30px 2px #ff43a4;
            /* Neon pink shadow for the table */
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


        th {
            background-color: #1f1b33;
            /* Darker background for table headers */
            color: #00ff41;
            /* Neon green for table headers */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }


        .selected {
            background-color: #ff43a4;
            /* Neon pink for selected row */
        }

        .back-button {
            position: auto;
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            color: #fff;
            border: none;
            background-color: #ff43a4;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 5px #ff43a4;
        }


        .back-button:hover {
            /* Cyan for button hover */
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 5px #00ff41;
        }



        .form-label,
        .form-select,
        .form-input {
            /* ...existing styles... */
            width: 80%;
            /* Adjust as needed */
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            color: #fff;
            border: none;
            background-color: #ff43a4;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 1px #ff43a4;
            /* Far outer glow */
        }


        label {
            color: #ff43a4;
            /* Neon pink for labels */
        }

        input[type="number"] {
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

        input[type="number"]:focus {
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



        input[type="submit"] {
            background-color: #00ff41;
            /* Neon green for buttons */
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 20px #00ff41;
            /* Far outer glow */
        }

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

        select {
            background-color: #1f1b33;
            /* Darker background for select */
            color: #00ff41;
            /* Neon green for select text */
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

        select:focus {
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


        .form-label {
            display: block;
            margin-bottom: 10px;
            /* Space between label and select/input */
            color: #ff43a4;
            font-weight: bold;
            /* Neon pink for labels */
        }

        .form-select,
        .form-input {
            width: 100%;
            margin-bottom: 20px;
            /* Space between select/input and the next element */
        }

        tr.selected,
        tr:hover.selected {
            background-color: #ff43a4;
            /* Neon pink for selected row */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 20px #ff43a4;
            /* Far outer glow */
        }
    </style>
    <script>
        function validateForm() {
            var user = document.getElementById('user').value;
            var song = document.getElementById('selectedSong').value;

            switch (true) {
                case (user === 'Select a user...' && song === ''):
                    alert('Please select a user and a song');
                    return false;
                case (song === ''):
                    alert('Please select a song');
                    return false;
                case (user === 'Select a user...'):
                    alert('Please select a user');
                    return false;
                default:
                    return true;
            }
        }


        /*function selectSong(songId, songName, clickedRow) {
            var table = document.getElementById('songTable');
            for (var i = 1, row; row = table.rows[i]; i++) {
                row.classList.remove('selected');
            }
            clickedRow.classList.add('selected');
            document.getElementById('selectedSong').value = songId;
            document.getElementById('song').value = songName;
        }*/

        function selectSong(songId, songName, clickedRow) {
            var table = document.getElementById('songTable');
            for (var i = 1, row; row = table.rows[i]; i++) {
                // If the row is already selected, unselect it
                if (row === clickedRow && row.classList.contains('selected')) {
                    row.classList.remove('selected');
                    document.getElementById('selectedSong').value = '';
                    document.getElementById('song').value = '';
                    return;
                }
                row.classList.remove('selected');
            }
            clickedRow.classList.add('selected');
            document.getElementById('selectedSong').value = songId;
            document.getElementById('song').value = songName;
        }
    </script>
</head>

<body>
    <h2 class="bold-center">Sign Up to Sing</h2>
    <div class="container">


        <form action="signup_process.php" method="post" onsubmit="return validateForm()">
            <br>
            <label for="user" class="form-label">User:</label>
            <select name="user" id="user" class="form-select" required="">
                <option>Select a user...</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?php echo $user['UserID']; ?>"><?php echo $user['UserName']; ?></option>
                <?php endforeach; ?>
            </select>



            <input type="hidden" id="selectedSong" name="selectedSong">

            <br>
            <table id="songTable">
                <tr>
                    <th>Song</th>
                    <th>Artist</th>
                    <th>Genre</th>
                    <th>Version</th>
                    <th>Contributor</th>
                    <th>Role</th>
                </tr>
                <?php if (!empty($songs)) : ?>
                    <?php foreach ($songs as $song) : ?>
                        <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['SongName']; ?>', this)">
                            <td><?php echo $song['SongName']; ?></td>
                            <td><?php echo $song['ArtistName']; ?></td>
                            <td><?php echo $song['GenreName']; ?></td>
                            <td><?php echo $song['VersionName']; ?></td>
                            <td><?php echo $song['Contributors']; ?></td>
                            <td><?php echo $song['Roles']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>


            <br>
            <label for="price" class="form-label">Price:</label>
            <input type="number" name="price" id="price" class="form-input" placeholder="Empty for normal queue">


            <input type="submit" value="Submit" class="button">
            <a href="user.php" class="back-button">Back to Dashboard</a>
        </form>
    </div>
</body>

</html>
