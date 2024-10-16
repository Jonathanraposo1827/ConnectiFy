<?php
require_once("connection.php");

// Query to fetch all users from the database
$query = "SELECT firstname, lastname, email FROM user_login";
$result = mysqli_query($con, $query);

// Check if the query returns any users
if (mysqli_num_rows($result) > 0)
 {
  // Fetch all users into an array
  $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
 }

 else
{
    $users = [];
}

// Close the database connection
mysqli_close($con);
?>