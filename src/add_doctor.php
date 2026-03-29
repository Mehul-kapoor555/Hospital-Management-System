<?php
    include "header.php";
    include "database.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Doctor</title>
</head>
<body>
    <center><h2>Add Doctor</h2></center> <hr>
    
    <form action="add_doctor.php" method="post">
        <h4> Please fill in the details. </h4> 

        License Number:
        <input type="text" name="licenseNum" required><br><br>
        First Name:
        <input type="text" name="firstName" required><br><br>
        Last Name:
        <input type="text" name="lastName" required><br><br>
        Contact Number:
        <input type="text" name="contactNumber" required><br><br>
        Email:
        <input type="email" name="email"><br><br>
        Charges:
        <input type="number" name="charges" required><br><br>
        Department Name:
        <input type="text" name="deptName" required><br><br>

        <input type="submit" name="submit" value="Add Doctor">
        <input type="reset" value="Reset">

    </form>
</body>
</html>

<?php

if (isset($_POST["submit"])) {

    $licenseNum = $_POST["licenseNum"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $contactNumber = $_POST["contactNumber"];
    $email = $_POST["email"];
    $charges = $_POST["charges"];
    $deptName = $_POST["deptName"];

    // 1. Check if department exists
    $sql1 = "SELECT * FROM departments WHERE DeptName = '$deptName';";
    $result = mysqli_query($conn, $sql1);

    // 2. Insert department if not exists
    if (mysqli_num_rows($result) == 0) { 
        $sql2 = "INSERT INTO departments (DeptName) VALUES ('$deptName');";
        if (!mysqli_query($conn, $sql2)) {
            die("Some error occurred.");
        }
    }

    $sql3 = "INSERT INTO doctors (LicenseNum, FirstName, LastName, ContactNumber, Email, Charges, DeptName)
            VALUES ('$licenseNum', '$firstName', '$lastName', '$contactNumber', '$email', '$charges', '$deptName');";

    if (mysqli_query($conn, $sql3) == TRUE) {
        echo "Doctor added successfully!";
    } else {
        echo "Some error occurred.";
    }

}

mysqli_close($conn);
?>
