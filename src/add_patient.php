<?php
    include "header.php";
    include "database.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Patient</title>
</head>
<body>
    <center><h2>Add Patient</h2></center> <hr>
    
    <form action="add_patient.php" method="post">
        <h4>Please fill in the patient details.</h4>

        Tax Code:
        <input type="text" name="taxCode" required><br><br>

        First Name:
        <input type="text" name="firstName" required><br><br>

        Last Name:
        <input type="text" name="lastName" required><br><br>

        Age:
        <input type="number" name="age" min="6" required><br><br>

        Gender:
        <select name="gender" required>
            <option value="">--Select--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>

        Contact Number:
        <input type="number" name="contactNumber" required><br><br>

        Address:
        <textarea name="address" rows="3" cols="30" required></textarea><br><br>

        <input type="submit" name="submit" value="Add Patient">
        <input type="reset" value="Reset">
    </form>
</body>
</html>

<?php
if (isset($_POST["submit"])) {
    $taxCode = $_POST["taxCode"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $contactNumber = $_POST["contactNumber"];
    $address = $_POST["address"];

    $sql = "INSERT INTO patients (TaxCode, FirstName, LastName, Age, Gender, ContactNumber, Address)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssissi", $taxCode, $firstName, $lastName, $age, $gender, $contactNumber, $address);

    if (mysqli_stmt_execute($stmt)) {
        echo "<b>Patient added successfully!</b>";
    } else {
        echo "<b>Error:</b> " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
