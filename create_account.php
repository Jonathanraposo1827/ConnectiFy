<?php
    require_once("connection.php");

    if (isset($_POST['submit'])) {
        if (empty($_POST['lastname'])||empty($_POST['firstname'])||empty($_POST['email']) || empty($_POST['password']))
         {
            echo 'Please fill in the blanks.';
        } 
        else
         {
            $firstname = $_POST['firstname'];           
            $lastname  = $_POST['lastname'];                       
            $UserEmail = $_POST['email'];
            $UserPassword = $_POST['password'];

            // Ensure the connection is still open
            if ($con) 
            {
                $query = "INSERT INTO user_login (email, password,firstname,lastname) VALUES('$UserEmail', '$UserPassword',' $firstname','$lastname ')";
                $result = mysqli_query($con, $query);

                if ($result) 
                {
                    echo "Account successfully created.";
                    header("location:index.html");
                    exit();
                } else
                 {
                    echo "Error inserting data: " . mysqli_error($con);
                }
            } 
            else 
            {
                echo "Database connection error.";
            }
        }
    } 
    else 
    {
        // This block might redirect before handling the form properly. Be cautious.
        echo "Form not submitted correctly.";
        // header("location:index.php"); // Use with care
    }
?>
