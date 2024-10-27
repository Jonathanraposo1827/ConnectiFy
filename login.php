<?php
require_once("connection.php"); // Includes the connection file for database access

if (isset($_POST['submit'])) { // Checks if the form is submitted
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Please fill in the blanks.');</script>"; // JavaScript alert for empty fields
        echo "<script>window.location.href = 'index.html';</script>"; // Redirect back to the form
    } else {
        $UserEmail = $_POST['email'];
        $UserPassword = $_POST['password'];

        if ($con) {
            // Query to check if email and password match an entry in the database
            $query = "SELECT * FROM user_login WHERE email='$UserEmail' AND password='$UserPassword'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                // Fetch the result row to get user details
                $row = mysqli_fetch_assoc($result);
                // If login is successful, start session and store the email
                session_start();
                $_SESSION['email'] = $UserEmail;
                $_SESSION['user_id'] = $row['id']; // Store user ID

                header("Location: NewIndex.html"); // Redirect to dashboard
                exit;
            } else {
                echo "<script>alert('Invalid email or password.');</script>"; // Show alert for invalid credentials
                echo "<script>window.location.href = 'index.html';</script>"; // Redirect back to the form
            }
        } else {
            echo "<script>alert('Database connection error.');</script>"; // Show alert for connection error
            echo "<script>window.location.href = 'index.html';</script>"; // Redirect back to the form
        }
    }
} else {
    echo "<script>alert('Form not submitted correctly.');</script>"; // Show alert if form not submitted properly
    echo "<script>window.location.href = 'index.html';</script>"; // Redirect back to the form
}
