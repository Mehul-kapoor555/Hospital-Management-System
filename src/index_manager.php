<?php
include "header.php";
include "database.php";
session_start();

// if user isn't logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Greeting based on time
$hour = date('H');
if ($hour >= 4 && $hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}

// Get today’s date
$today = date("Y-m-d");

// 1. Total doctors
$docCountResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM doctors;");
$docCount = mysqli_fetch_assoc($docCountResult)['total'] ?? 0;

// Last doctor added
$lastDocResult = mysqli_query($conn, "SELECT FirstName, LastName FROM doctors ORDER BY DateAdded DESC LIMIT 1;");
$lastDoc = mysqli_fetch_assoc($lastDocResult);

// 2. Appointments today
$appCountResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointments WHERE DATE(Date_Time) = '$today';");
$appCount = mysqli_fetch_assoc($appCountResult)['total'] ?? 0;

// Next upcoming appointment
$nextAppResult = mysqli_query($conn, "
    SELECT a.Date_Time as DateTime, p.FirstName AS PatFirst, p.LastName AS PatLast, d.FirstName AS DocFirst, d.LastName AS DocLast
    FROM appointments a
    JOIN patients p ON a.PatientID = p.TaxCode
    JOIN doctors d ON a.DoctorID = d.LicenseNum
    WHERE DATE(a.Date_Time) = '$today' AND TIME(a.Date_Time) >= CURTIME()
    ORDER BY a.Date_Time ASC
    LIMIT 1;
");
$nextApp = mysqli_fetch_assoc($nextAppResult);

// 3. Earnings today (sum of Charges from doctors for today’s appointments)
$earningsResult = mysqli_query($conn, "
    SELECT SUM(Amount) AS earnings
    FROM billing 
    WHERE DATE(DateOfBilling) = '$today';
");
$earnings = mysqli_fetch_assoc($earningsResult)['earnings'] ?? 0; // conditional operator, if $earningResult returns null

// 4. Medicine stock
$medTotalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM medications;");
$medTotal = mysqli_fetch_assoc($medTotalResult)['total'] ?? 0;

$outOfStockResult = mysqli_query($conn, "SELECT MedicationName FROM medications WHERE InStock = 0;");
$outOfStock = [];
while ($row = mysqli_fetch_assoc($outOfStockResult)) {
    $outOfStock[] = $row['MedicationName'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<center>
    <h2>
        <?php 
            $username = $_SESSION["username"]; 
            echo $greeting . ", " . $username; 
        ?> 
    </h2>
    <p>Here's today's summary:</p>
</center> 

    <h3>👨‍⚕️ Doctors Overview</h3>
    <ul>
        <li>Total Doctors: <strong><?php echo $docCount; ?></strong></li>
        <li>Last Added: <strong><?php echo $lastDoc['FirstName'] . ' ' . $lastDoc['LastName']; ?></strong></li>
    </ul>
    <hr>

    <h3>📅 Appointments Summary</h3>
    <ul>
        <li>Total Appointments Today: <strong><?php echo $appCount; ?></strong></li>
        <?php if ($nextApp): ?>
            <li>Next Appointment:
                <strong><?php echo date($nextApp['DateTime']); ?></strong><br>
                Patient: <?php echo $nextApp['PatFirst'] . " " . $nextApp['PatLast']; ?> <br>
                Doctor: Dr. <?php echo $nextApp['DocFirst'] . " " . $nextApp['DocLast']; ?>
            </li>
        <?php else: ?>
            <li><strong>No upcoming appointments.</strong></li>
        <?php endif; ?>
    </ul>
    <hr>

    <h3>💰 Financial Summary</h3>
    <ul>
        <li>Total Earnings Today: <strong>€<?php echo number_format($earnings ?? 0, 2); ?>
    </ul>
    <hr>

    <h3>🧪 Pharmacy Stock</h3>
    <ul>
        <li>Total Medicines: <strong><?php echo $medTotal; ?></strong></li>
        <?php if (!empty($outOfStock)): ?>
            <li style="color:red;"><strong>Out of Stock:</strong> <?php echo implode(", ", $outOfStock); ?></li>
            <p style="color:red;">⚠️ Please arrange for restocking these medicines urgently.</p>
        <?php else: ?>
            <li style="color:green;">✅ All medicines are sufficiently stocked.</li>
        <?php endif; ?>
    </ul>
    <hr>
</body>
</html>

<?php mysqli_close($conn); ?>