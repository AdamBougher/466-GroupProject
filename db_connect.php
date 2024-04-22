<?php
$username = "z2012420";
$password = "2003Mar20";

try { 
    $dsn = "mysql:host=courses;dbname=z2012420";
    $pdo = new PDO($dsn, $username, $password);
}
catch(PDOexception $e) { 
    echo "Connection to database failed: " . $e->getMessage();
}
?>
