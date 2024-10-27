<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in by checking if the session email is set
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit();
}

// Include the database connection
require_once("connection.php");

// Get the logged-in user's email from the session
$UserEmail = $_SESSION['email'];

// Query to get user data from the database
$query = "SELECT firstname, lastname, email, password FROM user_login WHERE email = '$UserEmail'";
$result = mysqli_query($con, $query);

// Check if the query returned any data
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch user data from the database
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found.";
    exit();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
             background: url('anime.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .profile-container {
            width: 420px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 0 10px rgba(0,0,0,.2);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .profile-container h1 {
            font-size: 36px;
            text-align: center;
        }

        .profile-card {
            margin-top: 20px;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            color: #fff;
            outline: none;
            border-width: 2px;
            border-style: solid;
            border-color: rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            padding: 20px 45px 20px 20px;

        }

        .input-box input::placeholder {
            color: #fff;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            width: 48%;
            height: 45px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
            text-align: center;
        }

        .delete-btn {
            background-color: red;
            color: white;
        }

        /* New styles for placing Firstname and Lastname side by side */
        .name-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 20px; /* Add spacing between fields */
            padding-top: 20px;
        }

        .name-wrapper .input-box {
            flex: 1;
            margin: 0; /* Remove extra margin from individual boxes */
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Your Profile</h1>
        <div class="profile-card">
            <form method="POST" action="update_profile.php"> <!-- Form to update profile -->
                <div class="name-wrapper">
                    <div class="input-box">
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required style="font-size: 16px;"   >
                    </div>

                    <div class="input-box">
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required style="font-size: 16px;">
                    </div>
                </div>

                <div class="input-box">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"style="font-size: 16px;"> <!-- Email is readonly -->
                </div>

                <div class="input-box">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" style="font-size: 16px;" required>
                </div>

                <div class="button-group">
                    <button type="submit" name="update" class="btn">Update Profile</button>
                    <button type="button" class="btn delete-btn" onclick="deleteAccount()">Delete Account</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // JavaScript function to delete the account
        function deleteAccount() {
            if (confirm('Are you sure you want to delete your account?')) {
                window.location.href = 'delete_account.php'; // Redirect to account deletion script
            }
        }
    </script>
</body>
</html>
