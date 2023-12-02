<?php

session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dolphin_crm';

$message = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid username or password";
        }
    }
} catch (PDOException $e) {
    $message = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
</head>

<?php include "header.php" ?>

<body>
    <h2>Login</h2>
    <div class="login-container">
        <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-container">
                <label for="email">Email:</label>
                <input class="form-control" type="text" id="email" name="email" required />
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input class="form-control" type="password" id="password" name="password" required />
            </div>
            <div class="input-container">
                <input class="form-control" type="submit" value="Login" />
            </div>
        </form>
    </div>
    <?php if ($message) { ?>
        <p>
            <?php echo $message; ?>
        </p>
    <?php } ?>
</body>

</html>