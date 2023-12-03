<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <script src="https://kit.fontawesome.com/659e894db8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard.css">
    <?php include "header.php" ?>
</head>


<body>

    <div class="container">
        <div id="sidebar">
            <ul>
                <li><img class="icon sidebar-link" src="assets/house-solid.svg" /><a href="dashboard.php">Home</a></li>
                <li><img class="icon sidebar-link" src="assets/address-book-regular.svg"><a href="#"
                        class="sidebar-link" data-component="new_contact.php">New Contact</a></li>
                <li><img class="icon sidebar-link" src="assets/users-solid.svg"><a href="#" class="sidebar-link"
                        data-component="view_users.php">Users</a></li>
                <hr>
                <li><img class="icon sidebar-link" src="assets/right-from-bracket-solid.svg"><a
                        href="logout.php">Logout</a></li>

            </ul>
        </div>

        <main id="main-content">
            <div>
                <button onclick="window.location.href = 'dashboard.php?filter=All'">All</button>
                <button onclick="window.location.href = 'dashboard.php?filter=SalesLead'">Sales Lead</button>
                <button onclick="window.location.href = 'dashboard.php?filter=Support'">Support</button>
                <button onclick="window.location.href = 'dashboard.php?filter=Assigned'">Assigned</button>
            </div>


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

            $filtered = isset($_GET["filter"]) ? $_GET["filter"] : "All";

            if ($filtered == "All") {
                echo all_contacts($conn);
            } else if ($filtered == "SalesLead") {
                $lookup = "Sales Lead";
                echo only_type($conn, $lookup);
            } else if ($filtered == "Support") {
                $lookup = "Support";
                echo only_type($conn, $lookup);
            } else if ($filtered == "Assigned") {
                echo assigned_to($conn);
            } else {
                echo "Invalid filter parameter";
            }

            function all_contacts($conn)
            {
                $stmt = $conn->query("SELECT * FROM Contacts");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<table class='styled-table'>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Company</th>";
                echo "<th>Type</th>";
                echo "<th></th>";
                echo "</tr>";

                foreach ($results as $row) {
                    $name = $row["title"] . ' ' . $row["firstname"] . ' ' . $row["lastname"];
                    echo "<tr>";
                    echo "<td><b>" . $name . "</b></td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["company"] . "</td>";
                    $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
                    echo "<td class='$typeClass'><span class='type-label'>" . ucwords($row["type"]) . "</span></td>";

                    echo "<td>" . "<a href='#'>View</a>" . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

            function only_type($conn, $lookup)
            {
                $stmt = $conn->query("SELECT * FROM Contacts WHERE type = '$lookup'");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<table class='styled-table'>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Company</th>";
                echo "<th>Type</th>";
                echo "<th></th>";
                echo "</tr>";

                foreach ($results as $row) {
                    $name = $row["title"] . ' ' . $row["firstname"] . ' ' . $row["lastname"];
                    echo "<tr>";
                    echo "<td><b>" . $name . "</b></td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["company"] . "</td>";
                    $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
                    echo "<td class='$typeClass'><span class='type-label'>" . ucwords($row["type"]) . "</span></td>";

                    echo "<td>" . "<a href='#'>View</a>" . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

            function assigned_to($conn)
            {
                $current_id = $_SESSION['id'];

                $stmt = $conn->query("SELECT * FROM Contacts WHERE assigned_to = '$current_id'");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<table class='styled-table'>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Company</th>";
                echo "<th>Type</th>";
                echo "<th></th>";
                echo "</tr>";

                foreach ($results as $row) {
                    $name = $row["title"] . ' ' . $row["firstname"] . ' ' . $row["lastname"];
                    echo "<tr>";
                    echo "<td><b>" . $name . "</b></td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["company"] . "</td>";
                    $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
                    echo "<td class='$typeClass'><span class='type-label'>" . ucwords($row["type"]) . "</span></td>";
                    echo "<td>" . "<a href='#'>View</a>" . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
            ?>


        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebarLinks = document.querySelectorAll('.sidebar-link');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const component = this.getAttribute('data-component');
                        loadComponent(component);
                    });
                });



                function loadComponent(component) {
                    fetch(component)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(data => {
                            document.getElementById('main-content').innerHTML = data;
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                }
            });
        </script>
    </div>



</body>

</html>