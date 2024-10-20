<?php
require_once("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to accept friend requests.";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM friends_list WHERE friend_id = '$user_id' AND status = 'pending'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0)
 {
    echo "<h1>Friend Requests</h1>";

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $request_id = $row['id'];
        $requester_id = $row['user_id'];
        
        $user_sql = "SELECT firstname, lastname FROM user_login WHERE id = '$requester_id'";
        $user_result = mysqli_query($con, $user_sql);
        $user = mysqli_fetch_assoc($user_result);

        echo "<div>";
        echo "<p>Friend request from: " . $user['firstname'] . " " . $user['lastname'] . "</p>";
        echo "<form method='POST' action='handle_friend_requests.php'>";
        echo "<input type='hidden' name='request_id' value='$request_id'>";
        echo "<button name='accept' value='accept'>Accept</button>";
        echo "<button name='reject' value='reject'>Reject</button>";
        echo "</form>";
        echo "</div>";
    }
}
else 
{
    echo "No request sent to you yet";
}

mysqli_close($con);
?>
