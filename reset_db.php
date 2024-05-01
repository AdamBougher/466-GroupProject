<?php
include 'db_connect.php';

function resetDatabase($pdo)
{
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

    foreach ($dropStatements as $statement) {
        $pdo->exec($statement);
    }

    $createStatements = [
        "CREATE TABLE User (
            UserID INT PRIMARY KEY AUTO_INCREMENT,
            UserName VARCHAR(255)
        );",
        "CREATE TABLE Genre (
            GenreID INT PRIMARY KEY NOT NULL,
            GenreName VARCHAR(255) NOT NULL
        );",
        "CREATE TABLE Artist (
            ArtistID INT PRIMARY KEY NOT NULL,
            ArtistName VARCHAR(255) NOT NULL
        );",
        "CREATE TABLE Role (
            RoleID INT PRIMARY KEY NOT NULL,
            RoleName VARCHAR(255) NOT NULL,
            RoleDescription VARCHAR(255) NOT NULL
        );",
        "CREATE TABLE Contributor (
            ContributorID INT PRIMARY KEY NOT NULL,
            ContributorName VARCHAR(255) NOT NULL,
            RoleID INT NOT NULL,
            FOREIGN KEY (RoleID) REFERENCES Role(RoleID)
        );",
        "CREATE TABLE Song (
            SongID INT PRIMARY KEY NOT NULL,
            SongName VARCHAR(255) NOT NULL,
            ArtistID INT NOT NULL,
            GenreID INT NOT NULL,
            KaraokeFileID INT NOT NULL,
            FOREIGN KEY (ArtistID) REFERENCES Artist(ArtistID),
            FOREIGN KEY (GenreID) REFERENCES Genre(GenreID)
        );",
        "CREATE TABLE VersionOfSong (
            VersionID INT PRIMARY KEY NOT NULL,
            SongID INT NOT NULL,
            VersionName VARCHAR(255) NOT NULL,
            KaraokeFileID INT NOT NULL,
            FOREIGN KEY (SongID) REFERENCES Song(SongID)
        );",
        "CREATE TABLE SongContributor (
            SongID INT NOT NULL,
            ContributorID INT NOT NULL,
            Role VARCHAR(255) NOT NULL,
            PRIMARY KEY (SongID, ContributorID),
            FOREIGN KEY (SongID) REFERENCES Song(SongID),
            FOREIGN KEY (ContributorID) REFERENCES Contributor(ContributorID)
        );",
        "CREATE TABLE Queue (
            QueueID INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
            SongID INT NOT NULL, 
            UserID INT,
            UserName VARCHAR(255) NOT NULL,
            Price DECIMAL(10, 2),
            FOREIGN KEY (SongID) REFERENCES Song(SongID),
            FOREIGN KEY (UserID) REFERENCES User(UserID)
        );"
    ];


    foreach ($createStatements as $statement) {
        $pdo->exec($statement);
    }

    $insertStatements = [
        "INSERT INTO User (UserID, UserName)
        VALUES 
            (1, 'Alice'),
            (2, 'Bob'),
            (3, 'Charlie'),
            (4, 'David'),
            (5, 'Eve'),
            (6, 'Frank'),
            (7, 'Grace'),
            (8, 'Hank'),
            (9, 'Ivy'),
            (10, 'Jack');",
        "INSERT INTO Genre (GenreID, GenreName)
        VALUES 
            (1, 'Pop'),
            (2, 'Rock'),
            (3, 'Country'),
            (4, 'R&B'),
            (5, 'Hip Hop');",
        "INSERT INTO Artist (ArtistID, ArtistName)
        VALUES 
            (1, 'Justin Bieber'),
            (2, 'Katy Perry'),
            (3, 'Ed Sheeran'),
            (4, 'Luis Fonsi'),
            (5, 'Daddy Yankee');",
        "INSERT INTO Role (RoleID, RoleName, RoleDescription)
        VALUES 
            (1, 'Singer', 'Main vocalist'),
            (2, 'Songwriter', 'Writes the song lyrics'),
            (3, 'Producer', 'Produces the song'),
            (4, 'Composer', 'Composes the music for the song');",
        "INSERT INTO Contributor (ContributorID, ContributorName, RoleID)
        VALUES 
            (1, 'Max Martin', 2),
            (2, 'Shellback', 3),
            (3, 'Benny Blanco', 4),
            (4, 'Dr. Luke', 1),
            (5, 'Cirkut', 3);",
        "INSERT INTO Song (SongID, SongName, ArtistID, GenreID, KaraokeFileID)
        VALUES 
            (1, 'Baby', 1, 1, 101),
            (2, 'Firework', 2, 1, 102),
            (3, 'Shape of You', 3, 1, 103),
            (4, 'Despacito', 4, 1, 104),
            (5, 'Con Calma', 5, 5, 105),
            (6, 'Love Yourself', 1, 1, 106),
            (7, 'Roar', 2, 1, 107),
            (8, 'Perfect', 3, 1, 108),
            (9, 'Echame La Culpa', 4, 1, 109),
            (10, 'Dura', 5, 5, 110),
            (11, 'Baby', 1, 1, 111);",
        "INSERT INTO VersionOfSong (VersionID, SongID, VersionName, KaraokeFileID)
        VALUES 
            (1, 1, 'Remix', 201),
            (2, 2, 'Acoustic', 202),
            (3, 3, 'Live', 203),
            (4, 4, 'Remix', 204),
            (5, 5, 'Acoustic', 205),
            (6, 6, 'Live', 206),
            (7, 7, 'Remix', 207),
            (8, 8, 'Acoustic', 208),
            (9, 9, 'Live', 209),
            (10, 10, 'Remix', 210),
            (11, 11, 'Acoustic', 211);",
        "INSERT INTO SongContributor (SongID, ContributorID, Role)
        VALUES 
            (1, 1, 'Songwriter'),
            (1, 2, 'Producer'),
            (2, 3, 'Composer'),
            (2, 4, 'Singer'),
            (3, 5, 'Producer'),
            (3, 1, 'Songwriter'),
            (4, 2, 'Producer'),
            (4, 3, 'Composer'),
            (5, 4, 'Singer');",
        "INSERT INTO Queue (SongID, UserID, UserName, Price)
        VALUES 
            (1,1, '', 1.99),
            (2,2, '', NULL),
            (3,3, '', 120),
            (4,4, '', 9000),
            (5,5, '', 0),
            (6,6, '', NULL),
            (7,7, '', 0),
            (8,8, '', 0),
            (9,9, '', NULL),
            (10,10, '', 250),
            (11,1, '', 0.01);"
    ];

    foreach ($insertStatements as $statement) {
        $pdo->exec($statement);
    }

    echo '<div class="admin-body">';
    echo '<h2 class="success-message">Database has been reset.</h2>';
    echo '</div>';
}

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
