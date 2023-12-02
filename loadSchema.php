<?php


$host = 'localhost';
$username = 'root';
$password = '';
$databasename = 'dolphin_crm';

try {
    $conn = new PDO("mysql:host=$host;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("CREATE DATABASE IF NOT EXISTS $databasename");

    $conn = new PDO("mysql:host=$host;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $schema = file_get_contents('schema.sql');
    $conn->exec($schema);

    echo "Tables created successfully\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>