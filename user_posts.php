<?php
require_once("connection.php"); // Include the connection file
session_start(); // Start or resume session

// Check if the user is logged in
if(!isset($_SESSION['user_id'])) {
    echo "You must log in to view your posts.";
    exit;
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID

// Query to fetch all posts by the logged-in user
$sql = "SELECT * FROM post WHERE user_id = '$userId'";
$result = mysqli_query($con, $sql);

// Check if there are any posts
if (mysqli_num_rows($result) > 0) {
    echo "<h1>Your Posts</h1>";

    // Loop through and display each post
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<h3>Bio:</h3>";
        echo "<p>" . htmlspecialchars($row['bio']) . "</p>"; // Use htmlspecialchars to prevent XSS
        echo "<h3>Picture:</h3>";
        echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='User Picture' style='max-width: 300px; max-height: 300px;'>";
        echo "</div>";
    }
} else {
    echo "No posts found.";
}

// Close the database connection
mysqli_close($con);
?>
