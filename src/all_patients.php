<?php
    include "header.php";
    include "database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Patients</title>
</head>
<body>
    <center><h1>PATIENTS</h1></center>  <hr>
    
</body>
</html>

<?php
    $sql = "SELECT TaxCode, FirstName, LastName, Age, Gender, ContactNumber, Address
            FROM patients ;";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<br>"; 
            echo "<b> Patient ID : </b>" . $row['TaxCode'] . "<br>";
            echo "<b> Full Name : </b>" . $row['FirstName'] . " " . $row['LastName'] . "<br>";
            echo "<b> Age : </b>" . $row['Age'] . "<br>";
            echo "<b> Gender : </b>" . $row['Gender'] . "<br>";
            echo "<b> Phone : </b>" . $row['ContactNumber'] . "<br>";
            echo "<b> Address : </b>" . $row['Address'] . "<br>";
            echo "<br> <hr>";   

        }
    }
    else{
        echo "Currently, there are no patients.";
    }

?>