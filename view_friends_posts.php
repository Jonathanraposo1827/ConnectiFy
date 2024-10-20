<?php
require_once("connection.php"); 
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view friends' posts.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $friend_id = $_POST['friend_id'];  // Get the friend's ID from the form submission

    // Query to fetch all posts by the selected friend
    $post_sql = "SELECT * FROM post WHERE user_id = '$friend_id'";
    $post_result = mysqli_query($con, $post_sql);

    // Check if the friend has any posts
    if (mysqli_num_rows($post_result) > 0) 
    {
        echo "<h1>Posts by Your Friend</h1>";
        
        // Loop through and display each post
        while ($post = mysqli_fetch_assoc($post_result))
         {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<h3>Bio:</h3>";
            echo "<p>" . htmlspecialchars($post['bio']) . "</p>";
            echo "<h3>Picture:</h3>";
            echo "<img src='" . htmlspecialchars($post['picture']) . "' alt='Post Picture' style='max-width: 300px; max-height: 300px;'>";
            echo "</div>";
        }
    } 
    else
    {
        echo "This friend has not posted anything.";
    }
}

mysqli_close($con);
?>
