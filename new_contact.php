<!DOCTYPE html>
<html>
<head>
    <title>Add New Contact</title>
</head>
<body>

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

$assigned_to_query = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM users");
$assigned_to_options = $assigned_to_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $telephone = $_POST['telephone'];
    $type = $_POST['type'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $assigned_to = $_POST['assigned_to'];

    $stmt = $conn->prepare("INSERT INTO Contacts (title, firstname, lastname, telephone, type, email, company, assigned_to) 
                            VALUES (:title, :firstname, :lastname, :telephone, :type, :email, :company, :assigned_to)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':company', $company);
    $stmt->bindParam(':assigned_to', $assigned_to);

    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!-- Create the form for adding a new contact -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="title">Title:</label>
    <select name="title" id="title">
        <option value="mr">Mr</option>
        <option value="ms">Ms</option>
        <option value="mrs">Mrs</option>
    </select><br><br>
    
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname"><br><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname"><br><br>
    
    <label for="telephone">Telephone:</label>
    <input type="text" id="telephone" name="telephone"><br><br>
    
    <label for="type">Type:</label>
    <select name="type" id="type">
        <option value="Sales Lead">Sales Lead</option>
        <option value="Support">Support</option>
    </select><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    
    <label for="company">Company:</label>
    <input type="text" id="company" name="company"><br><br>
    
    <label for="assigned_to">Assigned To:</label>
    <select name="assigned_to" id="assigned_to">
        <?php foreach ($assigned_to_options as $option): ?>
            <option value="<?php echo $option['id']; ?>"><?php echo $option['fullname']; ?></option>
        <?php endforeach; ?>
    </select><br><br>
    
    <input type="submit" value="Add Contact">
</form>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Contact</title>
</head>
<body>

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

$assigned_to_query = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM users");
$assigned_to_options = $assigned_to_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $telephone = $_POST['telephone'];
    $type = $_POST['type'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $assigned_to = $_POST['assigned_to'];

    $stmt = $conn->prepare("INSERT INTO Contacts (title, firstname, lastname, telephone, type, email, company, assigned_to) 
                            VALUES (:title, :firstname, :lastname, :telephone, :type, :email, :company, :assigned_to)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':company', $company);
    $stmt->bindParam(':assigned_to', $assigned_to);

    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!-- Create the form for adding a new contact -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="title">Title:</label>
    <select name="title" id="title">
        <option value="mr">Mr</option>
        <option value="ms">Ms</option>
        <option value="mrs">Mrs</option>
    </select><br><br>
    
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname"><br><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname"><br><br>
    
    <label for="telephone">Telephone:</label>
    <input type="text" id="telephone" name="telephone"><br><br>
    
    <label for="type">Type:</label>
    <select name="type" id="type">
        <option value="Sales Lead">Sales Lead</option>
        <option value="Support">Support</option>
    </select><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    
    <label for="company">Company:</label>
    <input type="text" id="company" name="company"><br><br>
    
    <label for="assigned_to">Assigned To:</label>
    <select name="assigned_to" id="assigned_to">
        <?php foreach ($assigned_to_options as $option): ?>
            <option value="<?php echo $option['id']; ?>"><?php echo $option['fullname']; ?></option>
        <?php endforeach; ?>
    </select><br><br>
    
    <input type="submit" value="Add Contact">
</form>

</body>
</html>