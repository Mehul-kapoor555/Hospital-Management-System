<?php
    include "header.php";
    include "database.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Doctors</title>
</head>
<body>
    <center><h1>Doctors List</h1></center> <hr>

    <?php

    // Fetch all doctors grouped by department
    $sql = "SELECT d.DeptName, doc.LicenseNum, doc.FirstName, doc.LastName 
            FROM doctors doc 
            JOIN departments d ON doc.DeptName = d.DeptName
            ORDER BY d.DeptName, doc.FirstName;";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $currentDept = ""; // A variable initialized as an empty string To track department change

        while ($row = mysqli_fetch_assoc($result)) {  // fetches doctor records until no more rows are available that is when it return false
            // When department changes, print the department header and open a new table
            if ($row["DeptName"] != $currentDept) {
                // Close the previous table if it's not the first department
                if ($currentDept != "") {
                    echo "</table><br>";
                }

                // Display department name and open a new table
                echo "<h3>" . $row["DeptName"] . "</h3>";
                echo "<table border='1'>";
                echo "<tr><th>License Number</th><th>First Name</th><th>Last Name</th>";

                $currentDept = $row["DeptName"]; // Update the current department
            }

            // Display doctor details
            echo "<tr>";
            echo "<td>" . $row["LicenseNum"] . "</td>";
            echo "<td>" . $row["FirstName"] . "</td>";
            echo "<td>" . $row["LastName"] . "</td>";
            echo "</tr>";
        }

        // Close the last table after the loop ends
        echo "</table><br>";

    } else {
        echo "<b>No doctors found.</b>";
    }

    mysqli_close($conn);
    ?>

</body>
</html>