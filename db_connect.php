<?php
$username = "";
$password = "";

try { 
    $dsn = "mysql:host=courses;dbname=z1957141";
    $pdo = new PDO($dsn, $username, $password);
}
catch(PDOexception $e) { 
    echo "Connection to database failed: " . $e->getMessage();
}
?>
