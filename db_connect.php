<?php
$username = "z1950234";
$password = "1999Jan09";

try { 
    $dsn = "mysql:host=courses;dbname=z1950234";
    $pdo = new PDO($dsn, $username, $password);
}
catch(PDOexception $e) { 
    echo "Connection to database failed: " . $e->getMessage();
}
?>
