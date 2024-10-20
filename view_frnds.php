<?php
require_once("connection.php"); 
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your friends.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Query to fetch all accepted friends for the logged-in user
$sql = "SELECT * FROM friends_list WHERE (user_id = '$user_id' OR friend_id = '$user_id') AND status = 'accepted'";
$result = mysqli_query($con, $sql);

echo "<h1>Your Friends</h1>";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine the friend ID
        $friend_id = ($row['user_id'] == $user_id) ? $row['friend_id'] : $row['user_id'];

        // Fetch friend's name
        $friend_sql = "SELECT firstname, lastname FROM user_login WHERE id = '$friend_id'";
        $friend_result = mysqli_query($con, $friend_sql);
        $friend = mysqli_fetch_assoc($friend_result);

        // Display friend's name and "See Post" button
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<p>Friend: " . htmlspecialchars($friend['firstname']) . " " . htmlspecialchars($friend['lastname']) . "</p>";
        
        // Form with "See Post" button, sending the friend's ID to fetch posts
        echo "<form method='POST' action='view_friends_posts.php'>";
        echo "<input type='hidden' name='friend_id' value='$friend_id'>";  // Send friend's ID in hidden input
        echo "<button type='submit'>See Post</button>";  // Button to see friend's posts
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "You have no friends.";
}

mysqli_close($con);
?>
