<!DOCTYPE html>
<html>
<head>
    <title>New Contact Page</title>
</head>
<body>
    <h1>New Contact Page</h1>

    <div>
        <?php
        if (isset($_GET['userid'])) {
            $number = $_GET['userid'];
            echo "<p>The number passed is: $number</p>";
        } else {
            echo "<p>No number passed.</p>";
        }
        ?>
    </div>
</body>
</html>
