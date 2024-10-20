<?php
session_start(); // Start session

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once("connection.php");

// Get the logged-in user's email from the session
$UserEmail = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $newEmail = mysqli_real_escape_string($con, $_POST['email']); // Get new email from form

    // Update the user details in the database, including email
    $update_query = "UPDATE user_login SET firstname='$firstname', lastname='$lastname', password='$password', email='$newEmail' WHERE email='$UserEmail'";

    if (mysqli_query($con, $update_query)) {
        // Update the session email if the email was updated
        $_SESSION['email'] = $newEmail;

        echo "Profile updated successfully!";
        // Optionally, redirect to the profile page after a successful update
        header("Location: profile.php");
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
