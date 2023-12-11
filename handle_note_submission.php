<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dolphin_crm';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contactId = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
  
    $user_id = $_SESSION['id'];
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
    date_default_timezone_set('America/Jamaica');

    $created_at = date('Y-m-d h:i A');

    try {
        $sql = "INSERT INTO notes (contact_id, created_by, comment, created_at) VALUES (:contactId, :user_id, :note, :created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':contactId', $contactId);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->execute();
        echo "Note added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    exit();
}
?>