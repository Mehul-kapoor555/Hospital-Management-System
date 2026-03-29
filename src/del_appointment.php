<?php
    include "header.php";
    include "database.php";
    session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Appointment</title>
</head>

<body>
    <h2>Delete a Booked Appointment</h2>

    <!-- Search Form -->
    <form action="del_appointment.php" method="post">
        Enter Appointment ID:
        <input type="number" name="appointmentID" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php

    $appointmentFound = false; // Track if appointment exists

    if (isset($_POST["search"]) && isset($_POST["appointmentID"])) {
        $appointmentID = $_POST['appointmentID'];
        $_SESSION['appointmentID'] = $appointmentID;


        $sql = "SELECT a.AppointmentID as id, p.FirstName as patientFirstName, p.LastName as patientLastName, p.TaxCode as taxCode, 
                       d.FirstName as doctorFirstName, d.LastName as doctorLastName, d.LicenseNum as licenseNum, a.Date_Time as dateTime
                FROM appointments a 
                JOIN patients p ON a.PatientID = p.TaxCode
                JOIN doctors d ON a.DoctorID = d.LicenseNum
                WHERE a.AppointmentID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $appointmentID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $patientFirstName, $patientLastName, $taxCode, $doctorFirstName, $doctorLastName, $licenseNum, $dateTime);

        if (mysqli_stmt_fetch($stmt)) {
            $appointmentFound = true; // Mark that an appointment was found

            echo "<h3>Appointment Details</h3>";
            echo "<b>Appointment ID: </b>$id<br>";
            echo "<b>Patient Name: </b>$patientFirstName $patientLastName (<b>TaxCode: </b>$taxCode)<br>";
            echo "<b>Doctor Name: </b>$doctorFirstName $doctorLastName (<b>LicenseNum: </b>$licenseNum)<br>";
            echo "<b>Date & Time: </b>$dateTime<br>";

            mysqli_stmt_close($stmt);
        } else {
            echo "Sorry, no appointment found.";
            mysqli_stmt_close($stmt);
        }
    }

    // If appointment is found, show the delete and cancel buttons
    if ($appointmentFound):
    ?>
        <form method="post"> 
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    <?php
    endif;

    if (isset($_POST["cancel"])) {
        header("Location: appointment.php");
        exit();
    }

    if (isset($_POST["delete"])) {
        $appointmentID = $_SESSION['appointmentID'] ?? null;

    if (!$appointmentID) {
        echo "<b>Error: Appointment ID missing.</b>";
    } else {
        $sql = "DELETE FROM appointments WHERE AppointmentID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $appointmentID);

        if (mysqli_stmt_execute($stmt)) {
            echo "<b>Appointment deleted successfully.</b>";
        } else {
            echo "<b>Error deleting appointment: </b>" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

    mysqli_close($conn);
    ?>

</body>

</html>
