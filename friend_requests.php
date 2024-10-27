<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend Requests</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* You can add any additional custom styles here */
        body {
            background-color: #1a1a1a; /* Dark background for the entire page */
        }
    </style>
</head>
<body>

<?php
require_once("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<p class='text-white text-center'>You must be logged in to accept friend requests.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM friends_list WHERE friend_id = '$user_id' AND status = 'pending'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1 class='text-center text-2xl font-bold text-white'>Friend Requests</h1>"; // Centered title with white color

    while ($row = mysqli_fetch_assoc($result)) {
        $request_id = $row['id'];
        $requester_id = $row['user_id'];
        
        $user_sql = "SELECT firstname, lastname FROM user_login WHERE id = '$requester_id'";
        $user_result = mysqli_query($con, $user_sql);
        $user = mysqli_fetch_assoc($user_result);

        echo "<div class='bg-gray-800 p-4 rounded-lg mx-auto mb-4' style='max-width: 400px;'>"; // Dark card for requests
        echo "<p class='text-center text-white'>Friend request from: " . htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']) . "</p>"; // Centered name
        
        // Form for accepting or rejecting the request
        echo "<form method='POST' action='handle_friend_requests.php' class='text-center'>"; // Centering form elements
        echo "<input type='hidden' name='request_id' value='" . htmlspecialchars($request_id) . "'>";
        echo "<button name='accept' value='accept' class='bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600'>Accept</button>"; // Styled accept button
        echo "<button name='reject' value='reject' class='bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 ml-2'>Reject</button>"; // Styled reject button
        echo "</form>";
        echo "</div>"; // End of the request card
    }
} else {
    echo "<p class='text-white text-center'>No requests sent to you yet</p>"; // Centered message with white text
}

mysqli_close($con);
?>

<!-- Back Button -->
<div class="text-center mt-4">
    <button class="bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-500" onclick="window.location.href='NewIndex.html'">Back</button>
</div>

</body>
</html>
