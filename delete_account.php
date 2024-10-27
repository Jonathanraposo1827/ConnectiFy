<?php
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once("connection.php");

// Get the logged-in user's email from the session
$UserEmail = $_SESSION['email'];

// Execute the account deletion query
$delete_query = "DELETE FROM user_login WHERE email='$UserEmail'";

if (mysqli_query($con, $delete_query))
 {
    // Destroy session after deletion
    session_destroy();
    echo "Account deleted successfully!";
    // Redirect to a goodbye or home page
    header("Location:Create_acc.html");
    exit();
} else {
    echo "Error deleting account: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
