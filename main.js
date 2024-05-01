// used in signup
function validateForm() {
    var userName = document.getElementById('userName').value;
    var song = document.getElementById('selectedSong').value;

    switch (true) {
        case (userName === 'Select a user...' && song === ''):
            alert('Please select a user and a song');
            return false;
        case (song === ''):
            alert('Please select a song');
            return false;
        case (userName === 'Select a user...'):
            alert('Please select a user');
            return false;
        default:
            return true;
    }
}

function showLoader() {
    document.getElementById('loader').style.display = 'block';
}

// used in signup
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

// used in search
/*function sortTable(n) {
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("searchTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
<<<<<<< HEAD
}*/

// good
/*function sortTable(n, tableId) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(tableId);
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}*/


function sortTable(n, tableId) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(tableId);
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (isNaN(x.innerHTML) || isNaN(y.innerHTML)) { // Compare as strings
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else { // Compare as numbers
                    if (Number(x.innerHTML) > Number(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            } else if (dir == "desc") {
                if (isNaN(x.innerHTML) || isNaN(y.innerHTML)) { // Compare as strings
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else { // Compare as numbers
                    if (Number(x.innerHTML) < Number(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}






// dj 
function selectQueue(clickedRow) {
    // Get both tables
    var normalQueueTable = document.getElementById('normalQueueTable');
    var priorityQueueTable = document.getElementById('priorityQueueTable');

    // Combine all rows from both tables into one array
    var allRows = Array.from(normalQueueTable.rows).concat(Array.from(priorityQueueTable.rows));

    // If the clicked row is already selected, unselect it
    if (clickedRow.classList.contains('selected')) {
        clickedRow.classList.remove('selected');
        return;
    }

    // Remove 'selected' class from all rows
    for (var i = 0; i < allRows.length; i++) {
        allRows[i].classList.remove('selected');
    }

    // Add 'selected' class to the clicked row
    clickedRow.classList.add('selected');
}



/*function addToPlaylist() {
    // Get the selected row
    var selectedRow = document.querySelector('.selected');

    // If no row is selected, do nothing
    if (!selectedRow) return;

    // Add the selected song to the playlist
    var songName = selectedRow.cells[1].textContent; // Song Name
    var artistName = selectedRow.cells[2].textContent; // Artist

    // Make a fetch request to the PHP script to add the song to the session playlist
    var formData = new URLSearchParams();
    formData.append('song', songName);
    formData.append('artist', artistName);

    fetch('add_to_playlist.php', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        // Refresh the page after the request is complete
        location.reload();
    });
}*/


function addToPlaylist() {
    // Get the selected row
    var selectedRow = document.querySelector('.selected');

    // If no row is selected, do nothing
    if (!selectedRow) return;

    // Add the selected song to the playlist
    var songName = selectedRow.cells[1].textContent; // Song Name
    var artistName = selectedRow.cells[2].textContent; // Artist
    var queueId = selectedRow.cells[0].textContent; // Queue ID

    // Make a fetch request to the PHP script to add the song to the session playlist
    var formData = new URLSearchParams();
    formData.append('song', songName);
    formData.append('artist', artistName);
    formData.append('queueId', queueId); // Add Queue ID to the request

    fetch('add_to_playlist.php', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        // Refresh the page after the request is complete
        location.reload();
    });
}

function nextSong() {
    // Send a request to next_song.php
    fetch('next_song.php', { method: 'POST' })
        .then(() => {
            // Refresh the page after the request is complete
            location.reload();
        });
}
