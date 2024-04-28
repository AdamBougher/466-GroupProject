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
}
