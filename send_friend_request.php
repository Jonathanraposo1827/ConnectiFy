<?php 
require_once("connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to send a friend request.";
    exit;
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $friend_id = $_POST['friend_id']; // Get friend's user ID from form
    $user_id = $_SESSION['user_id']; // Get current user's ID from session

    // Ensure friend_id exists in user_login table
    $check_friend_query = "SELECT id FROM user_login WHERE id = '$friend_id'";
    $result = mysqli_query($con, $check_friend_query);
    
    if (mysqli_num_rows($result) > 0) {
        // Friend ID exists, proceed to insert friend request
        $sql = "INSERT INTO friends_list (user_id, friend_id, status) VALUES ('$user_id', '$friend_id', 'pending')";

        if (mysqli_query($con, $sql))
         {
            // echo "Friend request sent!";
            header("Location:choose_frnd_to_Sent _req.php");
        } 
        else
        {
            echo "Error inserting friend request: " . mysqli_error($con);
        }
    } else {
        echo "Error: Invalid friend ID.";
    }
}
mysqli_close($con);
?>
