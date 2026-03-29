 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
 <?php
    $links = array( "index_manager.php" => "Home page",
                    "appointment.php" => "Appointments",
                    "doctor.php" => "Doctors",    
                    "patients.php" => "Patients",
                    "medicines.php" => "Medicines",
                    "login.php" => "Log Out");  

    $current_page= basename($_SERVER["PHP_SELF"]);
    // Horizontal line before the links
    // echo "<hr>";
    // Let’s iterate through the array
    foreach ($links as $url=>$desc) {
        if ($url == $current_page) {
            echo "<b>$desc</b>&nbsp;&nbsp;";   // nbsp -- non breaking spaces, ensures spacing between links.
        } else {
            echo " <a href=\\mywebsite\\$url>$desc</a>&nbsp;&nbsp;";
        }
    }
    // Horizontal line after the links
    echo "<center><h1>Ospedale Papardo</h1></center>";
    echo "<hr>";
 ?>
 
 </body>
 </html>
