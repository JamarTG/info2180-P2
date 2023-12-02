<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
</head>

<body>
    <?php
    session_start();
    if ($_SESSION["role"] === "Admin") {
        echo '
            
    <h1>Add User</h1>

    <form action="process_user.php" method="post">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="member">Member</option>
            <option value="admin">Admin</option>
        </select><br><br>
            
            <input type="submit" value="Add User">
            ';
    } else {
        echo `<p>Only admins can add users</p>`;
    }
    ?>
    </form>

</body>

</html>