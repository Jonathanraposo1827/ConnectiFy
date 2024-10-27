<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        /* General reset for margins, padding, and setting up box sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif; /* Set font globally */
        }
       /* Set the body to center everything vertically and horizontally */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full screen height */
            background-color: #f4f4f9; /* Light background color */
        }
        /* Style for the main container holding the user list */
        .container {
            width: 400px; /* Fixed width */
            max-height: 400px; /* Maximum height (scrollable if needed) */
            background-color: #fff; /* White background */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
            overflow-y: auto; /* Enable vertical scrolling */
            padding: 20px; /*Space inside the container*/
        }
        /* Style for the heading inside the container */
        .container h1
         {
            text-align: center; /* Centered heading */
            margin-bottom: 20px; /* Space below the heading */
            font-size: 24px; /* Font size for the heading */
            color: #333; /* Dark gray text color */
        }
        /* Style for the list containing user information */
        .user-list
         {
            list-style: none; /* Remove bullet points from the list */
            padding: 0; /* Remove default padding */
        }
        /* Style for each list item (user) */
        .user-list li {
            padding: 10px; /* Space inside each user box */
            background-color:grey; /* Light gray background */
            margin-bottom: 10px; /* Space between user boxes */
            border-radius: 5px; /* Slightly rounded corners */
            display: flex; /* Flex layout for easier positioning */
            justify-content: space-between; /* Space between name and email */
            align-items: center; /* Align items vertically in the center */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
        }

         /* Style for displaying user name and email */
         .user-info {
            font-size: 16px; /* Font size for the user's name */
        }

                /* Style for the scrollbar */
                .scroll-bar {
            width: 100%;
        }

        /* Custom scrollbar style */
        .container::-webkit-scrollbar {
            width: 10px; /* Width of the scrollbar */
        }

        /* Style for the scrollbar thumb (the draggable part) */
        .container::-webkit-scrollbar-thumb {
            background-color: #888; /* Default color of the scrollbar */
            border-radius: 10px; /* Rounded corners for the scrollbar thumb */
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>List of Users</h1>
        <ul class="user-list">
            <?php
                // Include the PHP file that fetches the users from the database
                include("fetch_users.php");

                // Loop through each user and display their name and email
                if (!empty($users))
                 { 
                    // If there are users in the database
                    foreach ($users as $user) 
                    { // Loop through each user
                        echo '<li>'; // Start list item
                        // Display the user's name (first name and last name)
                        echo '<div class="user-info">' . htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']) . '</div>';
                        // Display the user's email
                        echo '<div class="user-email">' . htmlspecialchars($user['email']) . '</div>';
                        echo '</li>'; // End list item
                    }
                }
                 else 
                 {
                    // If no users are found, display a message
                    echo '<li>No users found.</li>';
                }
            ?>
        </ul>
    </div>

</body>
</html>
