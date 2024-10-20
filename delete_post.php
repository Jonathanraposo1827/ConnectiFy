<?php
require_once("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) 
{
    echo "You must be logged in to delete posts.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $post_id = $_POST['post_id']; // Get the post ID to delete

    // Ensure the post belongs to the logged-in user
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM post WHERE post_id = '$post_id' AND user_id = '$user_id'";

    if (mysqli_query($con, $sql)) 
    {
        echo "Post deleted successfully!";
        header("Location: user_posts.php"); // Redirect back to the user's posts
    }
    else
    {
        echo "Error: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
