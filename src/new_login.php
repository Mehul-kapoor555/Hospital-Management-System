<?php
session_start();
include "database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User Registration</title>
</head>
<body>
    <center>
        <h1>OSPEDALE PAPARDO</h1> 
        <hr>
        <h2>New User Registration</h2>

        <form action="new_login.php" method="post">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <label>Role:</label><br>
            <input type="radio" name="role" value="doctor" required> Doctor
            <input type="radio" name="role" value="patient" checked> Patient
            <input type="radio" name="role" value="manager"> Manager<br><br>

            <input type="submit" name="register" value="Register">
        </form>
        <br>
        <a href="login.php">Go to Login Page</a>
    </center>
</body>
</html>


<?php

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (!empty($username) && !empty($password) && !empty($role)) {
        $sql = "INSERT INTO admin (username, password, role) VALUES ('$username', '$password', '$role')";

        if (mysqli_query($conn, $sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields.";
    }
}

?>