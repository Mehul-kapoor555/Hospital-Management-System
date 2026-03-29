<?php
    include "header.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Patient</title>
</head>
<body>
    <h1>Find a Patient</h1>
    <form action="find_patient.php" method="POST">
        Enter Patient ID:
        <input type="text" name="PatientID" required>
        <input type="submit" name="search" value="Search">
    </form>
</body>
</html>

<?php
include "database.php";

// Check if form was submitted
if (isset($_POST["search"])) {
    $PatientID = $_POST['PatientID'];

    // Query to find patient
    $sql = "SELECT TaxCode, FirstName, LastName, Age, Gender, ContactNumber, Address 
            FROM patients WHERE TaxCode = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $PatientID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while($patient = mysqli_fetch_assoc($result)) {    // Fetch patient details
            echo "<h3>Patient Details</h3>";
            echo "<p><strong>PatientID: </strong>" . $patient["TaxCode"] . "</p>"; 
            echo "<p><strong>Name: </strong>" . $patient["FirstName"] . " " . $patient["LastName"] . "</p>";
            echo "<p><strong>Age: </strong>" . $patient["Age"] . "</p>";
            echo "<p><strong>Gender: </strong>" . $patient["Gender"] . "</p>";
            echo "<p><strong>Phone: </strong>" . $patient["ContactNumber"] . "</p>";
            echo "<p><strong>Address: </strong>" . $patient["Address"] . "</p>";    
        }
    } else {
        echo "<b>No patient found.</b>";
    }
}

mysqli_close($conn);
?>