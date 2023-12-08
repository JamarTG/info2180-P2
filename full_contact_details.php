<?php
session_start();

include 'comments.php';

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dolphin_crm';

$conn = mysqli_connect($host, $username, $password, $dbname);


if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Contact Page</title>
    <link rel="stylesheet" type="text/css" href="full_contact_details.css" />
</head>

<body>
    <div class=entire>
        <div class=hs>
            <img src="note.png" alt="notes-icon">
            <h3>Notes</h3>
        </div>

        <?php

        getNotes($conn);

        echo "<form class=notes method='POST' action='".setNotes($conn)."'>

                

            <div class = comments>
                    <label>Add a note about </label><br>
                    <!--input type='hidden' name='id'-->
                    <input type='hidden' name='contact_id' value = '13'>
                    <input type='hidden' name='created_at' value='".date('Y-m-d h:i A')."'>
                    <input type='hidden' name='created_by' value='16'><br>
                    <!--input type='text' name='Notes'><br-->
                    <div class = text-boxx>
                        <textarea name='note' placeholder = 'Enter details here '></textarea><br>
                    </div>
                    <input name= 'noteSubmit' type= 'submit' id='namesubmit' value= 'Add Note'>
                    
                </div>
                
            </form>";



        ?>

    </div>
</body>

</html>