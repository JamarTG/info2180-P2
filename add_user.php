<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    session_start();
    /*if ($_SESSION["role"] === "Admin") {  */
        echo '
    <div class="add_user-container">
        <div class="sidebar">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">New Contact</a></li>
                <li id="user"><a href="">Users</a></li>
                <li><a href="">Logout</a></li>
            </ul>
        </div>
        
        <div class="new-user">
            <h1>Add User</h1>

            <form action="process_user.php" method="post">
                <div class="new-user-form">
                    <div>
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" required><br><br>
                    </div>
                    <div>
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" required><br><br>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br><br>
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required><br><br>
                    </div>
                    <div>
                        <label for="role">Role:</label>
                        <select id="role" name="role">
                            <option value="member">Member</option>
                            <option value="admin">Admin</option>
                        </select><br><br>
                    </div>
                </div>
                

                <input id="sub" type="submit" value="Add User">
        </div>
    </div>
            ';
        
    /*} else {
        echo `<p>Only admins can add users</p>`;
    } */
    ?>
    </form>

</body>

</html>