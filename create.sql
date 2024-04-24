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
    SongID INT NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Price DECIMAL(4,2),
    FOREIGN KEY (SongID) REFERENCES Song(SongID)
);

CREATE TABLE PriorityQueue(
    QueueID INT PRIMARY KEY NOT NULL,
    FileID INT NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Price DECIMAL(4,2) NOT NULL,
    FOREIGN KEY (FileID) REFERENCES KaraokeFiles(FileID)
);