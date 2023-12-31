<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dolphin_crm';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$filtered = isset($_GET["filter"]) ? $_GET["filter"] : "All";

if ($filtered == "All") {
    echo generateTable($conn, "SELECT * FROM Contacts");
} else if ($filtered == "SalesLead") {
    echo generateTable($conn, "SELECT * FROM Contacts WHERE type = 'SalesLead'");
} else if ($filtered == "Support") {
    echo generateTable($conn, "SELECT * FROM Contacts WHERE type = 'Support'");
} else if ($filtered == "Assigned") {
    if (isset($_SESSION['id'])) {
        $current_id = $_SESSION['id'];
        echo generateTable($conn, "SELECT * FROM Contacts WHERE assigned_to = '$current_id'");
    } else {
        echo "Session ID not set.";
    }
} else {
    echo "Invalid filter parameter";
}

function generateTable($conn, $query)
{
    $stmt = $conn->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tableHTML = "";

    $tableHTML = "";

    if (empty($results)) {
        $tableHTML .= "<p style='text-align: center; margin-top: 20px;'>No data available</p>";
        return $tableHTML;
    }

    $tableHTML .= "<table class='styled-table'>";
    $tableHTML .= "<tr>";
    $tableHTML .= "<th>Name</th>";
    $tableHTML .= "<th>Email</th>";
    $tableHTML .= "<th>Company</th>";
    $tableHTML .= "<th>Type</th>";
    $tableHTML .= "<th></th>";
    $tableHTML .= "</tr>";

    foreach ($results as $row) {
        $name = ucwords($row["title"]) . '. ' . ucwords($row["firstname"]) . ' ' . ucwords($row["lastname"]);
        $tableHTML .= "<tr>";
        $tableHTML .= "<td class='name-row'><b>" . $name . "</b></td>";
        $tableHTML .= "<td>" . $row["email"] . "</td>";
        $tableHTML .= "<td>" . $row["company"] . "</td>";
        $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
        $tableHTML .= "<td class='$typeClass'><span class='type-label'>" . ucwords($row["type"]) . "</span></td>";
        $tableHTML .= "<td>" . "<a id=" . $row["id"] . " class='view-link' href='#'>View</a>" . "</td>";
        $tableHTML .= "</tr>";
    }

    $tableHTML .= "</table>";
    return $tableHTML;
}
?>