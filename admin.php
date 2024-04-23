<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="styles.css">

<head>
    <title>Admin</title>
    
</head>

<body>
    <form action="reset_db.php" method="post" onsubmit="showLoader()">
        <button type="submit" class="button">Rebuild Database</button>
    </form>

    <div id="loader" class="loader"></div>

    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
        }
    </script>

    <div>
        <a href="ind.php" class="back-button">Back</a>
    </div>

</body>

</html>
