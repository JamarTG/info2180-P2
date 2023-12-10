<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
    <link rel="stylesheet" href="add_user.css" />
</head>

<body>
    <?php
    session_start();

    $validRoles = ['Member', 'Admin'];

    if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], $validRoles)) {
        header("Location: login.php");
        exit();
    }

    if ($_SESSION["role"] === "Admin") {
        ?>
        <h2>New User</h2>
        <div class="content-container">
            <div class="new-user">
                <form action="process_user.php" method="post">
                    <div class="new-user-form">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" placeholder="John" id="firstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" placeholder="Doe" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" placeholder="something@example.com" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role">
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="save-btn-container">
                        <input id="sub" type="submit" value="Save">
                    </div>

                </form>
            </div>
        </div>
        <?php
    } else {
        echo '<div class="content-container">';
        echo '<p>Only admins can add users</p>';
        echo '</div>';
    }
    ?>
</body>

</html>