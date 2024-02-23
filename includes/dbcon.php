<?php

$db = 'boat';
$host  = 'localhost';
$dbusername = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host; dbname=$db;", $dbusername, $password);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
