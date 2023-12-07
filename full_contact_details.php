<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <script src="https://kit.fontawesome.com/659e894db8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="full_contact_details.css">
    <?php include "header.php" ?>
</head>

    
<body>
    <div class="container">

        <div id="sidebar">
            <ul>
                <li><img class="icon sidebar-link" src="assets/house-solid.svg" /><a href="dashboard.php">Home</a></li>
                <li><img class="icon sidebar-link" src="assets/address-book-regular.svg"><a href="#"
                        class="sidebar-link" data-component="new_contact.php">New Contact</a></li>
                <li><img class="icon sidebar-link" src="assets/users-solid.svg"><a href="#" class="sidebar-link"
                        data-component="view_users.php">Users</a></li>
                <hr>
                <li><img class="icon sidebar-link" src="assets/right-from-bracket-solid.svg"><a
                        href="logout.php">Logout</a></li>

            </ul>
        </div>
        <main id="main-content">


            <?php

                session_start();

                if ($_SESSION['role'] !== 'Admin') {
                    echo "Access denied. Only admins can view users.";
                    exit();
                }

                $host = 'localhost';
                $username = 'root';
                $password = '';
                $dbname = 'dolphin_crm';

                $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);


                // Get the contact ID from the URL
                $contactId = $_GET['id'];

                // Get the contact details from the database
                $sql = "SELECT * FROM contacts WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$contactId]);
                $contact = $stmt->fetch(PDO::FETCH_ASSOC);
                          
            ?>


            <div class="contact-details">

                <div class="contact-header">
                    <img src="profileicon.jpg" alt="profile picture">
                    <table>
                    <tr>    
                    <h3><?php echo $contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']; ?></h3>
                    </tr>
                    <tr>
                    <p>Created on: <?php echo date('d/m/Y h:i A', strtotime($contact['created_at'])); ?> by <?php echo $contact['assigned_to']; ?> </p>
                    </tr>
                    <tr>
                    <p>Updated on: <?php echo date('d/m/Y h:i A', strtotime($contact['updated_at'])); ?></p>
                    </tr>
                    </table>
                </div>

            

                <div class="buttons">
                    <button type="button" class="assign-to-me">Assign to me</button>


                    <?php if ($contact['type'] === 'Support'): ?>
                        <button onclick="switchToSalesLead(<?php echo $contactId; ?>)">Switch to Sales Lead</button>
                    <?php else: ?>
                        <button onclick="switchToSupport(<?php echo $contactId; ?>)">Switch to Support</button>
                    <?php endif; ?>
                </div>
            


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

            </div>    
        </main>
       



        <script>
            function switchToSalesLead(id) {
                // Make an AJAX request to switch the contact type to Sales Lead
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/contacts/switch-to-sales-lead.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + id);

                // Reload the page after the request is complete
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        alert('An error occurred while switching the contact type to Sales Lead.');
                    }
                };
            }

            function switchToSupport(id) {
                // Make an AJAX request to switch the contact type to Support
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/contacts/switch-to-support.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + id);

                // Reload the page after the request is complete
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        alert('An error occurred while switching the contact type to Support.');
                    }
                };
            }

        </script>

</body>
</html>
