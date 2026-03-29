<?php
    include "header.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Doctor</title>
</head>
<body>
    <h1>Find a Doctor</h1>
    <form action="find_doctor.php" method="POST">
        Enter License Number:
        <input type="text" name="licenseNum" required>
        <input type="submit" name="search" value="Search">
    </form>
</body>
</html>

<?php
include "database.php";

// Check if form was submitted
if (isset($_POST["search"])) {
    $licenseNum = $_POST['licenseNum'];

    // Query to find doctor
    $sql = "SELECT LicenseNum, FirstName, LastName, ContactNumber, Email, Charges, DeptName FROM doctors WHERE LicenseNum = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $licenseNum);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while($doctor = mysqli_fetch_assoc($result)) {    // Fetch doctor details
            echo "<h3>Doctor Details</h3>";
            echo "<b>License Number: </b>" . $doctor["LicenseNum"] . "<br>"; 
            echo "<b>Name: </b>" . $doctor["FirstName"] . " " . $doctor["LastName"] . "<br>";
            echo "<b>Phone: </b>" . $doctor["ContactNumber"] . "<br>";
            echo "<b>Email: </b>" . $doctor["Email"] . "<br>";
            echo "<b>Charges: </b>" . $doctor["Charges"] . "<br>";
            echo "<b>Department: </b>" . $doctor["DeptName"] . "<br>";
    
        }
    } else {
        echo "No doctor found with License Number: $licenseNum";
    }
}

mysqli_close($conn);
?>