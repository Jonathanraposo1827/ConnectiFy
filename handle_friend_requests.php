<?php
require_once("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
 {
    $request_id = $_POST['request_id'];

    if (isset($_POST['accept']))
     {
        $sql = "UPDATE friends_list SET status = 'accepted' WHERE id = '$request_id'";
    } 
    elseif (isset($_POST['reject']))
     {
        $sql = "UPDATE friends_list SET status = 'rejected' WHERE id = '$request_id'";
    }

    if (mysqli_query($con, $sql))
     {
        echo "Request updated successfully!";
    } 
    else
     {
        echo "Error updating request: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
