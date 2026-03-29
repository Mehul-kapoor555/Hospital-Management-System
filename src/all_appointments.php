<?php 
    include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
</head>
<body>
</body>
</html>

<?php
    include "database.php";

    // Use column aliases to prevent ambiguity
    $sql = "SELECT a.AppointmentID AS appointment_id, a.Date_Time AS appointment_date,
                   p.FirstName AS patient_fname, p.LastName AS patient_lname, p.TaxCode AS patient_id,
                   d.FirstName AS doctor_fname, d.LastName AS doctor_lname, d.LicenseNum AS doctor_id
            FROM appointments a 
            JOIN patients p ON a.PatientID = p.TaxCode
            JOIN doctors d ON a.DoctorID = d.LicenseNum;";

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<br>"; 
            echo "<b>Appointment ID: </b>" . $row['appointment_id'] . "<br>";
            echo "<b>Date and Time: </b>" . $row['appointment_date'] . "<br><br>";

            echo "<b>Patient Name: </b>" . $row['patient_fname'] . " " . $row['patient_lname'] . "<br>";
            echo "<b>Patient ID: </b>" . $row['patient_id'] . "<br><br>";

            echo "<b>Doctor Name: </b>" . $row['doctor_fname'] . " " . $row['doctor_lname'] . "<br>";
            echo "<b>Doctor ID: </b>" . $row['doctor_id'] . "<br>";

            echo "<br> <hr>";   
        }
    } else {
        echo "Currently, there are no appointments.";
    }
    mysqli_close($conn);
?>
