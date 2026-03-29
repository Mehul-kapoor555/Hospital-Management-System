<?php
    include "header.php";
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
</head>
<body>
<center><h1>APPOINTMENT FORM</h1>  </center>
<hr>

<h4> 1. Personal Information </h4> 
<form action = "book_appointment.php" method = "post">
    First Name : <input type="text" name="firstName" required>
    <br><br>
    Last Name : <input type="text" name="lastName" required>
    <br><br>
    Age : <input type="number" name="age" required> 
    <br><br>
    Gender : 
    <input type="radio" name="gender" value="Male" required> Male
    <input type="radio" name="gender" value="Female"> Female
    <br><br>
    Phone Number : <input type="tel" name="phone" required>
    <br><br>
    Codice Fiscale : <input type="text" name="TaxCode" required>
    <br><br>
    Address : <textarea name="address" placeholder="Type your address here" rows="4" cols="30"></textarea>
    <br><br>

    <h4> Fill out only if you have a VALID INSURANCE </h4> 
    <label>Do you have insurance?</label>
        <input type="radio" name="insurance" value="yes"> Yes
        <input type="radio" name="insurance" value="no" checked> No <br><br>
    Insurance Provider : <input type = "text" name = "inc_provider">
    <br><br>
    Policy Number : <input type = "number" name = "policy_num">
    <br><br>
    Coverage Amount : <b>€ </b><input type = "number" name = "cover_amt">
    <br><br>

    <h4> 2. Appointment Details </h4> 
    Preferred Date : <input type="datetime-local" name="app_date" required>
    <br><br>
    Preferred Doctor:
        <select name="doctor" required>
        <option value="">Select Doctor</option>
    <?php
        // Database connection
        include "database.php";

        // Fetch doctors from database
        $result = mysqli_query($conn, "SELECT LicenseNum, FirstName, LastName FROM doctors;");

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['LicenseNum'] . "'>" . $row['FirstName'] . " ". $row['LastName'] . "</option>";
            }
        }

        // Close connection
        mysqli_close($conn);
    ?>
    </select>
    <br> <br> <br>
    <button type="submit" name="submit">Confirm</button>    
    <button type="submit" name="cancel">Cancel</button>

 </form>
 </body>
 </html>

<?php
    if(isset($_POST['cancel'])){
        header("Location: appointment.php");  
        exit();
    }
    elseif(isset($_POST['submit'])){
        try{
        if(isset($_POST['insurance'])){
            if(($_POST['firstName']!=NULL) && ($_POST['lastName']!=NULL) && ($_POST['age']!=NULL) && ($_POST['gender']!=NULL) && 
            ($_POST['phone']!=NULL) && ($_POST['TaxCode']!=NULL) && ($_POST['address']!=NULL) && ($_POST['app_date']!=NULL) && ($_POST['doctor'])){
            
            // patient details added into session array to access information over multiple pages
            $_SESSION['firstName']=$_POST['firstName'];
            $_SESSION['lastName']=$_POST['lastName'];
            $_SESSION['age']=$_POST['age'];
            $_SESSION['gender']=$_POST['gender'];
            $_SESSION['phone']=$_POST['phone'];
            $_SESSION['address']=$_POST['address'];
            $_SESSION['TaxCode']=$_POST['TaxCode'];

            $_SESSION['app_date']=$_POST['app_date'];
            $_SESSION['doctor']=$_POST['doctor'];
            
            if($_POST['insurance'] == 'yes'){
                $_SESSION['inc_provider']=$_POST['inc_provider'];
                $_SESSION['policy_num']=$_POST['policy_num'];
                $_SESSION['cover_amt']=$_POST['cover_amt'];
                $_SESSION['insurance']=$_POST['insurance'];
            }
            

            header("Location: payment.php");
            exit(); 

        }
    }

    else{
        echo "<h4 align='center'>Please fill in all the details!</h4>";
    }
    
    }
        catch(mysqli_sql_exception $e){
            echo "<h4 align='center'>Something went wrong:(</h4>";
        }
    
    }