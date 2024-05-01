CREATE TABLE Contributor(
    ArtistName VARCHAR(255) PRIMARY KEY NOT NULL,
);

CREATE TABLE Song(
    SongID INT PRIMARY KEY NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Genre VARCHAR(255) NOT NULL,
    SongLength DECIMAL(4,2) NOT NULL,
    ArtistName VARCHAR(255) NOT NULL,
    FOREIGN KEY (ArtistName) REFERENCES Contributor(ArtistName)
);

CREATE TABLE KaraokeFiles(
    FileID INT PRIMARY KEY NOT NULL,
    Title VARCHAR(255) NOT NULL,
    SongID INT NOT NULL,
    FOREIGN KEY (SongID) REFERENCES Song(SongID)
);

CREATE TABLE Queue(
    QueueID INT PRIMARY KEY NOT NULL,
    FileID INT NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Price DECIMAL(4,2),
    FOREIGN KEY (FileID) REFERENCES KaraokeFiles(FileID)
);

CREATE TABLE PriorityQueue(
    QueueID INT PRIMARY KEY NOT NULL,
    FileID INT NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Price DECIMAL(4,2) NOT NULL,
    FOREIGN KEY (FileID) REFERENCES KaraokeFiles(FileID)
);

INSERT INTO Contributor VALUES 
('Katy Perry');

INSERT INTO Song VALUES 
(1, 'Bohemian Rhapsody', 'Rock', 6.00, 'Queen'),
(3, 'Firework',  'Pop', 3.54, 'Katy Perry'),
(4, 'Roar', 'Pop', 3.42, 'Katy Perry'),
(5, 'Dark Horse', 'Pop', 3.35, 'Katy Perry'),
(6, 'California Gurls', 'Pop', 3.54, 'Katy Perry'),
(7, 'Teenage Dream', 'Pop', 3.47, 'Katy Perry'),
(8, 'Shape of You', 'pop', 3.50, 'Ed Sheeran'),
(9, 'Thinking Out Loud', 'pop', 4.41, 'Ed Sheeran'),
(10, 'Perfect', 'pop', 4.23, 'Ed Sheeran'),
(11, 'Castle on the Hill', 'pop', 4.21, 'Ed Sheeran'),
(12, 'Con Calma', 'pop', 4.37, 'Daddy Yankee'),
(13, 'Love Yourself', 'pop', 3.50, "Justin Bieber"),
(14, 'Sorry', 'pop', 3.20, 'Justin Bieber'),
(15, 'What Do You Mean?', 'pop', 3.26, 'Justin Bieber'),
(16, 'Despacito', 'pop', 3.47, 'Luis Fonsi'),
(17, 'Echame La Culpa', 'pop', 3.07, 'Luis Fonsi'),
(18, 'No Me Doy Por Vencido', 'pop', 3.57, 'Luis Fonsi'),
(19, 'Imposible', 'pop', 3.17, 'Luis Fonsi'),
(20, 'Calypso', 'pop', 3.23, 'Luis Fonsi');

INSERT INTO KaraokeFiles VALUES 
(1, 'Firework', 3),
(2, 'Roar', 4),
(3, 'Dark Horse', 5),
(4, 'California Gurls', 6),
(5, 'Teenage Dream', 7),
(6, 'Shape of You', 8),
(7, 'Thinking Out Loud', 9),
(8, 'Perfect', 10),
(9, 'Castle on the Hill', 11),
(10, 'Con Calma', 12),
(11, 'Love Yourself', 13),
(12, 'Sorry', 14),
(13, 'What Do You Mean?', 15),
(14, 'Despacito', 16),
(15, 'Echame La Culpa', 17),
(16, 'No Me Doy Por Vencido', 18),
(17, 'Imposible', 19),
(18, 'Calypso', 20);

