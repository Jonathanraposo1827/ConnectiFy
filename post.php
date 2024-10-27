<?php
require_once("connection.php");
session_start();// start or resume seesion

if(!isset($_SESSION['user_id']))//check if user has logged in 
{
    echo "You must log in to post";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $bio = $_POST['bio']; // Get bio text input
    $userId = $_SESSION['user_id']; // Logged-in user ID
    //$_FILES is a superglobal array in PHP used to handle file uploads. 
    //It contains information about files uploaded via a form, like file name, type, size, and more.
    //$target_dir specifies the directory where uploaded files will be saved.
    $target_dir = "uploads/"; // Directory to save pictures
    $target_file = $target_dir.basename($_FILES["picture"]["name"]);
    //basename() function in PHP returns the filename from a given path

   
    

    // move_uploaded_file: This function moves an uploaded file to a new location.
    // $_FILES["picture"]["tmp_name"]: This is the temporary filename of the uploaded file stored on the server.
    // $target_file: This is the destination path where the uploaded file will be moved.
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file))
    {
        $sql = "INSERT INTO post(user_id, bio, picture) VALUES ('$userId', '$bio', '$target_file')";
        if (mysqli_query($con, $sql))
        {
        //    echo "Post created successfully!";
        //    echo "<h2>Your Posted Picture:</h2>";
        //     echo "<img src='$target_file' alt='Uploaded Picture' style='max-width: 300px; max-height: 300px;'>";
         header("location:user_posts.php");
            
        } 
        else 
        {
            echo "Error: " . mysqli_error($conn);
        }
        
    }
    else 
        {
            echo "Error uploading file.";
        }


}
mysqli_close($con); // Close the database connection
?>