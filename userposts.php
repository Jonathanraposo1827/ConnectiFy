<?php
require_once("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view and manage your posts.";
    exit;
}

$user_id = $_SESSION['user_id']; // Logged-in user's ID

// Fetch the user's posts from the database
$post_sql = "SELECT * FROM post WHERE user_id = '$user_id'";
$post_result = mysqli_query($con, $post_sql);

if (mysqli_num_rows($post_result) > 0) {
    echo "<h1>Your Posts</h1>";
    while ($post = mysqli_fetch_assoc($post_result)) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<h3>Bio:</h3>";
        echo "<p>" . htmlspecialchars($post['bio']) . "</p>";
        echo "<h3>Picture:</h3>";
        echo "<img src='" . htmlspecialchars($post['picture']) . "' alt='Post Picture' style='max-width: 300px; max-height: 300px;'>";

        // Add a form with a delete button for each post
        echo "<form action='delete_post.php' method='POST'>";
        echo "<input type='hidden' name='post_id' value='" . $post['post_id'] . "'>";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";

        echo "</div>";
    }
} else {
    echo "You have no posts.";
}

mysqli_close($con);
