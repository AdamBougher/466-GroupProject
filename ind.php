<!DOCTYPE html>
<html>

<head>
    <title>Karaoke Event Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0d0c22;
            /* Dark background */
            color: #f5f5f5;
            /* Ligt text */
            font-size: 20px;
            /* Increase the base font size */
        }

        .container {
            width: 100%;
            max-width: 800px;
            /* Increase the max-width */
            margin: 0 auto;
            padding: 40px;
            /* Increase the padding */
        }


        .button {
            display: inline-block;
            padding: 20px 40px;
            /* Increase the padding */
            margin: 20px;
            /* Increase the margin */
            color: #fff;
            border: none;
            background-color: #ff43a4;
            border-radius: 5px;
            text-decoration: none;
            font-size: 30px;
            /* Increase the font size */
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

        .button:hover {
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


    </style>
</head>

<body>
    <div class="container">
        <h1 style="font-size: 2em;">Welcome to Karaoke Event Application</h1> 
        <p style="font-size: 1.5em;">Please select your role:</p>

        <a href="user.php" class="button">User</a>
        <a href="dj.php" class="button">DJ</a>
        <a href="admin.php" class="button">Admin</a>
        
        <h1>UpNext</h1>
            <table id="songTable">
                <tr>
                    <th>Name</th>
                    <th>Song</th>
                    <th>Artist</th>
                    <th>Version</th>
                </tr>

                
            </table>



        <h2>PLayList</h2>
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

    </div>
</body>

</html>
