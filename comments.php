<?php

function getNotes($conn){
    $sql = "SELECT * FROM notes";
    $stmt = $conn->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<div class='comment-box'>";
            echo $row['created_by'] . "<br>";
            echo $row['comment'] . "<br>"; 
            echo $row['created_at'] . "<br><br>";
        echo "</div>";
    }
}

function setNotes($conn) {
    if (isset($_POST['noteSubmit'])){
        $contact_id = $_POST['contact_id'];
        $created_at = $_POST['created_at'];
        $created_by = $_POST['created_by'];
        $note = $_POST['note'];

        $sql = "INSERT INTO notes (contact_id, created_at, created_by, comment) 
                VALUES (:contact_id, :created_at, :created_by, :note)";
                
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':contact_id', $contact_id);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':note', $note);

        $stmt->execute();
    }
}
?>
