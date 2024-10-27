<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <title>Select Friends to Send Request</title>
    <style>
        body {
            background-color: #1a1a1a; /* Dark background */
            color: #ffffff; /* White text */
            font-family: Arial, sans-serif; /* Font family */
            margin: 0;
            padding: 20px; /* Padding around the body */
        }
        h2 {
            text-align: center; /* Centered title */
            margin-bottom: 20px; /* Space below the title */
        }
        .user-cards-container {
            max-width: 600px; /* Maximum width for the container */
            margin: 0 auto; /* Center the container */
        }
        .user-card {
            background-color: #2c2c2c; /* Darker card background */
            padding: 15px; /* Padding inside the card */
            border-radius: 8px; /* Rounded corners */
            margin: 10px 0; /* Space between cards */
            transition: background-color 0.3s; /* Smooth background change on hover */
        }
        .user-card:hover {
            background-color: #3c3c3c; /* Lighter on hover */
        }
        button {
            background-color: #007bff; /* Blue button */
            color: #ffffff; /* White text on button */
            border: none; /* No border */
            padding: 10px 15px; /* Padding inside button */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: 200px; /* Fixed button width */
            display: block; /* Makes it easier to center */
            margin: 10px auto 0 auto; /* Centers button horizontally and adds space above */
        }
        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>

<?php
require_once("connection.php");
session_start();

// Get the current user's ID from session
$current_user_id = $_SESSION['user_id'];

// Query to get all users except the logged-in user
$sql = "SELECT * FROM user_login u WHERE u.id != '$current_user_id' AND ( u.id NOT IN ( SELECT fl.user_id FROM friends_list fl WHERE fl.friend_id = '$current_user_id' AND fl.status = 'accepted' UNION SELECT fl.friend_id FROM friends_list fl WHERE fl.user_id = '$current_user_id' AND fl.status = 'accepted' ) OR u.id IN ( SELECT fl.user_id FROM friends_list fl WHERE fl.friend_id = '$current_user_id' AND fl.status != 'accepted' UNION SELECT fl.friend_id FROM friends_list fl WHERE fl.user_id = '$current_user_id' AND fl.status != 'accepted' ) )";
$result = mysqli_query($con, $sql);

// Check if the query was successful
if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Select a User to Send a Friend Request</h2>";
    echo "<div class='user-cards-container'>"; // Start user cards container
    while ($row = mysqli_fetch_assoc($result)) {
        // Display user's full name
        echo "<div class='user-card'>";
        echo "<p style='text-align: center;'>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</p>"; // Centered name
        echo '<form method="POST" action="send_friend_request.php">
                <input type="hidden" name="friend_id" value="' . htmlspecialchars($row['id']) . '">
                <button type="submit">Send Friend Request</button>
              </form>';
        echo "</div>"; // End of user card container
    }
    echo "</div>"; // End user cards container
} else {
    echo "<p>No other users available.</p>";
}

mysqli_close($con);
?>
<div class="text-center mt-4">
    <!-- <button class="bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-500" onclick="NewIndex.html">Back</button> -->
<button class="bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-500" onclick="window.location.href='NewIndex.html'">Back</button>

</div>
</body>
</html>
