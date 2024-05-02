CREATE TABLE
    Contributor (ArtistName VARCHAR(255) PRIMARY KEY NOT NULL);

CREATE TABLE
    Song (
        SongID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        Title VARCHAR(255) NOT NULL,
        Genre VARCHAR(255) NOT NULL,
        SongLength DECIMAL(4, 2) NOT NULL,
        ArtistName VARCHAR(255) NOT NULL,
        FOREIGN KEY (ArtistName) REFERENCES Contributor (ArtistName)
    );

CREATE TABLE
    KaraokeFiles (
        FileID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        Title VARCHAR(255) NOT NULL,
        SongID INT NOT NULL,
        FOREIGN KEY (SongID) REFERENCES Song (SongID)
    );

CREATE TABLE
    Queue (
        QueueID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        FileID INT NOT NULL,
        Username VARCHAR(255) NOT NULL,
        Price DECIMAL(10, 2),
        FOREIGN KEY (FileID) REFERENCES KaraokeFiles (FileID)
    );


INSERT INTO
    Contributor
VALUES
    ('Katy Perry'),
    ('Ed Sheeran'),
    ('Kesha'),
    ('Daddy Yankee'),
    ('Justin Bieber'),
    ('Luis Fonsi');

INSERT INTO
    Song (Title, Genre, SongLength, ArtistName)
VALUES
    ('Firework', 'Pop', 3.54, 'Katy Perry'),
    ('Roar', 'Pop', 3.42, 'Katy Perry'),
    ('Dark Horse', 'Pop', 3.35, 'Katy Perry'),
    ('California Gurls', 'Pop', 3.54, 'Katy Perry'),
    ('Teenage Dream', 'Pop', 3.47, 'Katy Perry'),
    ('Shape of You', 'pop', 3.50, 'Ed Sheeran'),
    ('Tik Tok', 'pop', 4.41, 'Kesha'),
    ('Perfect', 'pop', 4.23, 'Ed Sheeran'),
    ('Dura', 'Hip hop', 4.21, 'Daddy Yankee'),
    ('Con Calma', 'pop', 4.37, 'Daddy Yankee'),
    ('Love Yourself', 'pop', 3.50, "Justin Bieber"),
    ('Sorry', 'pop', 3.20, 'Justin Bieber'),
    ('What Do You Mean?', 'pop', 3.26, 'Justin Bieber'),
    ('Despacito', 'pop', 3.47, 'Luis Fonsi'),
    ('Echame La Culpa', 'pop', 3.07, 'Luis Fonsi'),
    (
        'No Me Doy Por Vencido',
        'pop',
        3.57,
        'Luis Fonsi'
    ),
    ('Imposible', 'pop', 3.17, 'Luis Fonsi'),
    ('Baby', 'pop', 3.23, 'Justin Bieber');

INSERT INTO
    KaraokeFiles (Title, SongID)
VALUES
    ('Firework', 1),
    ('Roar', 2),
    ('Dark Horse', 3),
    ('California Gurls', 4),
    ('Teenage Dream', 5),
    ('Shape of You', 6),
    ('Tik Tok', 7),
    ('Perfect', 8),
    ('Dura', 9),
    ('Con Calma', 10),
    ('Love Yourself', 11),
    ('Sorry', 12),
    ('What Do You Mean?', 13),
    ('Despacito', 14),
    ('Echame La Culpa', 15),
    ('No Me Doy Por Vencido', 16),
    ('Imposible', 17),
    ('Baby', 18);
