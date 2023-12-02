<!DOCTYPE html>
<html>

<head>
    <title>View Users</title>
</head>

<body>

    <h1>View Users</h1>

    <?php

    session_start();

    if ($_SESSION['role'] !== 'Admin') {
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

        $stmt = $conn->query("SELECT * FROM Users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if (count($users) > 0) {
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th></tr>';

            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . $user['id'] . '</td>';
                echo '<td>' . $user['firstname'] . '</td>';
                echo '<td>' . $user['lastname'] . '</td>';
                echo '<td>' . $user['email'] . '</td>';
                echo '<td>' . $user['role'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No users found.';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

</body>

</html>