<?php

function getNotesByContact($conn, $contactId)
{
    echo "<div class='notes-container'>";
    echo '<h3><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg> Notes</h3>';
    echo '<hr>';
    $sql = "SELECT * FROM notes WHERE contact_id = :contactId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':contactId', $contactId);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='comment-box'>";

        $user_id = $row['created_by'];
        $user_query = "SELECT * FROM users WHERE id = :user_id";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bindParam(':user_id', $user_id);
        $user_stmt->execute();
        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "<strong>" . $user['firstname'] . ' ' . $user['lastname'] . "</strong><br>";
        } else {
            echo "<strong>User Not Found</strong><br>";
        }

        echo "<span class='comment'>" . $row['comment'] . "</span><br>";

        $timestamp = strtotime($row['created_at']);
        if ($timestamp !== false) {
            $universal_date = date("Y-m-d H:i:s", $timestamp);
            $formatted_date = date("F j, Y \a\\t g:i a", strtotime($universal_date));
            echo "<span class='date'>" . $formatted_date . "</span><br><br>";
        } else {
            echo "Invalid date format";
        }

        echo "</div>";
    }

    echo "</div>";
    
}



function setNotes($conn)
{
    if (isset($_POST['noteSubmit'])) {
        $contact_id = filter_var($_POST['contact_id'], FILTER_VALIDATE_INT); // Sanitize contact_id as an integer
        $created_at = $_POST['created_at']; 
        $created_by = filter_var($_POST['created_by'], FILTER_SANITIZE_STRING);
        $note = filter_var($_POST['note'], FILTER_SANITIZE_STRING);

        $sql = "INSERT INTO notes (contact_id, created_at, created_by, comment) 
                VALUES (:contact_id, :created_at, :created_by, :note)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $created_by, PDO::PARAM_STR);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);

        $stmt->execute();
    }
}

?>