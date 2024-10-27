<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Posts</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white min-h-screen flex justify-center items-center">
    <div class="container mx-auto p-4">
        <?php
        require_once("connection.php");
        session_start();

        if (!isset($_SESSION['user_id'])) {
            echo "<p class='text-center text-red-500'>You must be logged in to view and manage your posts.</p>";
            exit;
        }

        $user_id = $_SESSION['user_id']; // Logged-in user's ID

        // Fetch the user's posts from the database
        $post_sql = "SELECT * FROM post WHERE user_id = '$user_id'";
        $post_result = mysqli_query($con, $post_sql);

        if (mysqli_num_rows($post_result) > 0) {
            echo "<h1 class='text-3xl font-bold mb-4 text-center'>Your Posts</h1>";
            while ($post = mysqli_fetch_assoc($post_result)) {
                echo "<div class='border border-gray-600 rounded-lg bg-gray-800 p-4 mb-6 w-1/3 mx-auto'>";
                  echo "<h3 class='text-blue-400 text-xl font-semibold mt-4'>Picture:</h3>";
                echo "<img src='" . htmlspecialchars($post['picture']) . "' alt='Post Picture' class='max-w-full max-h-72 mt-2 rounded-md'>";
                echo "<h3 class='text-blue-400 text-xl font-semibold'>Caption:</h3>";
                echo "<p class='text-white'>" . htmlspecialchars($post['bio']) . "</p>";
                // echo "<h3 class='text-blue-400 text-xl font-semibold mt-4'>Picture:</h3>";
                // echo "<img src='" . htmlspecialchars($post['picture']) . "' alt='Post Picture' class='max-w-full max-h-72 mt-2 rounded-md'>";

                // Add a form with a delete button for each post
                echo "<form action='delete_post.php' method='POST' class='mt-4'>";
                echo "<input type='hidden' name='post_id' value='" . $post['post_id'] . "'>";
                echo "<input type='submit' value='Delete' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 cursor-pointer'>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "<p class='text-lg text-center'>You have no posts.</p>";
        }

        mysqli_close($con);
        ?>
    </div>
</body>
</html>
