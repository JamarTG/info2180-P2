<?php
session_start();
$userId = $_SESSION['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dolphin_crm";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    $contactId = $data['id'];

    $stmt = $conn->prepare("UPDATE contacts SET assigned_to = :userId WHERE id = :contactId");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':contactId', $contactId);
    $stmt->execute();

    $response = array('success' => true);
    echo json_encode($response);
} catch (PDOException $e) {

    $response = array('success' => false, 'error' => $e->getMessage());
    echo json_encode($response);
}
$conn = null;
?>