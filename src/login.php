<?php
    session_start();
    include "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <center>
        <h1>OSPEDALE PAPARDO</h1>
        <hr>
        <h2>Log In</h2>
        <br><br>
        <form action="login.php" method="post">
            <h4>Username:</h4>
            <input type="text" name="username"><br>
            <h4>Password:</h4>
            <input type="password" name="password"><br><br><br>
            <input type="submit" value="Login" name="login"><br><br><br><br>
        </form>
        <a href="new_login.php">Are you a new user?</a>
    </center>
</body>
</html>

<?php
    if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

try{    
    $sql = "SELECT role FROM admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password); // both are strings
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $username;

        // Redirect based on role
        switch ($row["role"]) {
            case "doctor":
                header("Location: index_doctor.php");
                break;
            case "patient":
                header("Location: index_patient.php");
                break;
            case "manager":
                header("Location: index_manager.php");
                break;
            default:
                echo "Unknown role";
                break;
        }
        exit();
    } else{
        echo "Invalid username or password."; 
    }
} catch(mysqli_sql_exception){
    echo "Invalid username or password."; 
}
}
?>