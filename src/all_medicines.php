<?php
include "header.php";
include "database.php";

// Fetch medicines
$sql = "SELECT MedicationID, MedicationName, Dosage, SideEffects, InStock FROM medications";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Medicines</title>
</head>
<body>
    <h2>All Medicines</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Dosage</th>
            <th>Side Effects</th>
            <th>In Stock</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row["MedicationID"]; ?></td>
                    <td><?php echo $row["MedicationName"]; ?></td>
                    <td><?php echo $row["Dosage"]; ?></td>
                    <td><?php echo $row["SideEffects"]; ?></td>
                    <td><?php echo $row["InStock"] ? "Yes" : "No"; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No medicines found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
