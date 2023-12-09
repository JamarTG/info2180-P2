<?php
session_start();

include 'comments.php';

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

$contactId = $_GET['id'];

$sql = "SELECT * FROM contacts WHERE id = :contactId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':contactId', $contactId);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_ASSOC);


$assignedUserId = $contact['assigned_to'];
$userQuery = "SELECT * FROM users WHERE id = :userId";
$userStmt = $conn->prepare($userQuery);
$userStmt->bindParam(':userId', $assignedUserId);
$userStmt->execute();
$assignedUser = $userStmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Contact Details</title>

    <link rel="stylesheet" href="full_contact_details.css">
</head>

<body>
    <div class="container">
        <main id="all-content">
            <div class="row-1">

                <div class="contact-header">
                    <svg id="user" xmlns="http://www.w3.org/2000/svg" height="30" width="30"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path
                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                    </svg>
                    <div>
                        <h2>
                            <?php echo ucwords($contact['title']) . '. ' . $contact['firstname'] . ' ' . $contact['lastname']; ?>
                        </h2>
                        <p>Created on:
                            <?php echo date('d/m/Y h:i A', strtotime($contact['created_at'])); ?> by
                            <?php echo $contact['assigned_to']; ?>
                        </p>
                        <p>Updated on:
                            <?php echo date('d/m/Y h:i A', strtotime($contact['updated_at'])); ?>
                        </p>
                    </div>

                </div>


                <div class="buttons">
                    <button type="button" class="assignBtn">Assign to me</button>

                    <?php if ($contact['type'] === 'Support'): ?>
                        <button class="switchBtn" onclick="switchToSalesLead(<?php echo $contactId; ?>)">Switch to Sales
                            Lead</button>
                    <?php else: ?>
                        <button class="switchBtn" onclick="switchToSupport(<?php echo $contactId; ?>)">Switch to
                            Support</button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid-section">
                <div class="grid-item">
                    <strong>Email:</strong>
                    <span>
                        <?php echo isset($contact['email']) ? $contact['email'] : ''; ?>
                    </span>
                </div>
                <div class="grid-item">
                    <strong>Telephone:</strong>
                    <span>
                        <?php echo isset($contact['telephone']) ? $contact['telephone'] : ''; ?>
                    </span>
                </div>
                <div class="grid-item">
                    <strong>Company:</strong>
                    <span>
                        <?php echo isset($contact['company']) ? $contact['company'] : ''; ?>
                    </span>
                </div>
                <div class="grid-item">
                    <strong>Assigned To:</strong>
                    <span>
                        <?php echo ($assignedUser) ? $assignedUser['firstname'] . ' ' . $assignedUser['lastname'] : 'Unassigned' ?>
                    </span>
                </div>
            </div>

            <?php
            getNotesByContact($conn, $contactId);
            ?>

            <form class='notes' method='POST' action=''>
                <input type='hidden' name='contact_id' value='<?php echo $contactId; ?>'>
                <input type='hidden' name='created_at' value='<?php echo date('Y-m-d h:i A'); ?>'>
                <input type='hidden' name='created_by' value='<?php echo $_SESSION['id']; ?>'>
                <textarea name='note' placeholder='Enter details here'></textarea><br>
                <button name='noteSubmit' type='submit' id='namesubmit'>Add Note</button>
            </form>

        </main>

    </div>


</body>

</html>