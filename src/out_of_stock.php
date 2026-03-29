<?php
include "header.php";
include "database.php";

$medicine = null;
$message = "";

// Step 1: Find Medicine
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $medID = $_POST["medID"];

    $sql = "SELECT MedicationID, MedicationName, Dosage, SideEffects, InStock FROM medications WHERE MedicationID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $medID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $medicine = $result->fetch_assoc(); // Fetch medicine details
    } else {
        $message = "No medicine found with ID: $medID";
    }
}

// Step 2: Update Medicine to Out of Stock
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateStock"])) {
    $medID = $_POST["medID"];

    $sql = "UPDATE medications SET InStock = 0 WHERE MedicationID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $medID);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Medicine marked as Out of Stock!";
    } else {
        $message = "Error updating stock: " . mysqli_error($conn);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Medicine Out of Stock</title>
</head>
<body>
    <h2>Find Medicine</h2>
    <form action="out_of_stock.php" method="POST">
        Enter Medication ID: 
        <input type="number" name="medID" required>
        <input type="submit" name="search" value="Search">
    </form>

    <?php if ($medicine): ?>
        <h3>Medicine Details</h3>
        <p><strong>Name:</strong> <?php echo $medicine["MedicationName"]; ?></p>
        <p><strong>Dosage:</strong> <?php echo $medicine["Dosage"]; ?></p>
        <p><strong>Side Effects:</strong> <?php echo $medicine["SideEffects"]; ?></p>
        <p><strong>In Stock:</strong> <?php echo ($medicine["InStock"] ? "Yes" : "No"); ?></p>

        
        <?php if ($medicine["InStock"]): ?>
        <h3>Confirm Update</h3>
        <p>Do you want to mark this medicine as Out of Stock?</p>
        <form action="out_of_stock.php" method="POST">
            <input type="hidden" name="medID" value="<?php echo $medicine["MedicationID"]; ?>">
            <input type="submit" name="updateStock" value="Mark as Out of Stock">
        </form>
        <?php else: ?>
        <p><strong>Note:</strong> This medicine is already marked as Out of Stock.</p>
        <?php endif; ?>


        
    <?php elseif ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
