<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="
https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css
" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    <?php include "header.php" ?>
</head>


<body>

    <div class="container">
        <div id="sidebar">
            <ul>
                <li><img class="icon sidebar-link" src="assets/house-solid.svg" /><a href="dashboard.php">Home</a></li>
                <li>
                    <img class="icon sidebar-link" src="assets/address-book-regular.svg">
                    <a href="#" class="sidebar-link" data-component="new_contact.php">New Contact</a>
                </li>

                <li><img class="icon sidebar-link" src="assets/users-solid.svg"><a href="#" class="sidebar-link"
                        data-component="view_users.php">Users</a></li>
                <hr>
                <li><img class="icon sidebar-link" src="assets/right-from-bracket-solid.svg"><a
                        href="logout.php">Logout</a></li>

            </ul>
        </div>



        <main id="main-content">
            <div class="header">
                <h2>Dashboard</h2>
                <a href="dashboard.php?component=new_contact.php" class="add-contact-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="white" height="16" width="14"
                        viewBox="0 0 448 512">
                        <path
                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                    </svg>Add Contact</a>
            </div>


            <div class="content-container">
                <div id="tab">
                    <b><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                            <path
                                d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                        </svg></i>Filter By</b>
                    <a class="tab-link" onclick="window.location.href = 'dashboard.php?filter=All'">All</a>
                    <a class="tab-link" onclick="window.location.href = 'dashboard.php?filter=SalesLead'">Sales Lead</a>
                    <a class="tab-link" onclick="window.location.href = 'dashboard.php?filter=Support'">Support</a>
                    <a class="tab-link" onclick="window.location.href = 'dashboard.php?filter=Assigned'">Assigned</a>
                </div>

                <?php
                // session_start();

                // if($_SESSION['role'] !== 'Admin') {
                //     echo "Access denied. Only admins can view users.";
                //     exit();
                // }

                $host = 'localhost';
                $username = 'root';
                $password = '';
                $dbname = 'dolphin_crm';

                $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

                $filtered = isset($_GET["filter"]) ? $_GET["filter"] : "All";

                if($filtered == "All") {
                    echo all_contacts($conn);
                } else if($filtered == "SalesLead") {
                    $lookup = "Sales Lead";
                    echo only_type($conn, $lookup);
                } else if($filtered == "Support") {
                    $lookup = "Support";
                    echo only_type($conn, $lookup);
                } else if($filtered == "Assigned") {
                    echo assigned_to($conn);
                } else {
                    echo "Invalid filter parameter";
                }

                function all_contacts($conn) {
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

                    foreach($results as $row) {
                        $name = ucwords($row["title"]).'. '.ucwords($row["firstname"]).' '.ucwords($row["lastname"]);
                        echo "<tr>";
                        echo "<td class='name-row'><b>".$name."</b></td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["company"]."</td>";
                        $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
                        echo "<td class='$typeClass'><span class='type-label'>".ucwords($row["type"])."</span></td>";

                        echo "<td>"."<a class='view-link' href='#'>View</a>"."</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }

                function only_type($conn, $lookup) {
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

                    foreach($results as $row) {
                        $name = $row["title"].' '.$row["firstname"].' '.$row["lastname"];
                        echo "<tr>";
                        echo "<td class='name-row'><b>".$name."</b></td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["company"]."</td>";
                        $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
                        echo "<td class='$typeClass'><span class='type-label'>".ucwords($row["type"])."</span></td>";

                        echo "<td>"."<a class='view-link' href='#'>View</a>"."</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }

                function assigned_to($conn) {
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

                    foreach($results as $row) {
                        $name = $row["title"].' '.$row["firstname"].' '.$row["lastname"];
                        echo "<tr>";
                        echo "<td class='name-row'><b>".$name."</b></td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["company"]."</td>";
                        $typeClass = strtolower(str_replace(' ', '-', $row["type"]));
                        echo "<td class='$typeClass'><span class='type-label'>".ucwords($row["type"])."</span></td>";
                        echo "<td>"."<a class='view-link' href='#'>View</a>"."</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }
                ?>


        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebarLinks = document.querySelectorAll('.sidebar-link');

                const urlParams = new URLSearchParams(window.location.search);
                const requestedComponent = urlParams.get('component');

                if (requestedComponent) {
                    loadComponent(requestedComponent);
                }

                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const component = this.getAttribute('data-component');
                        loadComponent(component);
                    });
                });



                function loadComponent(component) {

                    const urlParams = new URLSearchParams(window.location.search);
                    const requestedComponent = urlParams.get('component');

                    if (requestedComponent) {
                        component = requestedComponent;
                        urlParams.delete('component');
                        const newUrl = window.location.pathname + '?' + urlParams.toString();
                        history.replaceState({}, '', newUrl);
                    }


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
    </div>



</body>

</html>