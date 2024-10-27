<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend's Posts</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4">
        <?php
        require_once("connection.php"); 
        session_start();

        if (!isset($_SESSION['user_id'])) {
            echo "<p class='text-center text-red-500'>You must be logged in to view friends' posts.</p>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $friend_id = $_POST['friend_id'];  // Get the friend's ID from the form submission

            // Query to fetch all posts by the selected friend
            $post_sql = "SELECT * FROM post WHERE user_id = '$friend_id'";
            $post_result = mysqli_query($con, $post_sql);

            // Check if the friend has any posts
            if (mysqli_num_rows($post_result) > 0) 
            {
                echo "<h1 class='text-3xl font-bold mb-4 text-center'>Posts by Your Friend</h1>";
                
                // Loop through and display each post
                while ($post = mysqli_fetch_assoc($post_result))
                {
                    echo "<div class='border border-gray-600 rounded-lg bg-gray-800 p-4 mb-6 w-1/2 mx-auto'>"; // w-1/2 sets the width to 50%, mx-auto centers it
                    echo "<h3 class='text-blue-400 text-xl font-semibold'>caption:</h3>";
                    echo "<p class='text-white'>" . htmlspecialchars($post['bio']) . "</p>";
                    echo "<h3 class='text-blue-400 text-xl font-semibold mt-4'>Picture:</h3>";
                    echo "<img src='" . htmlspecialchars($post['picture']) . "' alt='Post Picture' class='max-w-full max-h-72 mt-2 rounded-md'>";
                    echo "</div>";
                }
            } 
            else
            {
                echo "<p class='text-lg text-center'>This friend has not posted anything.</p>";
            }
        }

        mysqli_close($con);
        ?>
    </div>
</body>
</html>
