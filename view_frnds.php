<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Friends</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* You can add any additional custom styles here */
        body {
            background-color: #1a1a1a; /* Dark background for the entire page */
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

<?php
require_once("connection.php"); 
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your friends.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Query to fetch all accepted friends for the logged-in user, avoiding duplicates
$sql = "SELECT DISTINCT CASE
            WHEN user_id = '$user_id' THEN friend_id
            ELSE user_id
        END AS friend_id
        FROM friends_list
        WHERE (user_id = '$user_id' OR friend_id = '$user_id') AND status = 'accepted'";

$result = mysqli_query($con, $sql);

echo "<h1 class='text-center text-2xl font-bold text-white'>Your Friends</h1>";
if (mysqli_num_rows($result) > 0) {
    echo "<div class='flex flex-col items-center justify-center w-3/5 mx-auto'>"; // Center the container and set width to 60%
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine the friend ID
        $friend_id = $row['friend_id'];

        // Fetch friend's name
        $friend_sql = "SELECT firstname, lastname FROM user_login WHERE id = '$friend_id'";
        $friend_result = mysqli_query($con, $friend_sql);
        $friend = mysqli_fetch_assoc($friend_result);

        // Display friend's name and "See Post" button
        echo "<div class='border border-gray-300 rounded-lg shadow-md m-4 p-4 bg-gray-800 w-full'>"; // Set width to full
        echo "<p class='text-center text-white'>Friend: " . htmlspecialchars($friend['firstname']) . " " . htmlspecialchars($friend['lastname']) . "</p>"; // Centered text
        
        // Form with "See Post" button, sending the friend's ID to fetch posts
        echo "<form method='POST' action='view_friends_posts.php'>";
        echo "<input type='hidden' name='friend_id' value='$friend_id'>";  // Send friend's ID in hidden input
        echo "<button type='submit' class='mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 w-full'>See Post</button>";  // Button to see friend's posts
        echo "</form>";
        echo "</div>";
    }
    echo "</div>"; // Close the flex container
} else {
    echo "<p class='text-white'>You have no friends.</p>";
}

mysqli_close($con);
?>

<!-- Back Button -->
<div class="mt-auto mb-4 text-center">
    <button class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600" onclick="history.back()">Back</button>
</div>

</body>
</html>
