<!DOCTYPE html>
<html>

<head>
    <title>View Users</title>
    <link rel="stylesheet" href="view_users.css">
</head>

<body>

    <div class="header">
        <h2>Users</h2>
        <a href="dashboard.php?component=add_user.php" class="add-user-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="16" width="14"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path
                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                    </svg>Add User</a>

    </div>


    <div class="content-container">
        <?php

        session_start();

        if($_SESSION['role'] !== 'Admin') {
            echo "Access denied. Only admins can view users.";
            exit();
        }

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $databasename = 'dolphin_crm';

        try {

            $conn = new PDO("mysql:host=$host;dbname=$databasename", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("SELECT id, firstname, lastname, email, role, created_at FROM Users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($users) > 0) {
                echo '<table border="1">';
                echo '<tr><th>Name</th><th>Email</th><th>Role</th><th>Created</th></tr>';

                foreach($users as $user) {
                    echo '<tr>';
                    echo '<td><strong>'.$user['firstname'].' '.$user['lastname'].'</strong></td>';
                    echo '<td>'.$user['email'].'</td>';
                    echo '<td>'.$user['role'].'</td>';
                    echo '<td>'.$user['created_at'].'</td>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo 'No users found.';
            }
        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
        ?>
    </div>

</body>

</html>