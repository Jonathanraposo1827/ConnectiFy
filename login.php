<?php
    require_once("connection.php"); // Includes the connection file for database access

    if (isset($_POST['submit'])) { // Checks if the form is submitted
        if (empty($_POST['email']) || empty($_POST['password'])) { 
            echo 'Please fill in the blanks.'; // Prompt to fill in email and password
        } else {
            $UserEmail = $_POST['email'];
            $UserPassword = $_POST['password'];

            // Ensure the connection is still open
            if ($con) {
                // Query to check if email and password match an entry in the database
                $query = "SELECT * FROM user_login WHERE email='$UserEmail' AND password='$UserPassword'";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    // If login is successful, start session and store the email
                    session_start();
                    $_SESSION['email'] = $UserEmail;
                    header("Location:userlist.php"); // Redirect to dashboard
                    exit;
                } else {
                    echo "Invalid email or password."; // Error if credentials don't match
                }
            } else {
                echo "Database connection error."; // Error if database connection fails
            }
        }
    } else
     {
        echo "Form not submitted correctly."; // Error if form not submitted properly
    }// comment line for github
?>
