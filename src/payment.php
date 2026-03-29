<?php
    session_start();
    include "header.php";
    include "database.php";
    
    if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName'])) {   
        // Redirect back if session variables are missing or if someone accesses this page directly!
        header("Location: appointment.php");
        exit();
    }
?>

<html>
<head>
    <title>Payment</title>
</head>
<body>
<center><h1>Bills</h1>  </center>

<form action="payment.php" method="post">

<?php
    echo "<h3>PATIENT DETAILS</h3>";
    echo "<b>Name : </b>" . $_SESSION['firstName'] . " " . $_SESSION['lastName'] . "<br><br>";
    echo "<b>Phone : </b>" . $_SESSION['phone'] . "<br><br>";

    echo "<h3>DOCTOR DETAILS</h3>";

    // Fetch doctor details from database
    $doctorID = $_SESSION['doctor'];
    $result = mysqli_query($conn, "SELECT FirstName, LastName, DeptName, Charges FROM doctors WHERE LicenseNum = '$doctorID';");

    $doc = mysqli_fetch_assoc($result);
    echo "<b>Name : </b>" . $doc['FirstName'] . " ". $doc['LastName']. "<br><br>";
    echo "<b>Department :  </b>" . $doc['DeptName'] . "<br><br>";
    echo "<b>Consultation Fees : € </b>" . $doc['Charges'] . "<br><br>";

    echo "<h3>APPOINTMENT DETAILS</h3>";
    echo "<b>Date and Time : </b>" . date($_SESSION['app_date']); 

    echo "<h3>PAYMENT</h3>";
    echo "<b>Appoinment Charges : € </b>" . $doc['Charges']; 
    echo "<br><br><b>Fixed Charges : € </b>20";

    $total = (($doc['Charges']) + 20) * 0.35 + $doc['Charges'] + 20;
    echo "<h4>Your Total (including TAX) : € $total </h4>";

?>
    Please select Mode of Payment : 
        <input type="radio" name="payment" value="Cash" checked> Cash
        <input type="radio" name="payment" value="Credit"> Credit Card
        <input type="radio" name="payment" value="Insurance"> Insurance <br><br>
    
    <button type="submit" name="book">Book Appointment</button>
    <button type="submit" name="cancel">Cancel</button>


</form>
</body>
</html>

<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_POST['cancel'])){
        header("Location: appointment.php");  
    }
    elseif(isset($_POST['book'])){
            if ($_POST['payment'] == "Insurance" && !isset($_SESSION['insurance'])){
                echo "<b>You don't have insurance. Choose another Payment method.</b>";
            }
            else{ try{
                mysqli_begin_transaction($conn);

                // Get all data from session
                $firstName = $_SESSION['firstName'];
                $lastName = $_SESSION['lastName'];
                $age = $_SESSION['age'];
                $gender = $_SESSION['gender'];
                $phone = $_SESSION['phone'];
                $address = $_SESSION['address'];
                $TaxCode = $_SESSION['TaxCode'];

                $app_date = $_SESSION['app_date'];
                $doctor = $_SESSION['doctor'];

                if($_POST['payment'] == "Insurance" && $_SESSION['insurance'] == "yes"){
                    $inc_provider = $_SESSION['inc_provider'];
                    $policy_num = $_SESSION['policy_num'];
                    $cover_amt = $_SESSION['cover_amt'];
                    // deduct payment amount from insurance 
                    $cover_amt -= $total;
                }

                // INSERT values into patients
                $q1 = mysqli_query($conn,"INSERT INTO patients (TaxCode, FirstName, LastName, Age, Gender, ContactNumber, Address)
                                            VALUES ('$TaxCode', '$firstName', '$lastName', $age, '$gender', '$phone', '$address');");
 

                //INSERT values into appointments
                $timestamp = time();  
                $q2 = mysqli_query($conn,"INSERT INTO appointments (AppointmentID, PatientID, DoctorID, Date_Time)
                                            VALUES($timestamp,'$TaxCode','$doctor','$app_date');");
                
                $q3 = true; // assume success if no insurance insert is needed

                // INSERT values into insurance
                if($_POST['payment'] == "Insurance" && $_SESSION['insurance'] == "yes"){
                    $q3= mysqli_query($conn,"INSERT INTO insurance (PolicyNumber, InsuranceProvider, CoverageAmount, PatientID) 
                                                VALUES($policy_num,'$inc_provider',$cover_amt,'$TaxCode');");
                }
                // INSERT values into billing
                $payment = $_POST['payment'];
                $q4 = mysqli_query($conn,"INSERT INTO billing (PatientID, AppointmentID, Amount, PaymentMode) 
                                    VALUES('$TaxCode', $timestamp, $total, '$payment');");


                if ($q1 && $q2 && $q3 && $q4) {
                    mysqli_commit($conn);
                    echo "<b>Your Payment was successful. Your appointment has been booked.</b>";
                } else {
                    mysqli_rollback($conn);
                    echo "<b>❌ Error: Could not complete booking. Please try again.</b>";
                }

                mysqli_close($conn);
                } catch (Exception $e) {
                    mysqli_rollback($conn);
                    echo "<b>❌ An exception occurred: " . $e->getMessage() . "</b>";
                }
            }
            

        } 
    
?>