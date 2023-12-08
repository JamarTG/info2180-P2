<?php
session_start();

if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can add users.";
    exit();
}

$host = 'localhost';
$username = 'root';
$db_password = '';
$databasename = 'dolphin_crm';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $password)) {
        echo "Ensure that the password has at least one number and letter (including a capital letter) and is at least 8 characters long";
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=$host;dbname=$databasename", $username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)");

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        $stmt->execute();

        echo "User added successfully!";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "Form not submitted.";
}
?>
