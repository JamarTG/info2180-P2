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

if ($_SESSION['role'] !== 'Admin') {
    $_SESSION['message'] = "Access denied. Only admins can view users.";
    $_SESSION['message_type'] = "error";
    header("Location: dashboard.php");
    exit();
}

$contactId = $_GET['id'];

$sql = "SELECT * FROM contacts WHERE id = :contactId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':contactId', $contactId);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Details</title>
    <script src="https://kit.fontawesome.com/659e894db8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="full_contact_details2.css">
    <?php include "header.php" ?>
</head>
<body>
    <div class="container">
        <main id="main-content">
            <div class="contact-details">
                
                <div class="contact-header">
                    <img src="profileicon.jpg" alt="profile picture">
                    <h3><?php echo $contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']; ?></h3>
                    <p>Created on: <?php echo date('d/m/Y h:i A', strtotime($contact['created_at'])); ?> by <?php echo $contact['assigned_to']; ?> </p>
                    <p>Updated on: <?php echo date('d/m/Y h:i A', strtotime($contact['updated_at'])); ?></p>
                </div>

             
                <div class="buttons">
                    <button type="button" class="assign-to-me">Assign to me</button>
                    <?php if ($contact['type'] === 'Support'): ?>
                        <button onclick="switchToSalesLead(<?php echo $contactId; ?>)">Switch to Sales Lead</button>
                    <?php else: ?>
                        <button onclick="switchToSupport(<?php echo $contactId; ?>)">Switch to Support</button>
                    <?php endif; ?>
                </div>

                <!-- Display contact details in a table -->
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Email</th>
                            <th>Telephone</th>
                        </tr>
                        <tr>
                            <td><?php echo $contact['email']; ?></td>
                            <td><?php echo $contact['telephone']; ?></td>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <th>Assigned To</th>
                        </tr>
                        <tr>
                            <td><?php echo $contact['company']; ?></td>
                            <td><?php echo $contact['assigned_to']; ?></td>
                        </tr>
                    </table>
                </div>

                <?php
                // Display existing notes or comments
                getNotes($conn);

                // Form for adding a new note
                echo "<form class='notes' method='POST' action=''>
                        <input type='hidden' name='contact_id' value='$contactId'>
                        <input type='hidden' name='created_at' value='" . date('Y-m-d h:i A') . "'>
                        <input type='hidden' name='created_by' value='16'>
                        <div class='text-boxx'>
                            <textarea name='note' placeholder='Enter details here '></textarea><br>
                        </div>
                        <input name='noteSubmit' type='submit' id='namesubmit' value='Add Note'>
                    </form>";
                ?>
            </div>
        </main>
    </div>

    <script>
        function switchToSalesLead(id) {
         
        }

        function switchToSupport(id) {
        
        }
    </script>
</body>
</html>
