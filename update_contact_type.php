<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dolphin_crm";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        throw new Exception('No contact ID provided.');
    }

    $contactId = $data['id'];

    $stmt = $conn->prepare("SELECT type FROM contacts WHERE id = :contactId");
    $stmt->bindParam(':contactId', $contactId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentContactType = $row['type'];


    $newContactType = ($currentContactType === 'Support') ? 'SalesLead' : 'Support';


    $updateStmt = $conn->prepare("UPDATE contacts SET type = :newContactType WHERE id = :contactId");
    $updateStmt->bindParam(':newContactType', $newContactType);
    $updateStmt->bindParam(':contactId', $contactId);
    $updateStmt->execute();

    $response = array('success' => true, 'contactId' => $contactId, 'contactType' => $newContactType);
    echo json_encode($response);
} catch (PDOException $e) {

    $response = array('success' => false, 'error' => $e->getMessage());
    echo json_encode($response);
}

$conn = null;
?>