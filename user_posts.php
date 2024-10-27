<?php
require_once("connection.php"); // Include the connection file
session_start(); // Start or resume session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Posts</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100">

<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='text-red-500 text-center mt-10'>You must log in to view your posts.</div>";
    exit;
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID

// Query to fetch all posts by the logged-in user
$sql = "SELECT * FROM post WHERE user_id = '$userId'";
$result = mysqli_query($con, $sql);

// Check if there are any posts
if (mysqli_num_rows($result) > 0) {
    echo "<div class='max-w-4xl mx-auto p-8'>"; // Center content
    echo "<h1 class='text-3xl font-bold mb-6 text-center text-gray-100'>Your Posts</h1>";

    // Loop through and display each post
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='bg-gray-800 rounded-lg shadow-lg mb-6 p-6 text-center'>"; // Center text and image
        echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='User Picture' class='mt-2 rounded-lg max-w-full max-h-96 mx-auto object-cover mb-4'>"; // Center image
        echo "<h3 class='text-xl font-semibold text-gray-200 mb-2'>Caption:</h3>";
        echo "<p class='text-gray-300'>" . htmlspecialchars($row['bio']) . "</p>";
        echo "</div>";
    }

    echo "</div>";
} else
 {
    echo "<div class='text-gray-400 text-center mt-10'>No posts found.</div>";
    // // Add the back button
    // echo "<div class='text-center mt-6'>"; // Center the button
    // echo "<button onclick='history.back()' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Go Back</button>";
    // echo "</div>";
}

// Close the database connection
mysqli_close($con);
?>
<!-- Add the Back button before the body tag ends -->
<div class="text-center mt-6">
    <button onclick="window.location.href='NewIndex.html'" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go Back</button>
</div>
</body>
</html>
