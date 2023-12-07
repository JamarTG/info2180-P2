<?php

function getNotes($conn){
    $sql = "SELECT * FROM notes";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo"<div class=comment-box>";
            echo $row['created_by']."<br>";
            echo $row['comment']."<br>"; 
            echo $row['created_at']."<br><br>";
        echo"<div>";
    }
    
    
}


function setNotes($conn) {
    if (isset($_POST['noteSubmit'])){
        $contact_id = $_POST['contact_id'];
        $created_at = $_POST['created_at'];
        $created_by = $_POST['created_by'];
        $note = $_POST['note'];

        $sql1="INSERT INTO schema (contact_id, created_at, created_by, comment) 
        VALUES ('$contact_id', '$created_at', '$created_by', '$note')";

        $sql="INSERT INTO notes (comment, created_at) 
        VALUES ('$note', '$created_at')";

        $result = $conn->query($sql);
    }
    
}
