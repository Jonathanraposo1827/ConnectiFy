<?php
require_once("connection.php");
session_start();

// Get the current user's ID from session
$current_user_id = $_SESSION['user_id'];

// Query to get all users except the logged-in user
// $sql = "SELECT id, firstname, lastname FROM user_login WHERE id != '$current_user_id'";
$sql = "SELECT * FROM user_login u WHERE u.id != '$current_user_id' AND ( u.id NOT IN ( SELECT fl.user_id FROM friends_list fl WHERE fl.friend_id = '$current_user_id' AND fl.status = 'accepted' UNION SELECT fl.friend_id FROM friends_list fl WHERE fl.user_id = '$current_user_id' AND fl.status = 'accepted' ) OR u.id IN ( SELECT fl.user_id FROM friends_list fl WHERE fl.friend_id = '$current_user_id' AND fl.status != 'accepted' UNION SELECT fl.friend_id FROM friends_list fl WHERE fl.user_id = '$current_user_id' AND fl.status != 'accepted' ) )";
$result = mysqli_query($con, $sql);

// Check if the query was successful
if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Select a User to Send a Friend Request</h2>";
    while ($row = mysqli_fetch_assoc($result))
     {
        // Display user's full name
        echo "<p>" . $row['firstname'] . " " . $row['lastname'] . "</p>";        
        echo '<form method="POST" action="send_friend_request.php">
                <input type="hidden" name="friend_id" value="' . $row['id'] . '">
                <button type="submit">Send Friend Request</button>
              </form>';
            //   We pass a hidden value (like friend_id) to keep track of data
            //    that isn’t visible to the user 
            //   but is necessary for processing the form submission.
    }
} else {
    echo "No other users available.";
}

mysqli_close($con);
