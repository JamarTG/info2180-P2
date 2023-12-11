<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$databasename = 'dolphin_crm';

$message = '';

try {
    $conn = new PDO("mysql:host=$host;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("CREATE DATABASE IF NOT EXISTS $databasename");

    $conn = new PDO("mysql:host=$host;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $schema = file_get_contents('schema.sql');
    $conn->exec($schema);

    $message = "Tables created successfully";
} catch (PDOException $e) {
 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$databasename", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
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
    } catch (PDOException $e) {
        $message = "Login failed: " . $e->getMessage();
    }
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

<body>

<?php include "header.php" ?>

    <div id="form-container">
        <h2 class="login-h2">Login</h2>

        <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="email"></label>
                <input type="text" id="email" name="email" placeholder="Email Address" required />
            </div>
            <div>
                <label for="password"></label>
                <input type="password" id="password" name="password" placeholder="Password" required />
            </div>
            <div>
                <input type="submit" value="Login" />
            </div>
            <hr>
            <br> <br>

            <?php if ($message) { ?>
                <p>
                    <?php echo $message; ?>
                </p>
            <?php } ?>

            <footer>
                <p>Copyright &copy; Dolphin CRM</p>
            </footer>
        </form>
    </div>
</body>

</html>