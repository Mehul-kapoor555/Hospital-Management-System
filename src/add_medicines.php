<?php
include "header.php";
include "database.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
</head>
<body>
    <h2>Add New Medicine</h2>
    <form action="" method="POST">
        <label>Medication ID:</label>
        <input type="number" name="id" required><br><br>
        
        <label>Medication Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Dosage:</label>
        <input type="text" name="dosage" required><br><br>

        <label>Side Effects:</label>
        <input type="text" name="sideEffects"><br><br>

        <label>In Stock:</label>
        <input type="checkbox" name="inStock" checked><br><br>

        <button type="submit" name="submit">Add Medicine</button>
    </form>
</body>
</html>

<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST["name"];
    $id = $_POST["id"];
    $dosage = $_POST["dosage"];
    $sideEffects = $_POST["sideEffects"];
    $inStock = isset($_POST["inStock"]) ? 1 : 0;

    // Insert into database
    $sql = "INSERT INTO medications (MedicationID, MedicationName, Dosage, SideEffects, InStock) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssi", $id, $name, $dosage, $sideEffects, $inStock);

    if (mysqli_stmt_execute($stmt)) {
        echo "Medicine added successfully!";
    } else {
        echo "Some error occured." . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>