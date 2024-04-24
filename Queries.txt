Queries: 


SELECT Song.SongID, Song.SongName, Artist.ArtistName
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID;



SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID;


SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID;


SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, SongContributor.ContributorID
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
JOIN SongContributor ON Song.SongID = SongContributor.SongID;


SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, Contributor.ContributorName
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
JOIN SongContributor ON Song.SongID = SongContributor.SongID
JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID;



SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, Contributor.ContributorName, Role.RoleName
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
JOIN SongContributor ON Song.SongID = SongContributor.SongID
JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
JOIN Role ON Contributor.RoleID = Role.RoleID;
