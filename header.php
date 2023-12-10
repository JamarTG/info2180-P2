<?php

$validRoles = ['Member', 'Admin'];

if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], $validRoles)) {
    header("Location: login.php");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM</title>
    <link rel="stylesheet" href="header.css">
</head>

<body>
    <div class="header-container">
        <img id='dolphin-logo' src="dolphin_logo.png" alt="Dolphin-Logo">
        <header>
            <h1 class="d-h1">Dolphin CRM</h1>
        </header>
    </div>

</body>