<?php
include "header.php";
include "database.php";

$patient = null;
$message = "";

// Step 1: Find Patient
if (isset($_POST["search"])) {
    $taxCode = $_POST["taxCode"];

    $sql = "SELECT TaxCode, FirstName, LastName, Age, Gender, ContactNumber FROM patients WHERE TaxCode = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $taxCode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc(); // Fetch patient details
    } else {
        echo "<b>No patient found with Tax Code: </b> $taxCode";
    }
}

// Step 2: Insert Treatment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addTreatment"])) {
    $taxCode = $_POST["taxCode"];
    $diagnosis = $_POST["diagnosis"];
    $medicationID = $_POST["medicationID"];

    $sql = "INSERT INTO treatments (PatientID, Diagnosis, MedicationID) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $taxCode, $diagnosis, $medicationID);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Treatment added successfully!";
    } else {
        $message = "Error adding treatment: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Treatment</title>
</head>
<body>
    <center><h1>TREATMENT</h1></center> <hr>
    <form action="add_treatment.php" method="POST">
        <br><b>Enter Patient Tax Code:</b>
        <input type="text" name="taxCode" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php if ($patient): ?>
        <h2>Patient Details</h2>
        <b>Name: </b> <?php echo $patient["FirstName"] . " " . $patient["LastName"]; ?><br>
        <b>Age: </b> <?php echo $patient["Age"]; ?><br>
        <b>Gender: </b> <?php echo $patient["Gender"]; ?><br>
        <b>Contact: </b> <?php echo $patient["ContactNumber"]; 
    ?>
    
    <br>
        <h2>Add Treatment</h2>
        <form action="add_treatment.php" method="POST">
            <input type="hidden" name="taxCode" value="<?php echo $patient["TaxCode"]; ?>">
            Diagnosis:
            <input type="text" name="diagnosis" required><br><br>
            Medication ID:
            <input type="number" name="medicationID" required><br><br>
            <input type="submit" name="addTreatment" value="Add Treatment">
        </form>
    <?php elseif ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif;  // endif; ends the if-elseif structure without needing curly braces {} ?>
</body>
</html>
